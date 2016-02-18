<?php

namespace modules\tasks\site\controllers;

use DateTime;
use modules\core\site\base\Controller;
use modules\tasks\models\DelegateTask;
use Yii;
use yii\filters\AccessControl;
use modules\tasks\models\TaskUserNote;
use modules\tasks\models\TaskUserMessage;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class MessageController extends Controller
{
    public $layout = "@modules/core/site/views/layouts/main";
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'get',
                            'add',
                            'edit',
                            'remove',
                        ],
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function getMessagesRender($task_user_id, $delegate_task_id) {
        $taskUserMessages = TaskUserMessage::find()
            ->select('task_user_message.*,user.username name,user_profile.avatar ava')
            ->join('JOIN', 'user', '`user`.`id` = `task_user_message`.`user_id`')
            ->join('JOIN', 'user_profile', '`user_profile`.`user_id` = `user`.`id`')
            ->where([
            'task_user_id' => $task_user_id,
                'delegate_task_id' => $delegate_task_id,
        ])->all();
        foreach($taskUserMessages as $taskUserMessage) {
            if($taskUserMessage->is_read == 0 && $taskUserMessage->user_id != Yii::$app->user->identity->id) {
                $taskUserMessage->is_read = 1;
                $taskUserMessage->save();
            }
        }
        $group_messages = [];
        foreach($taskUserMessages as $taskUserMessage) {
            $messageDate = new DateTime($taskUserMessage->date);
            $key = $messageDate->format("D, M d");
            if(!isset($group_messages[$key])) {
                $group_messages[$key] = [];
            }
            array_push($group_messages[$key],$taskUserMessage);
        }
        return $this::renderPartial('list', [
            'group_messages' => $group_messages
        ]);
    }
    public function get_count_new_message($task_user_id, $delegate_task_id) {
        $taskUserMessages_is_read_count = TaskUserMessage::find()
            ->where(
                [
                    'task_user_id' => $task_user_id,
                    'delegate_task_id' => $delegate_task_id,
                    'is_read' => 0
                ]
            )
            ->andWhere(['!=', 'user_id', Yii::$app->user->identity->id])
            ->count();
        return $taskUserMessages_is_read_count;
    }
    public function get_count_all_message($task_user_id, $delegate_task_id) {
        $taskUserMessages_all_count = TaskUserMessage::find()
            ->where(
                [
                    'task_user_id' => $task_user_id,
                    'delegate_task_id' => $delegate_task_id,
                ]
            )->count();
        return $taskUserMessages_all_count;
    }
    public function get_html($task_user_id, $is_my, $count = 0) {
        $delegate_task = DelegateTask::getCurrentDelegateTask($task_user_id, $is_my);
        if($delegate_task) {

            if ($this->get_count_all_message($task_user_id, $delegate_task->id) != $count || $this->get_count_new_message($task_user_id, $delegate_task->id) > 0) {
                return $this->getMessagesRender($task_user_id, $delegate_task->id);
            }
        }
        return '';
    }

    public function actionGet() {
        $post = Yii::$app->request->post();
        $is_my = filter_var($post['is_my'], FILTER_VALIDATE_BOOLEAN);

        $response['error'] = true;
        if(isset($post)) {
            $response['error'] = false;
            $response['html'] = $this->get_html($post['task_user_id'], $is_my, $post['count']);
        }
        return json_encode($response);
    }
    public function actionAdd() {
        $post = Yii::$app->request->post();
        $response['error'] = true;
        if(isset($post)) {
            $message = $post['message'];
            if($message != '') {
                $task_user_id = $post['task_user_id'];
                $is_my = filter_var($post['is_my'], FILTER_VALIDATE_BOOLEAN);
                $delegate_task = DelegateTask::getCurrentDelegateTask($task_user_id, $is_my);
                $taskUserMessage = new TaskUserMessage();
                $taskUserMessage->task_user_id = $post['task_user_id'];
                $taskUserMessage->delegate_task_id = $delegate_task->id;
                $taskUserMessage->user_id = Yii::$app->user->identity->id;
                $taskUserMessage->message = $message;
                $taskUserMessage->date = ''.date('Y-m-d h:i:s');
                if ($taskUserMessage->save()) {
                    $response['error'] = false;
                    $response['html'] = $this->getMessagesRender($taskUserMessage->task_user_id, $taskUserMessage->delegate_task_id);
                }
            }
        }
        return json_encode($response);
    }
    public function actionEdit() {
        $post = Yii::$app->request->post();
        $response['error'] = true;
        if(isset($post)) {
            $message = $post['message'];
            if($message != '') {
                $taskUserMessage = TaskUserMessage::find()->where([
                    'id' => $post['id'],
                ])->one();
                $taskUserMessage->message = $message;
                $taskUserMessage->is_read = 0;
                if ($taskUserMessage->save()) {
                    $response['error'] = false;
                    $response['html'] = $this->getMessagesRender($taskUserMessage->task_user_id, $taskUserMessage->delegate_task_id);
                }
            }
        }
        return json_encode($response);
    }
    public function actionRemove() {
        $post = Yii::$app->request->post();
        $response['error'] = true;
        if(isset($post)) {
            $taskUserMessage = TaskUserMessage::find()->where([
                'id' => $post['id'],
            ])->one();
            $task_user_id = $taskUserMessage->task_user_id;
            $delegate_task_id = $taskUserMessage->delegate_task_id;
            if ($taskUserMessage->delete()) {
                $response['error'] = false;
                $response['html'] = $this->getMessagesRender($task_user_id, $delegate_task_id);
            }
        }
        return json_encode($response);
    }
}