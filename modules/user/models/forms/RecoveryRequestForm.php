<?php

namespace modules\user\models\forms;

use modules\core\behaviors\PurifierBehavior;
use modules\user\models\ModuleTrait;
use modules\user\models\Token;
use modules\user\models\User;
use Yii;
use yii\base\Model;

/**
 * Класс модели для формы восстановления пароля
 *
 * @author MrArthur
 * @since 1.0.0
 */
class RecoveryRequestForm extends Model
{
    use ModuleTrait;

    /** @var string */
    public $email;
    /** @var string Каптча */
    public $captcha;
    /** @var User */
    private $_user;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // PurifierBehavior
            [
                'class' => PurifierBehavior::className(),
                'textAttributes' => ['email', 'captcha'],
            ],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('user', 'E-mail'),
            'captcha' => Yii::t('user', 'Проверочный код'),
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // email
            ['email', 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            [
                'email',
                'exist',
                'targetClass' => $this->module->manager->userClass,
                'message' => Yii::t('yii', 'Пользователя с таким e-mail не существует')
            ],
            [
                'email',
                function ($attribute) {
                    $this->_user = $this->module->manager->findUserByEmail($this->email);
                    if ($this->_user !== null && $this->module->enableConfirmation && !$this->_user->getIsConfirmed()) {
                        $this->addError($attribute, Yii::t('user', 'Необходимо активировать аккаунт'));
                    }
                }
            ],
            // captcha
            //['captcha', 'required'],
            //['captcha', 'captcha', 'captchaAction' => '/core/default/captcha'],
        ];
    }

    /**
     * Отправляет письмо с ссылкой на восстановление пароля
     *
     * @return bool
     */
    public function sendRecoveryMessage()
    {
        $token = $this->module->manager->createToken(
            [
                'user_id' => $this->_user->id,
                'type' => Token::TYPE_RECOVERY
            ]
        );
        if ($token->save(false) && $this->module->mailer->sendRecoveryMessage($this->_user, $token)) {
            return true;
        }
        return false;
    }
}