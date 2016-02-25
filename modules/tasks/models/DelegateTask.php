<?php

namespace modules\tasks\models;

use Yii;
use yii\helpers\ArrayHelper;


class DelegateTask extends \yii\db\ActiveRecord
{
    static public $status_inactive = 0;
    static public $status_offer = 1;
    static public $status_active = 2;
    static public $status_payment = 3;
    static public $status_complete = 5;
    static public $status_checked = 6;
    static public $status_done = 7;
    static public $status_cancel = 8;

    public $name;
    public $task;
    public $user;
    public $user_avatar;
    public $delegate_user;
    public $delegate_avatar;
    public $tool;
    public $country;
    public $city;
    public $new_message = 0;
    public $fname;
    public $lname;
    public $email;
    public $level;
    public $rate_h;
    public $task_name;
    public $task_desc;
    public $task_special;
    public $task_rate;
    public $task_user_time;
    public $task_user_price;
    public $dep_id;
    public $spec_id;
    public $dname;
    public $uid;
    public $spec_name;
    public $description;

    public function rules()
    {
        return [
        ];
    }
    public static function tableName()
    {
        return 'delegate_task';
    }
    public static function getCurrentDelegateTask($task_user_id, $is_my = true, $is_check_null = true, $is_check_done = true) {
        $delegate_task = null;
        if(!isset($_SESSION['task_user_'.$task_user_id]['delegate_task_id'])) {
            $delegate_task = DelegateTask::find()->where([
                'task_user_id' => $task_user_id
            ]);
            if(!$is_my) {
                $delegate_task->andWhere(['delegate_user_id' => Yii::$app->user->id]);
            }
            if(!$is_my && $is_check_done) {
                $delegate_task->andWhere(['!=', 'status', static::$status_done]);
            }
            $delegate_task->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel]);

            $delegate_task = $delegate_task->one();
            if(!$is_my && $is_check_done && !$delegate_task) {
                $delegate_task = static::getCurrentDelegateTask($task_user_id, $is_my, false, false);
            }

            if($delegate_task) {
                $_SESSION['task_user_'.$task_user_id]['delegate_task_id'] = $delegate_task->id;
            }
        }
        else {
            $delegate_task = DelegateTask::find()->where([
                'id' => $_SESSION['task_user_'.$task_user_id]['delegate_task_id']]
            );
            if(!$is_my && $is_check_done) {
                $delegate_task->andWhere(['!=', 'status', DelegateTask::$status_done]);
            }
            $delegate_task->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel]);

            $delegate_task = $delegate_task->one();
            if($is_check_null && !$delegate_task) {
                unset($_SESSION['task_user_'.$task_user_id]['delegate_task_id']);
                $delegate_task = static::getCurrentDelegateTask($task_user_id, $is_my, false);
            }
        }
        return $delegate_task;
    }
    public static function getCurrentDelegateTasks($task_user_id, $is_my = true) {

        $delegate_tasks = DelegateTask::find()->select('*,delegate_task.id id,user_profile.avatar delegate_avatar')
            ->join('JOIN', 'user', 'user.id = delegate_task.delegate_user_id')
            ->join('JOIN', 'user_profile', 'user_profile.user_id = user.id')
            ->join('JOIN', 'task_user', 'task_user.id = delegate_task.task_user_id')
            ->where(['delegate_task.task_user_id' => $task_user_id])
            ->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel]);
        if(!$is_my) {
            $delegate_tasks->andWhere(['!=','delegate_task.status',static::$status_done]);
        }
        return $delegate_tasks->all();
    }
    public static function getCurrentCounterOffers($task_user_id) {

        return DelegateTask::find()->select('delegate_task.*,user_profile.avatar delegate_avatar,user.username name,user_profile.avatar delegate_avatar,geo_country.title_en country,user_profile.city_title city')
            ->join('JOIN', 'user', 'user.id = delegate_task.delegate_user_id')
            ->join('JOIN', 'user_profile', 'user_profile.user_id = user.id')
            ->join('LEFT OUTER JOIN','geo_country', 'geo_country.id = user_profile.country_id')
            ->join('JOIN', 'task_user', 'task_user.id = delegate_task.task_user_id')
            ->where([
                'delegate_task.task_user_id' => $task_user_id,
                'delegate_task.status' => static::$status_offer
            ])->andWhere(['!=','delegate_task.status',static::$status_done])
            ->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel])
            ->all();
    }
}
