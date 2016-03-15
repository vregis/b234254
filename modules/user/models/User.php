<?php

namespace modules\user\models;

use modules\core\base\ActiveRecord;
use modules\core\behaviors\PurifierBehavior;
use modules\core\helpers\TextHelper;
use modules\user\helpers\PasswordHelper;
use RuntimeException;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\IdentityInterface;

/**
 * Модель для таблицы "{{%user}}"
 *
 * @property int $id
 * @property int $role
 * @property string  $username
 * @property string  $email
 * @property string  $password_hash
 * @property string  $auth_key
 * @property string  $unconfirmed_email
 * @property int $registration_ip
 * @property int $confirmed_at
 * @property int $blocked_at
 * @property int $created_at
 * @property int $updated_at
 * @property string $address
 * @property float $balance
 *
 * @property string $fullName
 *
 * @property Profile $profile
 * @property SocialAccount[] $socialAccounts
 *
 * @author MrArthur
 * @since 1.0.0
 */
class User extends ActiveRecord implements IdentityInterface
{
    use ModuleTrait;

    /** Роли пользователей */
    const ROLE_USER = 1;
    const ROLE_MODERATOR = 5;
    const ROLE_TESTER = 6;
    const ROLE_ADMIN = 10;

    /** События */
    const USER_CREATE_INIT = 'user_create_init';
    const USER_CREATE_DONE = 'user_create_done';
    const USER_REGISTER_INIT = 'user_register_init';
    const USER_REGISTER_DONE = 'user_register_done';

    const TYPE_EMPLOYER = 0;   //Тот кто делегирует (Люси)
    const TYPE_SPECIALIST = 1; //Тот кто принимает делегирование (Стив)

    const STATUS_CREATION = 0;
    const STATUS_ROADMAP_PASSED = 1;
    const STATUS_TEST_PASSED = 2;
    const STATUS_PROFILE_FILLED = 3;
    const STATUS_IDEA_SHOWS = 4;
/*    static public $status_creation = 0;
    static public $status_roadmap_passed = 1;
    static public $status_test_passed = 2;
    static public $status_profile_filled = 3;*/

    /** ID системного пользователя, с которого будут приходить уведовления и т.п. */
    const SYSTEM_USER_ID = 2;

