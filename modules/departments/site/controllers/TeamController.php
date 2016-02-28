<?php

namespace modules\departments\site\controllers;


use modules\departments\models\Department;
use modules\departments\models\Team;
use modules\departments\models\UserDo;
use modules\tasks\models\DelegateTask;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use modules\tasks\models\UserTool;
use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

class TeamController extends Controller {

    public $layout = "@modules/core/site/views/layouts/main";

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
                            'request',
                            'get-search',
                            'invite-user',
                        ],
                        'roles' => ['@'],

                    ]
                ]
            ],
        ];
    }

    public function actionIndex($id){
        $departments = Department::find()->all();
        $search_html = $this->renderPartial('blocks/team_search', ['departments' => $departments]);
        return $this->render('team', ['departments' => $departments, 'search_table' => $search_html]);
    }

    public function actionRequest($id){

        $departments = Department::find()->all();
        $search_html = $this->renderPartial('blocks/jobber_search', ['departments' => $departments, 'tool_id' => $id]);
        return $this->render('team-request', ['departments' => $departments, 'search_html' => $search_html]);
    }

    public static function getSearchChief($dep_id){

    }

    public function actionGetSearch(){
        $response['html'] = $this->renderPartial('blocks/team_search');
        return json_encode($response);
    }

    public static function getSearchUsers($dep_id){
        $users = UserDo::find()
            ->select('user_profile.avatar ava, user_profile.first_name fname, user_profile.last_name lname,
             user_profile.user_id dname, user_profile.city_title city, geo_country.title_en country')
            ->join('INNER JOIN','user_profile', 'user_profile.user_id = user_do.user_id')
            ->join('JOIN', 'geo_country', 'geo_country.id = user_profile.country_id')
            ->where(['user_do.status_sell' => 1, 'user_do.department_id' => $dep_id])
            ->orderBy(['user_profile.user_id' => SORT_DESC])
            ->groupBy('user_profile.user_id')
            ->limit(5)
            ->all();

        return $users;

    }

    public function actionInviteUser(){

        $task = Task::find()->where(['department_id' => $_POST['dep_id']])->all();
        if($task){
            foreach($task as $t){
                $tu = new TaskUser();
                $tu->task_id = $t->id;
                $tu->user_tool_id = $_POST['tool_id'];
                if(!$tu->save()){
                    var_dump($tu->getErrors()); die();
                }else{
                    $id = $tu->getPrimaryKey();
                    $dt = new DelegateTask();
                    $dt->delegate_user_id = $_POST['recipient'];
                    $dt->task_user_id = $id;
                    if(!$dt->save()) {
                        var_dump($dt->getErrors());
                        die();
                    }
                }


            }
        }



        if($_POST){
            $req = new Team();
            $req->user_tool_id = $_POST['tool_id'];
            $req->recipient_id = $_POST['recipient'];
            $req->sender_id = Yii::$app->user->id;
            $req->department = $_POST['dep_id'];
            $req->status = 0;
            $req->is_request = 0;
            $req->save();
        }
    }

}