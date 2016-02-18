<?php

namespace modules\chat\models;

use Yii;

/**
 * This is the model class for table "@_chat.message_common".
 *
 * @property string $id
 * @property integer $sender_id
 * @property string $message
 * @property integer $created_at
 * @property integer $status
 * @property string $file
 * @property integer $is_sounded
 *
 * @property User $sender
 */
class MessageCommon extends \yii\db\ActiveRecord
{
        /** @inheritdoc */
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            // устанавливаем точное время для сообщения
            if ($this->isNewRecord) {
                $this->created_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Yii::$app->params['dbname'].'_chat.message_common';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender_id', 'message'], 'required'],
            [['id', 'sender_id', 'created_at', 'status', 'is_sounded'], 'integer'],
            [['message', 'file'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'message' => Yii::t('app', 'Message'),
            'created_at' => Yii::t('app', 'Created At'),
            'status' => Yii::t('app', 'Status'),
            'file' => Yii::t('app', 'прикрепленные картинки'),
            'is_sounded' => Yii::t('app', '0-не проигранн, 1-проигран'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }
}
