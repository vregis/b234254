<?php

namespace modules\chat\models;

use Yii;
use modules\chat\models\Group_members;
use modules\chat\models\Group_messages;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "@_chat.message".
 *
 * @property string $id
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property string $subject
 * @property string $message
 * @property integer $created_at
 * @property integer $status
 * @property string $file
 * @property integer $is_sounded
 *
 * @property User $sender
 * @property User $receiver
 */
class Message extends \yii\db\ActiveRecord {

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
    public static function tableName() {
        return Yii::$app->params['dbname'].'_chat.message';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['sender_id', 'receiver_id', 'message', 'created_at'], 'required'],
            [['sender_id', 'receiver_id', 'created_at', 'status', 'is_sounded'], 'integer'],
            [['message', 'file'], 'string'],
            [['subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'sender_id' => Yii::t('app', 'Sender ID'),
            'receiver_id' => Yii::t('app', 'Receiver ID'),
            'subject' => Yii::t('app', 'Subject'),
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
    public function getSender() {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver() {
        return $this->hasOne(User::className(), ['id' => 'receiver_id']);
    }

    /*
     * ruturn int 
     * Count of not readed messages yet
     */

    public static function getMessagesNotRediedYet($id) {
        $model = Friend::find()->where(['user_id' => Yii::$app->user->id, 'friend_id' => $id ])->one();
        if($model){            
            $count_not_read =  $model->count_message_all - $model->count_message_view;
            return $count_not_read;
        }else{
            return false;
        }
        /*
        $model = self::find()->where(['sender_id' => $id, 'receiver_id' => Yii::$app->user->id, 'status' => 0])->all();
        return count($model);        
        */
    }

    // Вывести основной список диалогов
    public static function getallDialogs() {
        $model = self::find()->where(['sender_id' => Yii::$app->user->id])
                ->orWhere(['receiver_id' => Yii::$app->user->id])
                ->andWhere('sender_id != ' . Yii::$app->user->id)
                ->groupBy('sender_id')
                ->all();
        return $model;
    }

    // Общее количество сообщений
    /*
     * return int
     */
    public static function getMessageQuantity() {
        $count_all_massage = 0;
        $model = Friend::find()->where(['user_id' => Yii::$app->user->id])->all();
        if($model){
            foreach ($model as $value) {
                $count_all_massage =   $count_all_massage + $value->count_message_all;
            }        
            return $count_all_massage;
        }else{
            return FALSE;
        }
        
        /*        
        $model = self::find()->where(['sender_id' => Yii::$app->user->id])
                ->orWhere(['receiver_id' => Yii::$app->user->id])
                ->all();
        return count($model);
         
         */
    }

    // количество сообщений от групп : посчитать все 
    /*
     * return int
     */
    public static function getGroupMessageQuantity() {
        
        
        // Получаем группы в которых участвует пользователь
        $model = GroupView::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->groupBy('group_id')
                ->asArray()
                ->all();
        $result = ArrayHelper::map($model, 'id', 'group_id');
        $qaunt = Group::find()->where(['id' => $result])->all();
        $count_message = 0;
        foreach($qaunt as $value){
            $count_message = $count_message + $value['count_message'];
        }
        return $count_message;
        
        /*
        
        // Вывести мои группы или где я участвую
        // Все мои группы
        $model = Group_members::find()
                ->where(['member_id' => Yii::$app->user->id])
                ->groupBy('group_id')
                ->asArray()
                ->all();
        $result = ArrayHelper::map($model, 'id', 'group_id');
        //vd($result);
        //Все мои сообщения
        $qaunt = Group_messages::find()->where(['group_id' => $result])->all();
        vd(count($qaunt));
        return count($qaunt);
         
         */
    }

    // количество сообщений общего чата : посчитать все 
    /*
     * return int
     */
    public static function getMessageCommonQuantity() {
        // Вывести мои группы или где я участвую
        $model = MessageCommon::find()
                ->all();
        return count($model);
    }

}
