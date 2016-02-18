<?php

namespace modules\user\models\forms;

use modules\core\behaviors\PurifierBehavior;
use modules\user\models\ModuleTrait;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Класс модели для формы смены пароля
 *
 *
 * @author MrArthur
 * @since 1.0.0
 */
class RecoveryForm extends Model
{
    use ModuleTrait;

    /** @var null|\common\modules\user\models\Token */
    public $token = null;
    /** @var string Пароль */
    public $password;
    /** @var string Подтверждение пароля */
    public $password_repeat;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // PurifierBehavior
            [
                'class' => PurifierBehavior::className(),
                'textAttributes' => ['password', 'password_repeat'],
            ],
        ];
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidParamException
     */
    public function init()
    {
        parent::init();
        if ($this->token === null) {
            throw new InvalidParamException(Yii::t('user', 'Не удалось получить токен'));
        }

        if ($this->token->getIsExpired() || $this->token->user === null) {
            throw new InvalidParamException('user', 'Неправильный токен');
        }
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('user', 'Пароль'),
            'password_repeat' => Yii::t('user', 'Повторите пароль'),
        ];
    }

    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'default' => ['password', 'password_repeat']
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // password
            [['password'], 'required'],
            [['password'], 'string', 'min' => 6],
            // password_repeat
            [['password_repeat'], 'required'],
            [['password_repeat'], 'string', 'min' => 6],
            [
                'password_repeat',
                'compare',
                'compareAttribute' => 'password',
                'message' => Yii::t('user', 'Пароли не совпадают')
            ],
        ];
    }

    /**
     * Сбрасывает пароль пользователя
     *
     * @return bool
     */
    public function resetPassword()
    {
        $this->token->user->resetPassword($this->password);
        $this->token->delete();
        return true;
    }
}