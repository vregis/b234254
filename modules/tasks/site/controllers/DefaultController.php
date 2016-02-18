<?php

namespace modules\tasks\site\controllers;

use modules\tasks\models\DelegateTask;
use modules\tasks\site\controllers\NoteController;
use modules\tasks\site\controllers\MessageController;
use modules\core\site\base\Controller;
use modules\tasks\models\UserTool;
use modules\user\models\User;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use modules\tasks\models\TaskVideoYoutube;
use modules\tasks\models\TaskLink;
use modules\tasks\models\TaskNote;
use modules\tasks\models\TaskUserLog;
use modules\departments\models\Idea;
use modules\departments\models\Industry;
use modules\departments\models\Goal;
use modules\user\models\Profile;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DefaultController extends Controller
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
                            'index',
                            'complete',
                            'reject',
                            'sendfeedback',
                            'submit',
                            'readlog'
                        ],
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add-note'  => ['post']
                ],
            ],
        ];
    }
    function getFiles($id, $category) {
        $uploaddir = Yii::getAlias('@static').'/tasks/'.$id.'/'.$category.'/';
        if (!is_dir($uploaddir)) mkdir($uploaddir, 0777, true);
        $result  = array();
        $files = scandir($uploaddir);
        if ( false!==$files ) {
            foreach ( $files as $file ) {
                if ( '.'!=$file && '..'!=$file) {
                    $obj['name'] = $file;
                    $obj['path'] = Yii::$app->params['staticDomain'].'tasks/'.$id.'/'.$category.'/'.$file;
                    $obj['size'] = filesize($uploaddir.$file);
                    $result[] = $obj;
                }
            }
        }
        return $result;
    }

    public function actionIndex($id, $task_user_id = -1, $delegate_task_id = -1) {
    }

    public function actionSendfeedback(){
        $response = [];
        Yii::$app->mailer->compose()
            ->setFrom(['support@bigsbusiness.com' => 'Bigsbusiness'])
            ->setTo('countent@bsb.com')
            ->setSubject('Feedback from bigsbusiness.com')
            ->setHtmlBody($_POST['msg'])
            ->send();
        $response['error'] = false;
        die(json_encode($response));
    }

    public function actionComplete($id) {
        $task_user = TaskUser::find()->where(['id' => $id])->one();
        $task_user->status = 2;
        $task_user->save();
        $delegate_task = DelegateTask::getCurrentDelegateTask($id, true);
        if($delegate_task) {
            $delegate_task->status = DelegateTask::$status_checked;
            $delegate_task->save();
            TaskUserLog::sendLog($delegate_task->task_user_id, TaskUserLog::$log_checked);
        }
        else {
            TaskUserLog::sendLog($task_user->id, TaskUserLog::$log_complete);
        }
        return $this->redirect(['/departments']);
    }

    public function actionReject($id) {
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $delegate_task = DelegateTask::getCurrentDelegateTask($id, false);
        if($delegate_task) {
            $delegate_task->status = DelegateTask::$status_cancel;
            $delegate_task->save();
            TaskUserLog::sendLog($delegate_task->task_user_id, sprintf(TaskUserLog::$log_cancel_offer, $user->username));
        }
        return $this->redirect(['/departments/business']);
    }

    public function actionSubmit($id) {
        $delegate_task = DelegateTask::find()->where(['id' => $id])->one();
        if($delegate_task) {
            $delegate_task->status = DelegateTask::$status_complete;
            $delegate_task->save();
            TaskUserLog::sendLog($delegate_task->task_user_id, TaskUserLog::$log_complete_specialist);
        }
        return $this->redirect(['/departments']);
    }

    public function actionReadlog(){
        if(isset($_POST['task_user_id']) && !empty($_POST['task_user_id'])){
            $logs = TaskUserLog::find()
                ->where(['!=', 'user_id', Yii::$app->user->id])
                ->andWhere(['task_user_id' => $_POST['task_user_id']])
                ->all();
            if($logs){
                foreach($logs as $log){
                    $log->is_read = 1;
                    $log->save();
                }
            }
        }
        return json_encode($_POST);
    }

}