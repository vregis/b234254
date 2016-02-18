<?php

namespace modules\user\models;

use modules\core\base\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%ulog_username_history}}".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $old_username
 * @property string $new_username
 */
class UsernameHistory extends ActiveRecord
{
    /** @inheritdoc */
    public static function tableName()
    {
        return 'ulog_username_history';
    }

    /** @return \yii\db\Connection the database connection used by this AR class. */
    public static function getDb()
    {
        return Yii::$app->get('dbLog');
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // user_id
            [['user_id'], 'integer'],
            [['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            // old_username
            [['old_username'], 'required'],
            [['old_username'], 'trim'],
            [['old_username'], 'string', 'min' => 2, 'max' => 255],
            [['old_username'], 'unique'],
            // new_username
            [['new_username'], 'required'],
            [['new_username'], 'trim'],
            [['new_username'], 'string', 'min' => 2, 'max' => 255],
            [['new_username'], 'unique'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'user_id' => Yii::t('user', 'ID пользователя'),
            'old_username' => Yii::t('user', 'Старый логин'),
            'new_username' => Yii::t('user', 'Новый логин'),
        ];
    }
}
