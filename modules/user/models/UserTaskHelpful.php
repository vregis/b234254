<?php

namespace modules\user\models;

use Yii;

class UserTaskHelpful extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'user_task_helpful';
    }

    public static function getUserTaskHelpful($task_id) {
        $user_task_helpful = static::find()->where([
            'user_id' => Yii::$app->user->id,
            'task_id' => $task_id
        ])->one();
        if(!$user_task_helpful) {
            $user_task_helpful = new static();
            $user_task_helpful->user_id = Yii::$app->user->id;
            $user_task_helpful->task_id = $task_id;
            $user_task_helpful->helpful = NULL;
            $user_task_helpful->save(false);
        }
        return $user_task_helpful;
    }
}