    public $fname;
    public $lname;
    public $tool;
    public $ava;
    public $level;
    public $rate_h;
    public $country;
    public $city;
    /** @var string Не хешированный пароль. Используется для валидации */
    public $password;
    public $is_active = true;
    public $task_user;
    public $task_name;
    public $task_desc;
    public $task_id;
    public $task_special;
    public $task_rate;
    public $task_user_time;
    public $task_user_price;
    public $delegate_id;
    public $delegate_user_id;
    public $is_delegate;
    public $dname;
    public $uid;


    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // TimestampBehavior
            [
                'class' => TimestampBehavior::className(),
            ],
            // PurifierBehavior
            [
                'class' => PurifierBehavior::className(),
                'textAttributes' => [ 'email', 'address'],
            ],
        ];
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return 'user';
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => Yii::t('user', 'Роль пользователя'),
            'username' => Yii::t('user', 'Логин'),
            'email' => Yii::t('user', 'E-mail'),
            'password' => Yii::t('user', 'Пароль'),
            'password_hash' => Yii::t('user', 'Пароль'),
            'auth_key' => Yii::t('user', 'Ключ авторизации'),
            'unconfirmed_email' => Yii::t('user', 'Новый e-mail'),
            'registration_ip' => Yii::t('user', 'Регистрационный IP'),
            'confirmed_at' => Yii::t('user', 'Дата подтверждения регистрации'),
            'blocked_at' => Yii::t('user', 'Дата блокировки'),
            'created_at' => Yii::t('user', 'Время регистрации'),
            'updated_at' => Yii::t('user', 'Время обновления'),
            'address' => Yii::t('user', 'Адрес страницы пользователя (заместо id)'),
            'balance' => Yii::t('user', 'Баланс пользователя'),
            'password_repeat' => Yii::t('user', 'Повторите пароль'),
        ];
    }

    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'default' => ['balance'],
            'register' => ['username', 'email', 'password'],
            'connect' => ['username', 'email'],
            'create' => ['username', 'email', 'password', 'role'],
            'update' => ['username', 'email', 'password', 'role'],
            'social' => ['username', 'email'],
            'changeUsername' => ['username'],
            'steamComplete' => ['email'],
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // username
            ['username', 'required', 'on' => ['register', 'connect', 'create', 'update', 'social', 'changeUsername']],
            ['username', 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', 'unique'],
            // email
            [
                'email',
                'required',
                'on' => ['register', 'connect', 'create', 'update', 'steamComplete']
            ],
            ['email', 'trim'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique'],
            // password
            ['password', 'required', 'except' => ['update']],
            ['password', 'trim'],
            ['password', 'string', 'min' => 6],

            ['user_type','integer']
            // role
            //['role', 'default', 'value' => self::ROLE_USER, 'on' => ['update']],
            //['role', 'in', 'range' => array_keys(self::getRolesArray()), 'on' => ['update']],
            // balance
            //[['balance'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
        ];
    }

    /** @inheritdoc */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /** @inheritdoc */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" не реализована');
    }

    /**
     * Проверяет, активирован пользователь или нет
     *
     * @return bool
     */
    public function getIsConfirmed()
    {
        return !empty($this->confirmed_at);
    }

    /**
     * @return bool Пользователь заблокирован
     */
    public function getIsBlocked()
    {
        return !empty($this->blocked_at);
    }

    /**
     * @return bool Пользователь является администратором сайта
     */
    public function getIsAdmin()
    {
        return Yii::$app->user->can('admin', ['user' => $this]);
    }

    /**
     * @return bool Пользователь является супер-администратором сайта
     */
    public function getIsSuperAdmin()
    {
        if($this->id == 1){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return bool Пользователь является системным
     */
    public function getIsSystem()
    {
        if($this->id == 2){
            return true;
        }else{
            return false;
        }
    }

    /** @return \yii\db\ActiveQuery */
    public function getProfile()
    {
        return $this->hasOne($this->module->manager->profileClass, ['user_id' => 'id']);
    }

    /** @return \yii\db\ActiveQuery */
    public function getSocialAccounts()
    {
        $connected = [];
        $accounts = $this->hasMany($this->module->manager->socialAccountClass, ['user_id' => 'id'])->all();

        /** @var SocialAccount $account */
        foreach ($accounts as $account) {
            $connected[$account->provider] = $account;
        }

        return $connected;
    }

    /** @inheritdoc */
    public function getId()
    {
        return $this->id;
    }

    /** @inheritdoc */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /** @inheritdoc */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /** @inheritdoc */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }

    /**
     * Создает нового пользователя
     *
     * This method is used to create new user account. If password is not set, this method will generate new 8-char
     * password. After saving user to database, this method uses mailer component to send password to user via email.
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function create()
    {
        if (!$this->isNewRecord) {
            throw new RuntimeException('Вызов "' . __CLASS__ . '::' . __METHOD__ . '" для существующего пользователя');
        }

        if (!$this->module->enableConfirmation) {
            $this->confirmed_at = time();
        }

        if ($this->password == null) {
            $this->password = PasswordHelper::generate(8);
        }

        $this->trigger(self::USER_CREATE_INIT);

        if ($this->save()) {
            $this->trigger(self::USER_CREATE_DONE);
            $this->module->mailer->sendWelcomeMessage($this);
            Yii::info('Пользователь ' . $this->id . ' успешно создан');
            return true;
        }
        Yii::error('Ошибка при создании аккаунта пользователя ' . $this->id);
        return false;
    }

    /**
     * Регистрирует пользователя
     *
     * This method is used to register new user account. If Module::enableConfirmation is set true, this method
     * will generate new confirmation token and use mailer to send it to the user. Otherwise it will log the user in.
     * If Module::enableGeneratingPassword is set true, this method will generate new 8-char password. After saving user
     * to database, this method uses mailer component to send password to user via email.
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function register()
    {

        if (!$this->isNewRecord) {
            throw new RuntimeException('Вызов "' . __CLASS__ . '::register()" для существующего пользователя');
        }


        if (!$this->module->enableConfirmation) {

            $this->confirmed_at = time();
        }else{
            $this->confirmed_at = '*';// делаю имаил не подтвержденным
        }

        if ($this->module->enableGeneratingPassword) {
            $this->password = PasswordHelper::generate(8);
        }
      // vd($this);
        //$this->username =  $this->email;

        $this->trigger(self::USER_REGISTER_INIT);

        //$this->validate();
        //vd($this->getErrors());
        //vd($this);
        $previous = Url::previous();
        if($previous == Url::toRoute(['/departments']) || $previous == Url::toRoute(['/departments?start=1'])) {
            $this->user_type = User::TYPE_EMPLOYER;
        }
        else {
            $this->user_type = User::TYPE_SPECIALIST;
            $this->user_registration_type = 1;
        }
        if ($this->save()) {

            $this->trigger(self::USER_REGISTER_DONE);
            if ($this->module->enableConfirmation) {
                //vd(23);
                $token = $this->module->manager->createToken(['type' => Token::TYPE_CONFIRMATION]);

                $token->link('user', $this);
                //vd($token );
                $this->module->mailer->sendConfirmationMessage($this, $token);
                //Временно пока не работает крон
                $this->module->mailer->sendConfirmationMessageImmidiatly($this);
            } else {
                //vd(2);
                Yii::$app->user->login($this);
            }
            if ($this->module->enableGeneratingPassword) {
                $this->module->mailer->sendWelcomeMessage($this);
            }
            Yii::info('Пользователь ' . $this->id . 'зарегистрирован');
            return true;
        }

        Yii::error('Произошла ошибка при регистрации пользователя' . $this->id);

        return false;
    }

    public function registerSocial($avatar)
    {

        if (!$this->isNewRecord) {
            throw new RuntimeException('Вызов "' . __CLASS__ . '::register()" для существующего пользователя');
        }else{

        }

        $this->confirmed_at = time();

        if ($this->module->enableGeneratingPassword) {
            $this->password = PasswordHelper::generate(8);
        }
        // vd($this);
        //$this->username =  $this->email;

        $this->trigger(self::USER_REGISTER_INIT);

        //$this->validate();
        //vd($this->getErrors());
        //vd($this);
        if ($this->save()) {

            // ToDo Создать профайл
            $dublicateProfile = Profile::find()->where(['user_id' => $this->id])->one();
            if($dublicateProfile){
                // vd('$avatar');die;return;
                //$_modelProfile = new Profile();
//                $_modelProfile->user_id = $this->id ;
                if($avatar != '') {
                    $dublicateProfile->avatar_social = $avatar;

                    //$_modelProfile->validate();
                    ///vd($_modelProfile->getErrors());
                    //die;
                    $dublicateProfile->updateAttributes(['avatar_social']);
                }
            }





            $this->trigger(self::USER_REGISTER_DONE);
            if ($this->module->enableConfirmation) {
                //vd(23);
                $token = $this->module->manager->createToken(['type' => Token::TYPE_CONFIRMATION]);

                $token->link('user', $this);
                Yii::$app->user->login($this);
                //vd($token );
                //$this->module->mailer->sendConfirmationMessage($this, $token);
                //Временно пока не работает крон
                // $this->module->mailer->sendConfirmationMessageImmidiatly($this);
            } else {
                //vd(2);
                Yii::$app->user->login($this);
            }
            if ($this->module->enableGeneratingPassword) {
                $this->module->mailer->sendWelcomeMessage($this);
            }
            Yii::info('Пользователь ' . $this->id . 'зарегистрирован');
            return true;
        }

        Yii::error('Произошла ошибка при регистрации пользователя' . $this->id);

        return false;
    }

    /**
     * This method attempts user confirmation. It uses model manager to find token with given code and if it is expired
     * or does not exist, this method will throw exception.
     *
     * If confirmation passes it will return true, otherwise it will return false.
     *
     * @param  string $code Confirmation code.
     * @return bool
     */
    public function attemptConfirmation($code)
    {
        $token = $this->module->manager->findToken($this->id, $code, Token::TYPE_CONFIRMATION);

        if ($token === null || $token->getIsExpired()) {
            return false;
        }

        $token->delete();

        if (!empty($this->unconfirmed_email)) {
            $this->email = $this->unconfirmed_email;
            $this->unconfirmed_email = null;
        }

        $this->confirmed_at = time();

        Yii::info('Пользователь ' . $this->id . ' активирован');

        return $this->save(false);
    }

    /**
     * Изменяет пароль пользователя
     *
     * @param  string $password
     * @return bool
     */
    public function resetPassword($password)
    {
        return (bool)$this->updateAttributes(['password_hash' => PasswordHelper::hash($password)]);
    }

    /**
     * Confirms the user by setting 'blocked_at' field to current time.
     */
    public function confirm()
    {
        return (bool)$this->updateAttributes(['confirmed_at' => time()]);
    }

    /**
     * Blocks the user by setting 'blocked_at' field to current time.
     */
    public function block()
    {
        return (bool)$this->updateAttributes(['blocked_at' => time()]);
    }

    /**
     * Разблокирует пользователя
     *
     * @return bool
     */
    public function unblock()
    {
        return (bool)$this->updateAttributes(['blocked_at' => null]);
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->auth_key = Yii::$app->security->generateRandomString();
            if (Yii::$app instanceof Application) {
                $this->registration_ip = ($ip2long = ip2long(Yii::$app->request->userIP)) ? $ip2long : null;
            }
        }

        if (!empty($this->password)) {
            $this->password_hash = PasswordHelper::hash($this->password);
        }

        $this->balance = str_replace(',', '.', $this->balance);

        return parent::beforeSave($insert);
    }

    /** @inheritdoc */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            // создаем профиль пользователя
            $profile = $this->module->manager->createProfile(['user_id' => $this->id]);
            $profile->save(false);
            // создаем директорию пользователя
            //$this->module->createUserDir($this->id);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Формирует полное имя из имени и фамилии пользователя
     *
     * @return string
     */
    public function getFullName()
    {
        if (!empty($this->profile->first_name) && !empty($this->profile->last_name)) {
            return $this->profile->first_name . ' ' . $this->profile->last_name;
        }
        return null;
    }
    /**
     * Формирует полное имя из id
     *
     * @return string
     */
    public static function getFullNameById($id)
    {
        $model = self::findIdentity($id);      
        return $model->username;
    }

    /**
     * Устанавливает unconfirmed_email и отправляет письмо с ссылкой на подтверждение
     *
     * @param $new_email
     * @return bool
     */
    public function changeEmail($new_email)
    {
        if (empty($new_email)) {
            return false;
        }
        $this->unconfirmed_email = $new_email;
        $this->updateAttributes(['unconfirmed_email']);
        $token = $this->module->manager->createToken(
            [
                'user_id' => $this->id,
                'type' => Token::TYPE_CONFIRMATION
            ]
        );
        return ($token->save(false) && $this->module->mailer->sendReconfirmationMessage($this, $token));
    }

    /**
     * Меняет пароль пользователя
     *
     * @param $new_password
     * @return bool
     */
    public function changePassword($new_password)
    {
        if (empty($new_password)) {
            return false;
        }
        $this->password_hash = PasswordHelper::hash($new_password);
        return $this->updateAttributes(['password_hash']);
    }

    /**
     * Возвращает массив с ролями пользователей (код роли => название)
     *
     * @return array
     */
    public static function getRolesArray()
    {
        return [
            self::ROLE_USER => 'Пользователь',
            self::ROLE_MODERATOR => 'Модератор',
            self::ROLE_TESTER => 'Тестеровщик',
            self::ROLE_ADMIN => 'Администратор',
        ];
    }

    /**
     * Если пользователь заполнил address - возвращает его
     * Иначе возвращает ID пользователя
     *
     * @return int|string
     */
    public function getPageAddress()
    {
        return $this->address === null ? $this->id : $this->address;
    }

    /**
     * Сравнивает текущий ник пользователя с ником, полученным из Steam
     * Если не совпдают - меняет текущий ник на ник из Steam
     *
     * @param string $personaname Ник полученный из Steam API
     * @return bool
     */
    public function changeUsernameFromSteam($personaname)
    {
        $personaname = TextHelper::filterString($personaname);
        $this->username = $oldUsername = TextHelper::filterString($this->username);

        if (empty($personaname)) {
            return false;
        }

        if ($personaname !== $this->username && $personaname . $this->id !== $this->username) {
            $usernameExists = $this->module->manager->findUserByUsername($personaname);
            $this->username = $usernameExists === null ? $personaname : $personaname . $this->id;
            $this->scenario = 'changeUsername';
            if ($this->save(true, ['username'])) {
                // обновляем историю смены никнейма
                $usernameHistory = new UsernameHistory();
                $usernameHistory->user_id = $this->id;
                $usernameHistory->old_username = $oldUsername;
                $usernameHistory->new_username = $this->username;
                $usernameHistory->save();
                return true;
            }
        }

        return false;
    }

    /**
     * Есть ли у пользователя аватар
     *
     * @return bool
     */
    public function hasAvatar()
    {
        $userMod = Yii::$app->getModule('user');
        return file_exists($userMod->getAvatarPath());
    }

    public static function getRole(){
        $role = yii::$app->user->identity->role;

        switch ($role) {
            case 1:
                return "Пользователь";
                break;
            case 5:
                return "<span class='glyphicon glyphicon-pawn' style='color:#008000'></span><strong> Модератор</strong>";
                break;
            case 6:
                return "<span class='fa fa-frown-o' style='color:#7f807b'></span><strong> Тестеровщик</strong>";
                break;
            case 10:
                if(Yii::$app->user->id == 1){
                    return "<span class='glyphicon glyphicon-king' style='color:#e20000'></span><strong> Супер Админ</strong>";
                }else{
                    return "<span class='glyphicon glyphicon-queen' style='color:#b90000'></span><strong> Админ</strong>";
                }
                break;
        }
    }

    public static function getRoleByUserId($user_id){
        $model = User::findOne($user_id);
          if($model){
            return $model->role;
        }else{
            false;
        }
    }
}