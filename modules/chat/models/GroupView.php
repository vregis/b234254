<?php

namespace modules\chat\models;

use Yii;
use modules\chat\models\Group_messages;

/**
 * This is the model class for table "@_chat.group_view".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $view
 */
class GroupView extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return Yii::$app->params['dbname'].'_chat.group_view';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['group_id', 'view'], 'required'],
            [['group_id', 'view'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'view' => Yii::t('app', 'View'),
        ];
    }

    /**
     * @inheritdoc
     * return int вывести разницу между всеми сообщениями группы и просмотренными сообщениями конкретного пользователя
     */
    public static function getMessageQuantityByGroupId($group_id) {
        $model = Group::find()->where(['id' => $group_id])->one();
        $countAll = $model->count_message;
        $model = GroupView::find()->where(['group_id' => $group_id,'user_id'=> Yii::$app->user->id])->one();
        if($model){
            $countUserMessage = $model->view;
            if (!empty($countUserMessage)) {            
                return $countAll - $countUserMessage;
            } else {
                return false;
            }
        }else{
                return false;
        }
        /*
          $countAll = count(Group_messages::find()->where(['group_id' => $group_id])->all());
          $a = self::find()->where(['group_id'=> $group_id,'user_id'=> Yii::$app->user->id])->one();

        if (!empty($a)) {
            $countView = $a->view;
            return $countAll - $countView;
        } else {
            return false;
        }

         */
    }

}
