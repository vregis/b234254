<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 18.01.2016
 * Time: 11:09
 */

namespace modules\departments\tool;

use modules\tasks\models\DelegateTask;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use modules\tasks\models\TaskUserLog;
use modules\tasks\site\controllers\MessageController;
use modules\user\models\Profile;
use modules\user\models\User;
use modules\user\models\UserTaskHelpful;
use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class TaskComponent extends Component
{
    private function getFindUsers($users_find, &$users, &$exclude_user_ids, $where) {
        if(!$where) {
            $users_find->where(['!=', 'user.id', Yii::$app->user->id]);
        }
        else {
            $users_find->andWhere(['!=', 'user.id', Yii::$app->user->id]);
        }
        foreach ($exclude_user_ids as $key => $value) {
            $users_find->andWhere(['!=', 'user.id', $key]);
        }
        $users_find = $users_find->orderBy(['user_specialization.exp_type' => SORT_DESC]);
        $users_find->limit(5 - count($users));

        $users_find = $users_find->all();

        $users = array_merge($users,$users_find);
        $exclude_user_ids = $exclude_user_ids + ArrayHelper::map($users_find, 'id', 'username');
    }

    private function setFindUsersCondition(&$users, &$exclude_user_ids, $where = null) {
        if(count($users) < 5) {
            $users_find = User::find()->select(
                'user.*,user_profile.first_name fname,user_profile.last_name lname,user_profile.avatar ava,skill_list.name level,user_profile.rate rate_h,geo_country.title_en country,user_profile.city_title city'
            )
                ->join('JOIN','user_profile', 'user_profile.user_id = user.id')
                ->join('LEFT OUTER JOIN','user_specialization', 'user_specialization.user_id = user.id')
                ->join('LEFT OUTER JOIN','skill_list', 'skill_list.id = user_specialization.exp_type')
                ->join('LEFT OUTER JOIN','geo_country', 'geo_country.id = user_profile.country_id')
                ->join('LEFT OUTER JOIN','user_skills', 'user_skills.user_id = user_profile.user_id');
            if($where) {
                $users_find->where($where);
            }



            $this->getFindUsers($users_find, $users, $exclude_user_ids, $where);
        }
    }
    public function get_delegate_users($task_user_id, $post) {
        $is_advanced = false;
        if(isset($post['is_advanced'])) {
            $is_advanced = filter_var($post['is_advanced'], FILTER_VALIDATE_BOOLEAN);
        }

        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        $task_user = TaskUser::find()->select('*,task_user.id id,task.specialization_id spec')
            ->join('JOIN','task','task.id = task_user.task_id')
            ->where(['task_user.id' => $task_user_id])->one();

        $delegate_tasks = DelegateTask::find()
            ->where(['task_user_id' => $task_user_id])
            ->andWhere(['!=','status',DelegateTask::$status_done])
            ->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel])
            ->all();

        $delegate_user_ids = [];
        foreach ($delegate_tasks as $d_task) {
            $delegate_user_ids[$d_task->delegate_user_id] = '';
        }

        $users = [];
        $exclude_user_ids = $delegate_user_ids;
        $this->setFindUsersCondition($users, $exclude_user_ids, ['user_specialization.task_id' => $task_user->task_id]);
        $this->setFindUsersCondition($users, $exclude_user_ids, ['user_specialization.specialization_id' => $task_user->spec]);
        if (isset($post['rate_start']) && $post['rate_start'] != '' && isset($post['rate_end']) && $post['rate_end'] != '') {
            $this->setFindUsersCondition($users, $exclude_user_ids, ['between', 'user_profile.rate', $post['rate_start'], $post['rate_end']]);
        }
        if (isset($post['level']) && $post['level'] != '' && $post['level'] != '0') {
            $this->setFindUsersCondition($users, $exclude_user_ids,['skill_list.id' => $post['level']]
            );
        }
        if (isset($post['city']) && $post['city'] != '') {
            $this->setFindUsersCondition($users, $exclude_user_ids, ['user_profile.city_title' => $post['city']]);
        }
        if (isset($post['country']) && $post['country'] != '') {
            $this->setFindUsersCondition($users, $exclude_user_ids,['user_profile.country_id' => $post['country']]
            );
        }
        if (isset($post['skills_ids']) && $post['skills_ids'] != '' && count($post['skills_ids']) > 0) {
            foreach($post['skills_ids'] as $skill) {
                $this->setFindUsersCondition($users, $exclude_user_ids,['user_skills.skill_tag' => intval($skill)]);
            }
        }
        $this->setFindUsersCondition($users, $exclude_user_ids);
        $this->setFindUsersCondition($users, $exclude_user_ids);


        return Yii::$app->controller->renderPartial('blocks/task/delegate_users',
            [
                'users' => $users,
            ]
        );
    }

    public function get_delegate_users_advanced($task_user_id, $post) {


        $is_advanced = false;
        if(isset($post['is_advanced'])) {
            $is_advanced = filter_var($post['is_advanced'], FILTER_VALIDATE_BOOLEAN);
        }


        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        $task_user = TaskUser::find()->select('*,task_user.id id,task.specialization_id spec')
            ->join('JOIN','task','task.id = task_user.task_id')
            ->where(['task_user.id' => $task_user_id])->one();

        $delegate_tasks = DelegateTask::find()
            ->where(['task_user_id' => $task_user_id])
            ->andWhere(['!=','status',DelegateTask::$status_done])
            ->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel])
            ->all();

        $delegate_user_ids = [];
        foreach ($delegate_tasks as $d_task) {
            $delegate_user_ids[$d_task->delegate_user_id] = '';
        }

        if(!isset($post['is_advanced'])){
            $users = [];
            $exclude_user_ids = $delegate_user_ids;
            $this->setFindUsersCondition($users, $exclude_user_ids, ['user_specialization.task_id' => $task_user->task_id]);
            $this->setFindUsersCondition($users, $exclude_user_ids, ['user_specialization.specialization_id' => $task_user->spec]);
            if (isset($post['rate_start']) && $post['rate_start'] != '' && isset($post['rate_end']) && $post['rate_end'] != '') {
                $this->setFindUsersCondition($users, $exclude_user_ids, ['between', 'user_profile.rate', $post['rate_start'], $post['rate_end']]);
            }
            if (isset($post['level']) && $post['level'] != '' && $post['level'] != '0') {
                $this->setFindUsersCondition($users, $exclude_user_ids,['skill_list.id' => $post['level']]
                );
            }
            if (isset($post['city']) && $post['city'] != '') {
                $this->setFindUsersCondition($users, $exclude_user_ids, ['user_profile.city_title' => $post['city']]);
            }
            if (isset($post['country']) && $post['country'] != '') {
                $this->setFindUsersCondition($users, $exclude_user_ids,['user_profile.country_id' => $post['country']]
                );
            }
            if (isset($post['skills_ids']) && $post['skills_ids'] != '' && count($post['skills_ids']) > 0) {
                foreach($post['skills_ids'] as $skill) {
                    $this->setFindUsersCondition($users, $exclude_user_ids,['user_skills.skill_tag' => intval($skill)]);
                }
            }
            $this->setFindUsersCondition($users, $exclude_user_ids);
            $this->setFindUsersCondition($users, $exclude_user_ids); // this place

        }else{
            $users = [];
            $exclude_user_ids = $delegate_user_ids;
            $this->setFindUsersCondition($users, $exclude_user_ids, ['user_specialization.task_id' => $task_user->task_id]);
            $this->setFindUsersCondition($users, $exclude_user_ids, ['user_specialization.specialization_id' => $task_user->spec]);
            if (isset($post['rate_start']) && $post['rate_start'] != '' && isset($post['rate_end']) && $post['rate_end'] != '') {
                $this->setFindUsersCondition($users, $exclude_user_ids, ['between', 'user_profile.rate', $post['rate_start'], $post['rate_end']]);
            }
            if (isset($post['level']) && $post['level'] != '' && $post['level'] != '0') {
                $this->setFindUsersCondition($users, $exclude_user_ids,['skill_list.id' => $post['level']]
                );
            }
            if (isset($post['city']) && $post['city'] != '') {
                $this->setFindUsersCondition($users, $exclude_user_ids, ['user_profile.city_title' => $post['city']]);
            }
            if (isset($post['country']) && $post['country'] != '') {
                $this->setFindUsersCondition($users, $exclude_user_ids,['user_profile.country_id' => $post['country']]
                );
            }
            if (isset($post['skills_ids']) && $post['skills_ids'] != '' && count($post['skills_ids']) > 0) {
                foreach($post['skills_ids'] as $skill) {
                    $this->setFindUsersCondition($users, $exclude_user_ids,['user_skills.skill_tag' => intval($skill)]);
                }
            }
            $this->setFindUsersCondition($users, $exclude_user_ids);
            $this->setFindUsersCondition($users, $exclude_user_ids); // this place
        }




        return Yii::$app->controller->renderPartial('blocks/task/delegate_users',
            [
                'users' => $users,
            ]
        );
    }



    public function get_task_user_logs($task_user_id) {
        $taskUserLogs = TaskUserLog::find()->where(['task_user_id' => $task_user_id])->all();
        return Yii::$app->controller->renderPartial('blocks/task/logs',
            [
                'taskUserLogs' => $taskUserLogs,
            ]
        );
    }
    public function get_cancel_delegate_users($task_user_id) {

        $users = User::find()->select(
            'user.*,user_profile.first_name fname,user_profile.last_name lname,user_profile.avatar ava,skill_list.name level,user_profile.rate rate_h,geo_country.title_en country,user_profile.city_title city, delegate_task.id del_id'
        )
            ->join('JOIN','user_profile', 'user_profile.user_id = user.id')
            ->join('JOIN','delegate_task', 'delegate_task.delegate_user_id = user.id')
            ->join('LEFT OUTER JOIN','user_specialization', 'user_specialization.user_id = user.id')
            ->join('LEFT OUTER JOIN','skill_list', 'skill_list.id = user_specialization.exp_type')
            ->join('LEFT OUTER JOIN','geo_country', 'geo_country.id = user_profile.country_id')
            ->join('LEFT OUTER JOIN','user_skills', 'user_skills.user_id = user_profile.user_id')
            ->where([
                'task_user_id' => $task_user_id,
                'delegate_task.status' => DelegateTask::$status_inactive
            ])->all();
        if(count($users) > 0) {
            return Yii::$app->controller->renderPartial('blocks/task/cancel_delegate_users',
                [
                    'users' => $users,
                ]
            );
        }
        else {
            return 'none';
        }
    }

    public function ajaxGet_delegate_users()
    {
        $post = Yii::$app->request->post();
        $is_my = filter_var($post['is_my'], FILTER_VALIDATE_BOOLEAN);

        if($is_my) {
            $task_user_id = $post['task_user_id'];
            $task_user = TaskUser::find()->where(['id' => $task_user_id])->one();
            if ($task_user) {
                $task_user->time = $post['time'];
                $task_user->price = $post['price'];
                $task_user->rate = intval($task_user->price/$task_user->time);
                $task_user->save(false);
            }
        }

        $response['error'] = false;
        $response['html'] = $this->get_delegate_users($post['task_user_id'], $post);
        return json_encode($response);
    }

    public function ajaxGet_delegate_users_advanced()
    {
        $post = Yii::$app->request->post();
        $is_my = filter_var($post['is_my'], FILTER_VALIDATE_BOOLEAN);

        if($is_my) {
            $task_user_id = $post['task_user_id'];
            $task_user = TaskUser::find()->where(['id' => $task_user_id])->one();
            if ($task_user) {
                $task_user->time = $post['time'];
                $task_user->price = $post['price'];
                $task_user->rate = intval($task_user->price/$task_user->time);
                $task_user->save(false);
            }
        }

        $response['error'] = false;
        $response['html'] = $this->get_delegate_users_advanced($post['task_user_id'], $post);
        return json_encode($response);
    }



    public function render_delegate_active_users($task_user_id, $delegate_task = null, $delegate_tasks = null) {
        if(!$delegate_task) {
            $delegate_task = DelegateTask::getCurrentDelegateTask($task_user_id, true);
        }
        if(!$delegate_tasks) {
            $delegate_tasks = DelegateTask::getCurrentDelegateTasks($task_user_id, true);
        }
        if(count($delegate_tasks) > 0) {
            $messageController = new MessageController('message', Yii::$app->getModule('tasks'));
            foreach ($delegate_tasks as $d_task) {
                $count_new_message = $messageController->get_count_new_message($task_user_id, $d_task->id);
                if ($count_new_message > 0) {
                    $d_task->new_message = $count_new_message;
                }
            }
            return Yii::$app->controller->renderPartial(
                'blocks/task/delegate_active_users',
                [
                    'task_user_id' => $task_user_id,
                    'delegate_tasks' => $delegate_tasks,
                    'delegate_task' => $delegate_task
                ]
            );
        }else {
            return 'none';
        }
    }

    public function ajaxDelegate()
    {
        $post = Yii::$app->request->post();
        if(isset($post['delegate_user_ids'])) {
            $task_user_id = $post['task_user_id'];
            foreach ($post['delegate_user_ids'] as $delegate_user_id) {
                $delegateTask = DelegateTask::find()->where(
                    [
                        'task_user_id' => $post['task_user_id'],
                        'delegate_user_id' => $delegate_user_id,
                    ]
                )->andWhere(['!=','status',DelegateTask::$status_done])
                    ->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel])
                    ->one();
                if (is_null($delegateTask)) {
                    $delegateTask = new DelegateTask();
                    $delegateTask->task_user_id = $task_user_id;
                    $delegateTask->delegate_user_id = $delegate_user_id;
                    $delegateTask->start = $post['start'];
                    $delegateTask->end = $post['end'];
                    $delegateTask->time = $post['time'];
                    $delegateTask->price = $post['price'];
                    $user = User::find()->where(['id' => $delegate_user_id])->one();
                    $delegateTask->date = '' . date('Y-m-d h:i:s');
                    $delegateTask->save();
                    TaskUserLog::sendLog($task_user_id, sprintf(TaskUserLog::$log_offer,$user->username));
                }
                if(!isset($_SESSION['task_user_'.$task_user_id]['delegate_task_id'])) {
                    $_SESSION['task_user_'.$task_user_id]['delegate_task_id'] = $delegateTask->id;
                }
            }
            $response['error'] = false;
            $response['html_users'] = $this->get_delegate_users($task_user_id, $post);
            $response['html_cancel_users'] = $this->get_cancel_delegate_users($task_user_id);
            $response['html_active_users'] = $this->render_delegate_active_users($task_user_id);
            $response['html_task_user_logs'] = $this->get_task_user_logs($task_user_id);
        }
        else {
            $response['error'] = true;
        }
        return json_encode($response);
    }
    public function ajaxCancel_delegate() {
        $post = Yii::$app->request->post();
        if(isset($post['cancel_delegate_user_ids'])) {
            $task_user_id = $post['task_user_id'];
            foreach ($post['cancel_delegate_user_ids'] as $cancel_delegate_user_id) {
                $user = User::find()->where(['id' => $cancel_delegate_user_id])->one();
                $delegateTask = DelegateTask::find()->where(
                    [
                        'task_user_id' => $post['task_user_id'],
                        'delegate_user_id' => $cancel_delegate_user_id,
                    ]
                )->andWhere(['!=','status',DelegateTask::$status_done])
                    ->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel])
                    ->one();
                if (!is_null($delegateTask)) {
                    $delegateTask->status = DelegateTask::$status_cancel;
                    $delegateTask->save();
                    TaskUserLog::sendLog($delegateTask->task_user_id, sprintf(TaskUserLog::$log_cancel_offer_specialist, $user->username));
                }
            }
            $response['error'] = false;
            $response['html_users'] = $this->get_delegate_users($task_user_id, $post);
            $response['html_cancel_users'] = $this->get_cancel_delegate_users($task_user_id);
            $response['html_active_users'] = $this->render_delegate_active_users($task_user_id);
            $response['html_task_user_logs'] = $this->get_task_user_logs($task_user_id);
        }
        else {
            $response['error'] = true;
        }
        return json_encode($response);
    }
    public function ajaxCheck_status()
    {
        $post = Yii::$app->request->post();
        if(isset($post['task_user_id'])) {
            $task_user_id = $post['task_user_id'];
            $is_my = filter_var($post['is_my'], FILTER_VALIDATE_BOOLEAN);
            $delegate_task = DelegateTask::getCurrentDelegateTask($task_user_id, $is_my);
            $is_update_action_panel = false;
            if($is_my) {
                $delegate_tasks = DelegateTask::getCurrentDelegateTasks($task_user_id, $is_my);
                if (count($delegate_tasks) != $post['delegate_tasks_count']) {
                    $is_update_action_panel = true;
                    $response['html_active_users'] = $this->render_delegate_active_users($task_user_id,$delegate_task,$delegate_tasks);
                }
            }
            else {
                if(!$delegate_task) {
                    $response['error'] = true;
                    return json_encode($response);
                }
            }
            $task_user = TaskUser::find()->where(['id' => $task_user_id])->one();
            $counter_offers = [];
            if($is_my) {
                $counter_offers = DelegateTask::getCurrentCounterOffers($task_user_id);

                if (count($counter_offers) != $post['counter_offers_count']) {
                    $is_update_action_panel = true;
                    if(count($counter_offers) > 0) {
                        $response['html_counter_offers'] = Yii::$app->controller->renderPartial(
                            'blocks/task/counter_offers',
                            [
                                'counter_offers' => $counter_offers
                            ]
                        );
                    }else {
                        $response['html_counter_offers'] = 'none';
                    }
                }
            }

            if($is_update_action_panel ||
                ($delegate_task && isset($post['status_delegate']) && intval($delegate_task->status) != intval($post['status_delegate']))) {
                $response['html_action_panel'] = Yii::$app->controller->renderPartial(
                    'blocks/task/action_panel',
                    [
                        'task_user' => $task_user,
                        'is_my' => $is_my,
                        'delegate_task' => $delegate_task,
                        'counter_offers' => $counter_offers
                    ]
                );
                $response['html_users'] = $this->get_delegate_users($task_user_id, $post);
                $response['html_cancel_users'] = $this->get_cancel_delegate_users($task_user_id);
                $response['html_task_user_logs'] = $this->get_task_user_logs($task_user_id);
            }

            $messageController = new MessageController('message', Yii::$app->getModule('tasks'));
            $is_active_chat = filter_var($post['is_active_chat'], FILTER_VALIDATE_BOOLEAN);
            if($is_active_chat) {
                $taskUserMessage = $messageController->get_html($task_user_id, $is_my, $post['message_count']);
                if ($taskUserMessage != '') {
                    $response['html_messages'] = $taskUserMessage;
                }
            }
            if($is_my) {
                $response['new_message'] = [];
                $all_count_new_message = 0;
                foreach($delegate_tasks as $d_task) {
                    $count_new_message = $messageController->get_count_new_message($task_user_id, $d_task->id);
                    if($count_new_message > 0) {
                        array_push($response['new_message'],['delegate_task_id' => $d_task->id, 'count' => $count_new_message]);
                        $all_count_new_message += $count_new_message;
                    }
                }
                if($all_count_new_message > 0) {
                    $response['all_new_message'] = ['count' => $all_count_new_message];
                }
            }
            else {
                $count_new_message = $messageController->get_count_new_message($task_user_id, $delegate_task->id);
                if($count_new_message > 0) {
                    $response['all_new_message'] = ['count' => $count_new_message];
                }
            }
            $response['error'] = false;
        }
        else {
            $response['error'] = false;
        }
        return json_encode($response);
    }
    public function ajaxSelect_delegate() {
        $post = Yii::$app->request->post();
        $task_user_id = $post['task_user_id'];
        $is_my = filter_var($post['is_my'], FILTER_VALIDATE_BOOLEAN);
        $_SESSION['task_user_'.$task_user_id]['delegate_task_id'] = $post['delegate_task_id'];

        $messageController = new MessageController('message', Yii::$app->getModule('tasks'));
        $taskUserMessage = $messageController->get_html($task_user_id, $is_my);
        $response['error'] = false;
        $response['html'] = $taskUserMessage;
        $delegate_tasks = DelegateTask::getCurrentDelegateTasks($task_user_id, $is_my);
        $all_count_new_message = 0;
        foreach($delegate_tasks as $d_task) {
            $count_new_message = $messageController->get_count_new_message($task_user_id, $d_task->id);
            $all_count_new_message += $count_new_message;
        }
        if($all_count_new_message > 0) {
            $response['all_new_message'] = ['count' => $all_count_new_message];
        }
        $response['html_active_users'] = $this->render_delegate_active_users($task_user_id,null,$delegate_tasks);
        return json_encode($response);
    }
    public function ajaxPay() {
        $post = Yii::$app->request->post();
        $task_user_id = $post['task_user_id'];
        $task_user = TaskUser::find()->where(['id' => $task_user_id])->one();
        $response['error'] = false;
        $delegate_task = DelegateTask::getCurrentDelegateTask($task_user_id, false);
        $delegate_task->status = DelegateTask::$status_payment;
        $delegate_task->save();
        TaskUserLog::sendLog($task_user_id, TaskUserLog::$log_payment);
        $response['html'] = Yii::$app->controller->renderPartial(
            'blocks/task/action_panel',
            [
                'task_user' => $task_user,
                'is_my' => true,
                'delegate_task' => $delegate_task
            ]
        );
        return json_encode($response);
    }
    public function ajaxReceive() {
        $post = Yii::$app->request->post();
        $task_user_id = $post['task_user_id'];
        $task_user = TaskUser::find()->where(['id' => $task_user_id])->one();
        $task_user->status = 2;
        $task_user->save(false);
        $response['error'] = false;
        $delegate_task = DelegateTask::getCurrentDelegateTask($task_user_id, false);
        $delegate_task->status = 7;
        $delegate_task->save();
        TaskUserLog::sendLog($delegate_task->task_user_id, TaskUserLog::$log_payment_received);
        $response['html'] = Yii::$app->controller->renderPartial(
            'blocks/task/action_panel',
            [
                'task_user' => $task_user,
                'is_my' => false,
                'delegate_task' => $delegate_task
            ]
        );
        return json_encode($response);
    }

    public function ajaxSet_date() {
        $post = Yii::$app->request->post();
        $task_user_id = $post['task_user_id'];
        $task_user = TaskUser::find()->where(['id' => $task_user_id])->one();
        if($task_user) {
            $task_user->start = $post['start'];
            $task_user->end = $post['end'];
            $task_user->save();
        }
        $response['error'] = false;
        return json_encode($response);
    }
    public function ajaxOffer() {
        $post = Yii::$app->request->post();
        $task_user_id = $post['task_user_id'];
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $delegate_task = DelegateTask::getCurrentDelegateTask($task_user_id, false);
        if($delegate_task) {
            $delegate_task->start = $post['start'];
            $delegate_task->end = $post['end'];
            $delegate_task->counter_time = $post['time'];
            $delegate_task->counter_price = $post['price'];
            $delegate_task->status = DelegateTask::$status_offer;
            $delegate_task->save();
            TaskUserLog::sendLog($task_user_id, sprintf(TaskUserLog::$log_counter_offer,$user->username));
        }

        $task_user = TaskUser::find()->where(['id' => $delegate_task->task_user_id])->one();
        $counter_offers = DelegateTask::getCurrentCounterOffers($delegate_task->task_user_id);
        $response['html_action_panel'] = Yii::$app->controller->renderPartial(
            'blocks/task/action_panel',
            [
                'task_user' => $task_user,
                'is_my' => false,
                'delegate_task' => $delegate_task,
                'counter_offers' => $counter_offers
            ]
        );
        $response['html_task_user_logs'] = $this->get_task_user_logs($task_user_id);
        $response['error'] = !$delegate_task;
        return json_encode($response);
    }

    public function ajaxConfirn()
    {
        $post = Yii::$app->request->post();
        $delegate_task_id = $post['delegate_task_id'];
        $status = $post['status'];
        $delegate_task = DelegateTask::find()->where(
            [
                'id' => $delegate_task_id
            ]
        )->one();
        $user = User::find()->where(['id' => $delegate_task->delegate_user_id])->one();
        $task_user_id = $delegate_task->task_user_id;
        $task_user = TaskUser::find()->where(['id' => $delegate_task->task_user_id])->one();
        if($status == 0) {
            if($delegate_task->status >= DelegateTask::$status_active) {
                TaskUserLog::sendLog($delegate_task->task_user_id, TaskUserLog::$log_cancel);
            }
            else {
                TaskUserLog::sendLog($delegate_task->task_user_id, sprintf(TaskUserLog::$log_cancel_counter_offer, $user->username));
            }
            $delegate_task->status = DelegateTask::$status_cancel;
            if($task_user->is_delegate == 1) {
                $task_user->is_delegate = 0;
                $task_user->save(false);
            }
        }else {
            TaskUserLog::sendLog($task_user_id, sprintf(TaskUserLog::$log_delegate,$user->username));
            if($delegate_task->counter_price == 0) {
                $delegate_task->status = DelegateTask::$status_payment;
                TaskUserLog::sendLog($task_user_id, TaskUserLog::$log_payment);
            }
            else {
                $delegate_task->status = DelegateTask::$status_active;
            }
            $task_user->start = $delegate_task->start;
            $task_user->end = $delegate_task->end;
            $task_user->time = $delegate_task->counter_time;
            $task_user->price = $delegate_task->counter_price;
            if($task_user->time == 0){
                $zero = 1;
            }else{
                $zero = $task_user->time;
            }
            $task_user->rate = intval($task_user->price/$zero);
            $task_user->is_delegate = 1;
            $task_user->save(false);
            $delegate_tasks = DelegateTask::getCurrentDelegateTasks($delegate_task->task_user_id, true);
            foreach($delegate_tasks as $d_task) {
                if($d_task->id != $delegate_task->id) {
                    $d_task->status = DelegateTask::$status_cancel;
                    $d_task->save();
                }
            }
        }
        $delegate_task->save();

        $delegate_task = DelegateTask::getCurrentDelegateTask($delegate_task->task_user_id, true);
        $task_user = TaskUser::find()->where(['id' => $task_user_id])->one();

        $counter_offers = [];
        if ($delegate_task) {
            $counter_offers = DelegateTask::getCurrentCounterOffers($task_user_id);
            if ($counter_offers > 0) {
                $response['html'] = Yii::$app->controller->renderPartial(
                    'blocks/task/counter_offers',
                    [
                        'counter_offers' => $counter_offers
                    ]
                );
            }
        }
        $response['html_action_panel'] = Yii::$app->controller->renderPartial(
            'blocks/task/action_panel',
            [
                'task_user' => $task_user,
                'is_my' => true,
                'delegate_task' => $delegate_task,
                'counter_offers' => $counter_offers
            ]
        );
        $response['html_cancel_users'] = $this->get_cancel_delegate_users($task_user_id);
        $response['html_active_users'] = $this->render_delegate_active_users($task_user_id);
        $response['html_task_user_logs'] = $this->get_task_user_logs($task_user_id);
        $response['error'] = false;
        return json_encode($response);
    }
    public function ajaxRestart() {
        $post = Yii::$app->request->post();
        $task_user = TaskUser::find()->where(['id' => $post['task_user_id']])->one();
        if($task_user) {
            $task_user->status = 1;
            $task_user->save();
            TaskUserLog::sendLog($task_user->id, TaskUserLog::$log_restart);

            $del_task = DelegateTask::find()->where(['task_user_id' => $task_user->id])->all();
            if($del_task){
                foreach($del_task as $d_t){
                    $d_t->status = 8;
                    $d_t->save();
                }
            }


        }
        $counter_offers = DelegateTask::getCurrentCounterOffers($task_user->id);
        $response['html'] = Yii::$app->controller->renderPartial(
            'blocks/task/action_panel',
            [
                'task_user' => $task_user,
                'is_my' => true,
                'delegate_task' => DelegateTask::getCurrentDelegateTask($task_user->id, true),
                'counter_offers' => $counter_offers
            ]
        );
        $response['html_task_user_logs'] = $this->get_task_user_logs($task_user->id);

        $response['error'] = false;
        return json_encode($response);
    }
    public function ajaxSet_helpful() {
        $post = Yii::$app->request->post();
        $task_user = TaskUser::find()->where(['id' => $post['task_user_id']])->one();
        $user_task_helpful = UserTaskHelpful::getUserTaskHelpful($task_user->task_id);
        $user_task_helpful->helpful = $post['helpful'];
        $user_task_helpful->save();
        $response['error'] = false;
        return json_encode($response);
    }

    public function ajax() {
        $command = 'ajax'.ucfirst(Yii::$app->request->post('command'));
        return $this->$command();
    }


    public static function getTaskTitle($id){
        $task = Task::find()->where(['id' => $id])->one();
        if($task){
            return $task->name;
        }else{
            return null;
        }
    }

    public static function getTaskDesc($id){
        $task = Task::find()->where(['id' => $id])->one();
        if($task){
            return strip_tags($task->description);
        }else{
            return null;
        }
    }
}