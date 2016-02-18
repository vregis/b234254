<?php

namespace modules\user;

use modules\core\base\Module as CommonModule;
use modules\user\models\Profile;
use modules\user\models\User;
use Yii;
use yii\helpers\FileHelper;
use yii\web\GroupUrlRule;

/**
 * Модуль [[user]] - common
 *
 * Осуществляет всю работу с пользователями
 *
 * @property string $avatarUrl
 * @property ModelManager $manager
 * @property Mailer $mailer
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Module extends CommonModule
{
    /** @inheritdoc */
    const VERSION = '1.0.0';

    /** @var bool Включить регистрацию */
    public $enableRegistration = true;
    /** @var bool Whether to remove password field from registration form. */
    public $enableGeneratingPassword = false;
    /** @var bool Включить активацию аккаунта */
    public $enableConfirmation = true;
    /** @var bool Whether to allow logging in without confirmation. */
    public $enableUnconfirmedLogin = false;
    /** @var bool Включить восстановление пароля */
    public $enablePasswordRecovery = true;
    /** @var int Максимальный размер аватара в байтах */
    public $maxAvatarSize = 5242880; // 5mb
    /** @var int Минимальная ширина аватара */
    public $minAvatarWidth = 300;
    /** @var int Минимальная высота аватара */
    public $minAvatarHeight = 300;
    /** @var int Максимальная ширина аватара */
    public $maxAvatarWidth = 300;
    /** @var int Максимальная высота аватара */
    public $maxAvatarHeight = 300;
    /** @var int Время, на которое запоминать пользователя */
    public $rememberFor = 1209600; // 2 недели
    /** @var int Время, через которое токен активации становится недействительным */
    public $confirmWithin = 86400; // 24 часа
    /** @var int Время, через которое токен восстановления пароля становится недействительным */
    public $recoverWithin = 21600; // 6 часов
    /** @var int Параметр "Вес" для хеширования с помощью Blowfish */
    public $cost = 10;
    /** @var int Время в секундах, в течении которого пользователь считается онлайн */
    public $onlineTime = 300;
    /** @var bool Авторизация только через Steam */
    public $onlySteam = false;
    /** @var string Steam API key */
    public $steamApiKey;
    
    /** @inheritdoc */
    public function getUrlRules()
    {
        return new GroupUrlRule([
            'prefix' => 'user',
            'rules' => [
                //'login/steam' => 'steam/login',
                'security/login' => 'security/login',
                '<_a:(login|logout)>' => 'security/<_a>',
                //'<_a:(register|resend)>' => 'registration/<_a>',
                'registration/confirm/<id:\d+>/<token:[\w\-]+>' => 'registration/confirm',
                //'recovery/change/<id:\d+>/<token:[\w\-]+>' => 'recovery/change',
                //'settings/<_a:[\w\-]+>' => 'settings/<_a>',
                //'social/<_a:[\w\-]+>/<service:[\w\-]+>' => 'social/<_a>',
                //'social/<_a:[\w\-]+>' => 'social/<_a>',
                '/' => 'default/index',
                '<id:\d+>' => 'profile/profile',
                '<_c:[\w-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
            ]
        ]);
    }
//  
	
    public $inMenu = true;

    /** @inheritdoc */
    public function getCategory()
    {
        return 'Структура';
    }

    /** @inheritdoc */
    public function getTitle()
    {
        return 'Users';
    }

    /** @inheritdoc */
    public function __construct($id, $parent = null, $config = [])
    {
        foreach ($this->getModuleComponents() as $name => $component) {
            if (!isset($config['components'][$name])) {
                $config['components'][$name] = $component;
            } elseif (is_array($config['components'][$name]) && !isset($config['components'][$name]['class'])) {
                $config['components'][$name]['class'] = $component['class'];
            }
        }
        parent::__construct($id, $parent, $config);
    }

    /** @inheritdoc */
    public function init()
    {
        parent::init();
    }

    /** @inheritdoc */
    public function getDependencies()
    {
        return ['core', 'mail'];
    }

    /**
     * Возвращает компоненты модуля
     *
     * @return array
     */
    protected function getModuleComponents()
    {
        return [
            'manager' => ['class' => 'modules\user\ModelManager'],
            'mailer' => ['class' => 'modules\user\Mailer']
        ];
    }

    /**
     * Возвращает полный путь к аватару пользователя
     *
     * @param null $user_id
     * @return string
     */
    public function getAvatarPath($user_id = null)
    {
        $user_id = empty($user_id) ? Yii::$app->user->id : $user_id;

        // создаем директорию пользователя, если ее еще нет
        self::createUserDir($user_id);

        return $this->getUserDir($user_id) . '/avatar.jpg';
    }

    /**
     * Получение URL к аватару по $user_id, либо для текущего пользователя
     *
     * @param int|null $user_id
     * @param bool $reload Добавить в конец ссылки рандомные цифры, чтобы обновить картинку (кеш)
     * @return string
     */
    public function getAvatarUrl($user_id = null, $reload = false)
    {
        $user_id = $user_id === null && !Yii::$app->user->isGuest ? Yii::$app->user->id : $user_id;

        if (file_exists($this->getAvatarPath($user_id) )) {
            $url = $this->getUserDirUrl($user_id) . '/avatar.jpg';
            return $reload ? $url . '?' . time() : $url;
        } else {
            // Если есть зашел через социальную сеть
            $a = $this->manager->findProfileByUserId($user_id);
            if($a->avatar_social && $a->avatar_social !=''){
                return $a->avatar_social;

            }
            if ($user_id == Yii::$app->user->id) {
                /** @var User $identity */
                $identity = Yii::$app->user->identity;
                $profile = $identity->profile;
            } else {
                $profile = $this->manager->findProfileByUserId($user_id);
            }
            return $this->getDefaultAvatarUrl($profile === null ? Profile::GENDER_MALE : $profile->gender);
        }
    }

    /**
     * Возвращает URL к дефолтной аватарке
     *
     * @param int $gender
     * @return string
     */
    public function getDefaultAvatarUrl($gender = Profile::GENDER_MALE)
    {
        $file = $gender == Profile::GENDER_FEMALE ? 'avatar_f.png' : 'avatar_m.png';
        return Yii::$app->params['staticDomain'] . 'default/' . $file;
    }

    /**
     * Создает директорию пользователя
     *
     * @param $user_id
     * @return bool
     */
    public function createUserDir($user_id)
    {
        return FileHelper::createDirectory($this->getUserDir($user_id));
    }

    /**
     * Возвращает путь к директории пользователя
     *
     * @param $user_id
     * @return bool|string
     */
    public function getUserDir($user_id = null)
    {
        $user_id = empty($user_id) ? Yii::$app->user->id : $user_id;
        return Yii::getAlias('@static') .  '/web/user/' . $user_id;
    }

    /**
     * Возвращает URL к директории пользователя
     *
     * @param null $user_id
     * @return bool|string
     */
    public function getUserDirUrl($user_id = null)
    {
        $user_id = empty($user_id) ? Yii::$app->user->id : $user_id;
        return Yii::$app->params['staticDomain'] . 'user/' . $user_id;
    }
}