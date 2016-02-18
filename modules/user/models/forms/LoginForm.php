<?php

namespace modules\user\models\forms;

use modules\core\behaviors\PurifierBehavior;
use modules\user\helpers\PasswordHelper;
use modules\user\models\ModuleTrait;
use Yii;
use yii\base\Model;

/**
 * Класс модели для формы авторизации
 *
 * @author MrArthur
 * @since 1.0.0
 */
class LoginForm extends Model
{
    use ModuleTrait;

    /** @var string E-mail */
    public $email;
    /** @var string Пароль */
    public $password;
    /** @var bool Запомнить пользователя */
    public $rememberMe = false;
    protected $user;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // PurifierBehavior
            [
                'class' => PurifierBehavior::className(),
                'textAttributes' => ['email', 'password'],
            ],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Password',
            'rememberMe' => 'Remember me *',
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // email
            ['email', 'required'],
            ['email', 'trim'],
            [
                'email',
                function ($attribute) {
                    if ($this->user !== null) {
                        //vd($this->module->enableUnconfirmedLogin);
                        $confirmationRequired = $this->module->enableConfirmation && !$this->module->enableUnconfirmedLogin;
                        if ($confirmationRequired && !$this->user->getIsConfirmed()) {
                            return $this->addError($attribute, 'You need to confirm your email address');
                        }
                        if ($this->user->getIsBlocked()) {
                           return  $this->addError($attribute, 'user', 'Ваш аккаунт заблокирован');
                        }
                    }
                }
            ],
            [
                'email',
                function ($attribute) {
                    if ($this->user !== null) {
                        $confirmationRequired = $this->module->enableConfirmation && !$this->module->enableUnconfirmedLogin;
                        if ($confirmationRequired && !$this->user->getIsConfirmed()) {
                            $this->addError($attribute, 'user', 'Вы еще не подтвердили свой E-mail');
                        }
                        if ($this->user->getIsBlocked()) {
                            $this->addError($attribute, 'user', 'Ваш аккаунт заблокирован');
                        }
                    }
                }
            ],
            // password
            ['password', 'required'],
            ['password', 'trim'],
            [
                'password',
                function ($attribute) {
                    if ($this->user === null || !PasswordHelper::validate(
                            $this->password,
                            $this->user->password_hash
                        )
                    ) {
                        $this->addError($attribute, 'Invalid login or password');
                    }
                }
            ],
            // rememberMe
            ['rememberMe', 'boolean'],
        ];
    }

    /**
     * Авторизирует пользователя по email и password
     *
     * @return bool Результат авторизации
     */
    public function login()
    {
        return Yii::$app->user->login($this->user, $this->rememberMe ? $this->module->rememberFor : 0);
    }

    /** @inheritdoc */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->user = $this->module->manager->findUserByEmail($this->email);
            return true;
        } else {
            return false;
        }
    }
}
