<?php

namespace modules\tasks\site\controllers;

use Faker\Provider\DateTime;
use modules\core\site\base\Controller;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use Yii;
use yii\filters\AccessControl;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class GantController extends Controller
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
                            'movetasks',
                        ],
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {


        $tasks = Task::find()->select('task.*, task_user.start as start, task_user.end as end')->join('JOIN', 'task_user', 'task_user.task_id = task.id')->all();

        return $this->render('index', ['tasks' => $tasks]);
    }

    public function actionMovetasks(){

        $task = TaskUser::find()->where(['task_id'=>$_POST['id']])->one();
        if($task) {
            $e = new \DateTime();
            $d = $e->setTimestamp ( round($_POST['start']/1000) );
            $start = $d->format('Y-m-d');

            $e2 = new \DateTime();
            $d2 = $e2->setTimestamp ( round($_POST['end']/1000));
            $end = $d2->format('Y-m-d');

            $task->start = $start;
            $task->end = $end;

            //var_dump($task);
            //die();

            if(!$task->save()){
                var_dump($task->getErrors());
                die();
            }

            $task->save();



        }

        die(json_encode($_POST));
    }

}