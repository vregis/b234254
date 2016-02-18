<?php

namespace modules\tasks\models;

use Yii;


class TaskUserLog extends \yii\db\ActiveRecord
{
    public static $log_start = 'Task obtained';
    public static $log_offer = 'Task offered %s';
    public static $log_cancel_offer = '%s reject offer';
    public static $log_cancel_offer_specialist = 'Offer cancel for: %s';
    public static $log_counter_offer = '%s made an offer';
    public static $log_cancel_counter_offer = 'Offer %s canceled';
    public static $log_payment = 'Task paid';
    public static $log_delegate = 'Task delegated %s';
    public static $log_complete_specialist = 'Task completed specialist';
    public static $log_checked = 'Task checked and completed';
    public static $log_complete = 'Task completed';
    public static $log_payment_received = 'Payment received';
    public static $log_cancel = 'Task cancel delegated';
    public static $log_restart = 'Task restart';
    public static $log_job = 'The task is taken to job';
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
