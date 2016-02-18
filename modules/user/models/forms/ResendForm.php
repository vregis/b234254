<?php

namespace modules\user\models\forms;

use modules\core\behaviors\PurifierBehavior;
use modules\user\models\ModuleTrait;
use modules\user\models\Token;
use Yii;
use yii\base\Model as YiiModel;

/**
 * Класс модели для повторной отправки ключей активации на почту
 *
 * @author MrArthur
 * @since 1.0.0
 */
class ResendForm extends YiiModel
{
    use ModuleTrait;

    /**
     * @var string E-mail для повторной активации
     */
    public $email;
    private $_user = null;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // PurifierBehavior
            [
                'class' => PurifierBehavior::className(),
                'textAttributes' => ['email'],
            ],
        ];
    }

    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = $this->module->manager->findUserByEmail($this->email);
        }
        return $this->_user;
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('user', 'E-mail'),
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
                'message' => Yii::t('user', 'Пользователя с таким e-mail не существует')
            ],
            ['email', 'validateEmail'],
        ];
    }

    /**
     * Проверяет, не активирован ли уже E-mail
     */
    public function validateEmail()
    {
        if ($this->getUser() !== null && $this->getUser()->getIsConfirmed()) {
            $this->addError('email', Yii::t('user', 'Этот аккаунт уже активирован'));
        }
    }

    /**
     * Создает новый токены и отправляет их пользователю
     *
     * @return bool
     */
    public function resend()
    {
        $token = $this->module->manager->createToken(
            [
                'user_id' => $this->getUser()->id,
                'type' => Token::TYPE_CONFIRMATION
            ]
        );
        $token->save(false);
        return $this->module->mailer->sendConfirmationMessage($this->getUser(), $token);
    }
}