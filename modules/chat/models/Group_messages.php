<?php
namespace modules\chat\models;

use Yii;

/**
 * This is the model class for table "@_chat.group_messages".
 *
 * @property string $id
 * @property integer $group_id
 * @property integer $sender_id
 * @property string $message
 * @property integer $created_at
 * @property integer $status
 * @property string $file
 * @property integer $is_sounded
 */
class Group_messages extends \yii\db\ActiveRecord
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
        return Yii::$app->params['dbname'].'_chat.group_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'sender_id', 'message', 'created_at'], 'required'],
            [['group_id', 'sender_id', 'created_at', 'status', 'is_sounded'], 'integer'],
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
            'group_id' => Yii::t('app', 'Group ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'message' => Yii::t('app', 'Message'),
            'created_at' => Yii::t('app', 'Created At'),
            'status' => Yii::t('app', 'Status'),
            'file' => Yii::t('app', 'прикрепленные картинки'),
            'is_sounded' => Yii::t('app', '0-не проигранн, 1-проигран'),
        ];
    }
}