<?php

namespace modules\tasks\models;

use Yii;


class TaskUserLog extends \yii\db\ActiveRecord
{
    public static $log_start = 'Obtained';
    public static $log_offer = 'Task offered %s';
    public static $log_cancel_offer = 'Cancel an offer';
    public static $log_cancel_offer_specialist = 'Offer cancel for: %s';
    public static $log_counter_offer = '%s Make an offer';
    public static $log_cancel_counter_offer = 'Cancel an offer';
    public static $log_payment = 'Task funded for %s';
    public static $log_delegate = 'Task delegated %s';
    public static $log_complete_specialist = 'Task submited by %s';
    public static $log_checked = 'Complete';
    public static $log_complete = 'Complete';
    public static $log_payment_received = 'Payment';
    public static $log_cancel = 'Task cancel delegated';
    public static $log_restart = 'Restart';
    public static $log_job = 'Accept';
    public function rules()
    {
        return [
        ];
    }

    public static function tableName()
    {
        return 'task_user_log';
    }
    public static function sendLog($task_user_id, $log_text)
    {
        $log = new static();
        $log->task_user_id = $task_user_id;
        $log->user_id = Yii::$app->user->id;
        $log->log = $log_text;
        $log->date = ''.date('Y-m-d h:i:s');
        $log->save();
    }
}
