<?php

namespace modules\user\models\forms;

use modules\core\behaviors\PurifierBehavior;
use modules\user\models\ModuleTrait;
use modules\user\models\User;
use Yii;
use yii\base\Model;

/**
 * Класс модели для формы регистрации
 *
 * @author MrArthur
 * @since 1.0.0
 */
class RegistrationForm extends Model
{
    use ModuleTrait;

    public $username;
    /** @var string E-mail */
    public $email;
    /** @var string Пароль */
    public $password;
    /** @var string Повтор пароля */
    public $password_repeat;
    /** @var string Каптча */
    public $captcha;
    /** @var bool Согласен с условиями */
    public $agree;
    /** @var bool Мне есть 18 лет */
    public $im18years;

    public $email_repeat;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // PurifierBehavior
            [
                'class' => PurifierBehavior::className(),
                'textAttributes' => ['email', 'password', 'password_repeat', 'username','agree','im18years', 'email_repeat'],
            ],
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
           /* ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\modules\user\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],*/

            // email
            ['email', 'required'],
            ['email', 'trim'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => $this->module->manager->userClass,
                'message' => Yii::t('user', 'This email is already exists')
            ],

            ['email_repeat', 'string'],
            ['email_repeat', 'trim'],
            ['email_repeat', 'required'],
            [
                'email_repeat',
                'compare',
                'compareAttribute' => 'email',
                'message'=>Yii::t('user', 'Emails do not match')
            ],




            // password
            ['password', 'required'],
            ['password', 'trim'],
            ['password', 'string', 'min' => 6],
            // password_repeat
            ['password_repeat', 'required'],
            ['password', 'trim'],
            ['password_repeat', 'string', 'min' => 6],
            [
                'password_repeat',
                'compare',
                'compareAttribute' => 'password',
                'message' => Yii::t('user', 'Passwords do not match')
            ],
            // captcha
            //['captcha', 'required'],
            //['captcha', 'captcha', 'captchaAction' => '/core/default/captcha'],
            // agree
            //['agree', 'required'],
            //['agree', 'boolean'],
           //['agree','required', 'requiredValue' => 1, 'message' => 'You should accept term to use our service'],
           //['im18years','required', 'requiredValue' => 1, 'message' => 'You should accept term to use our service'],
            // im18years
            //['im18years', 'required'],
            //['im18years', 'boolean'],
            //[['im18years'], 'in', 'range' =>[1=>1]]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['social'] = ['username'];
        return $scenarios;
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password'),
            'password_repeat' => Yii::t('user', 'Repeat password'),
            'captcha' => Yii::t('user', 'Каптча'),
            'agree' => Yii::t('user', 'Согласен с условиями'),
            'im18years' => Yii::t('user', 'Мне есть 18 лет'),
        ];
    }

    /**
     * Регистрирует нового пользователя
     *
     * @return bool
     */
    public function register()
    {
        $user = $this->module->manager->createUser(
            [
                'scenario' => 'register',
                'email' => $this->email,
                'password' => $this->password,
                'username' => $this->email,

            ]
        );
        return $user->register();
    }

    /**
     * Регистрирует нового пользователя через социальную сеть
     *
     * @return bool
     */
    public function registerSocial($avatar)
    {

        $user = $this->module->manager->createUser(
            [
                'scenario' => 'register',
                'email' => $this->email,
                'password' => $this->password,
                'username' => $this->username,


            ]
        );
        //vd($user);
        return $user->registerSocial($avatar);
    }
}