<?php

namespace modules\user\models;

use modules\core\base\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * Модель для таблицы "{{%user_social_account}}"
 *
 * @property int $id
 * @property int $user_id
 * @property string $provider
 * @property string $client_id
 * @property string $data
 * @property int $created_at
 *
 * @property $user User
 *
 * @author MrArthur
 * @since 1.0.0
 */
class SocialAccount extends ActiveRecord
{
    use ModuleTrait;

    /** @var array информация о пользователе из соц. сети */
    private $_data;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // TimestampBehavior
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return 'user_social_account';
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne($this->module->manager->userClass, ['id' => 'user_id']);
    }

    /**
     * Подключена ли соц. сеть у пользователя
     *
     * @return bool
     */
    public function getIsConnected()
    {
        return $this->user_id !== null;
    }

    /**
     * Кодирует свойства в JSON
     *
     * @return mixed
     */
    public function getDataArray()
    {
        if (empty($this->_data)) {
            $this->_data = Json::decode($this->data);
        }
        return $this->_data;
    }
}