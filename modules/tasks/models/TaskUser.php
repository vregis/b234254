<?php

namespace modules\tasks\models;

use Yii;
use yii\helpers\ArrayHelper;


class TaskUser extends \yii\db\ActiveRecord
{
    static public $status_new = 0;
    static public $status_active = 1;
    static public $status_completed = 2;

    public $name;
    public $delegate_task;
    public $spec;
    public $is_request;

    public function rules()
    {
        return [
        ];
    }
    public static function tableName()
    {
        return 'task_user';
    }
    public static function getTaskUser($tool_id, $task_id, $task = null) {
        $task_user = TaskUser::find()->where(['user_tool_id' => $tool_id, 'task_id' => $task_id])->one();

        if(!$task) {
            $task = Task::find()->where(['id' => $task_id])->one();
        }
        if(!$task_user){
            $task_user = new TaskUser();
            $task_user->task_id = $task_id;
            $task_user->user_tool_id = $tool_id;
            $task_user->time = $task->recommended_time;
            $task_user->price = $task->recommended_time * $task->market_rate;
            if($task->is_roadmap) {
                $task_user->status = static::$status_completed;
            }
            $task_user->save(false);
        }
        return $task_user;
    }
    public static function getMonth($number) {
        $month = '';
        switch ($number) {
            case 1:
                $month = 'Jan';
                break;
            case 2:
                $month = 'Feb';
                break;
            case 3:
                $month = 'Mar';
                break;
            case 4:
                $month = 'Apr';
                break;
            case 5:
                $month = 'May';
                break;
            case 6:
                $month = 'June';
                break;
            case 7:
                $month = 'July';
                break;
            case 8:
                $month = 'Aug';
                break;
            case 9:
                $month = 'Sept';
                break;
            case 10:
                $month = 'Oct';
                break;
            case 11:
                $month = 'Nov';
                break;
            case 12:
                $month = 'Dec';
                break;
        }
        return $month;
    }
}
