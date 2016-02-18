<?php

namespace modules\tasks\site\controllers;

use modules\core\site\base\Controller;
use Yii;
use yii\filters\AccessControl;
use modules\tasks\models\TaskUserNote;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class NoteController extends Controller
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

    public function getNotesRender($task_user_id) {
        $taskUserNotes = TaskUserNote::find()->where([
            'task_user_id' => $task_user_id,
            'user_id' => Yii::$app->user->identity->id
        ])->all();
        return $this::renderPartial('list', [
            'taskUserNotes' => $taskUserNotes
        ]);
    }

    public function actionAdd() {
        $post = Yii::$app->request->post();
        $response['error'] = true;
        if(isset($post)) {
            $note = $post['note'];
            if($note != '') {
                $taskUserNote = new TaskUserNote();
                $taskUserNote->task_user_id = $post['task_user_id'];
                $taskUserNote->user_id = Yii::$app->user->identity->id;
                $taskUserNote->note = $note;
                $taskUserNote->date = ''.date('Y-m-d h:i:s');
                if ($taskUserNote->save()) {
                    $response['error'] = false;
                    $response['html'] = $this->getNotesRender($taskUserNote->task_user_id);
                }
            }
        }
        return json_encode($response);
    }
    public function actionEdit() {
        $post = Yii::$app->request->post();
        $response['error'] = true;
        if(isset($post)) {
            $note = $post['note'];
            if($note != '') {
                $taskUserNote = TaskUserNote::find()->where([
                    'id' => $post['id'],
                ])->one();
                $taskUserNote->note = $note;
                if ($taskUserNote->save()) {
                    $response['error'] = false;
                    $response['html'] = $this->getNotesRender($taskUserNote->task_user_id);
                }
            }
        }
        return json_encode($response);
    }
    public function actionRemove() {
        $post = Yii::$app->request->post();
        $response['error'] = true;
        if(isset($post)) {
            $taskUserNote = TaskUserNote::find()->where([
                'id' => $post['id'],
            ])->one();
            $task_user_id = $taskUserNote->task_user_id;
            if ($taskUserNote->delete()) {
                $response['error'] = false;
                $response['html'] = $this->getNotesRender($task_user_id);
            }
        }
        return json_encode($response);
    }
}