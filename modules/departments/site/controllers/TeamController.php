<?php

namespace modules\departments\site\controllers;


use modules\departments\models\Department;
use modules\departments\models\Team;
use modules\departments\models\UserDo;
use modules\tasks\models\DelegateTask;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use modules\tasks\models\UserTool;
use modules\user\models\Profile;
use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;
use yii\web\User;

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
                            'delete-invite-user',
                            'jobber-reject',
                            'jobber-accept',
                            'add-jobber-request',
                            'del-jobber-request',
                            'accept-req',
                            'del-req',
                        ],
                        'roles' => ['@'],

                    ]
                ]
            ],
        ];
    }

    public function actionIndex($id){
        $departments = Department::find()->where(['is_additional' => 0])->all();
        $search_html = $this->renderPartial('blocks/team_search', ['departments' => $departments]);
        $request_html = $this->renderPartial('blocks/team_request', ['departments' => $departments]);
        return $this->render('team', ['departments' => $departments, 'search_table' => $search_html, 'request_table' => $request_html]);
    }

    public function actionRequest($id){

        $departments = Department::find()->where(['is_additional' => 0])->all();
        $search_html = $this->renderPartial('blocks/jobber_search', ['departments' => $departments, 'tool_id' => $id]);
        $request_html = $this->renderPartial('blocks/jobber_request', ['departments' => $departments]);
        return $this->render('team-request', ['departments' => $departments, 'search_html' => $search_html, 'request_html' => $request_html]);
    }

    public static function getJobberRequest($dep_id,$tool_id){
        $team = Team::find()
            ->select('team.*, user_profile.avatar ava, user_profile.first_name fname, user_profile.last_name lname, user_profile.user_id dname')
            ->join('LEFT JOIN', 'user_profile', 'user_profile.user_id = team.sender_id')
            ->where(['team.department' => $dep_id, 'team.user_tool_id' => $tool_id, 'team.recipient_id' => Yii::$app->user->id, 'team.status' => 0])->all();
        return $team;
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
            ->join('LEFT OUTER JOIN', 'geo_country', 'geo_country.id = user_profile.country_id')
            ->where(['user_do.status_sell' => 1, 'user_do.department_id' => $dep_id])
            ->orderBy(['user_profile.user_id' => SORT_DESC])
            ->groupBy('user_profile.user_id')
            ->limit(5)
            ->all();

        return $users;

    }

    public static function getInvitedUser($id){
        $user = Profile::find()
            ->select('user_profile.*, geo_country.title_en country')
            ->join('LEFT JOIN', 'geo_country', 'geo_country.id=user_profile.country_id')
            ->where(['user_id' => $id])->one();
        return $user;
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

        return json_encode($_POST);
    }

    public function actionDeleteInviteUser(){
        if($_POST){
            $del = Team::find()->where([
                'user_tool_id' => $_POST['tool_id'],
                'recipient_id'=>$_POST['recipient'],
                'sender_id' => Yii::$app->user->id,
                'department' => $_POST['dep_id']
            ])->one();
            if($del){
                $del->delete();
            }
        }
        return(json_encode($_POST));
    }

    public function actionJobberReject(){
        $team = Team::find()->where([
            'user_tool_id' => $_POST['tool_id'],
            'department' => $_POST['dep_id'],
            'sender_id' => $_POST['sender_id'],
            'recipient_id' => Yii::$app->user->id
        ])->one();

        if($team){
            $team->delete();
        }

        //TODO reject tasks with reject business

        return json_encode($_POST);
    }

    public function actionJobberAccept(){
        $team = Team::find()->where([
            'user_tool_id' => $_POST['tool_id'],
            'department' => $_POST['dep_id'],
            'sender_id' => $_POST['sender_id'],
            'recipient_id' => Yii::$app->user->id
        ])->one();

        if($team){
            $team->status = 1;
            $team->save();
        }
    }

    public static function getApprovedUser($dep_id, $tool_id){
        $user = Team::find()
            ->select('team.*, user_profile.avatar as ava, user_profile.user_id dname')
            ->join('LEFT JOIN', 'user_profile', 'user_profile.user_id = team.recipient_id')
            ->where([
                'team.department' => $dep_id,
                'team.user_tool_id' => $tool_id,
                'team.sender_id' => Yii::$app->user->id,
                'team.status' => 1
            ])
            ->one();

        return $user;
    }

    public static function getJobberTasks($dep_id, $tool_id){
        $user = Profile::find()
            ->select('user_profile.*')
            ->join('LEFT JOIN', 'user_tool', 'user_profile.user_id = user_tool.user_id')
            ->where(['user_tool.id' => $tool_id])
            ->one();

        $do_department = UserDo::find()->where(['user_id' => $user->user_id, 'department_id' => $dep_id, 'status_do' => 1])->one();
        if($do_department){
            return null;
        }else{
            // TODO delete already delegeted tasks

            $tasks = Task::find()->where(['department_id' => $dep_id])->all();
            $milestones = Task::find()->where(['department_id' => $dep_id])->groupBy('milestone_id')->all();
            $return = [];
            $return['tasks'] = count($tasks);
            $return['milestones'] = count($milestones);
            $return['user'] = $user;
            return $return;
        }

    }

    public function actionAddJobberRequest(){

        $req = new Team();
        $req->user_tool_id = $_POST['tool_id'];
        $req->sender_id = $_POST['sender_id'];
        $req->recipient_id = Yii::$app->user->id;
        $req->department = $_POST['dep_id'];
        $req->is_request = 1;
        $req->save();



        return json_encode($_POST);
    }

    public static function getJobberRequests($dep_id, $tool_id){
        $req = Team::find()->where(['department' => $dep_id, 'user_tool_id' => $tool_id, 'recipient_id' => Yii::$app->user->id])->one();
        return $req;
    }

    public function actionDelJobberRequest(){
        $team = Team::find()->where([
            'user_tool_id' => $_POST['tool_id'],
            'sender_id' => $_POST['sender_id'],
            'recipient_id' => Yii::$app->user->id,
            'department' => $_POST['dep_id']
        ])
        ->one();
        $team->delete();
        return json_encode($_POST);
    }

    public static function getRequestFromJobber($dep_id, $tool_id){
        $team = Team::find()
            ->select('team.*, user_profile.first_name fname, user_profile.last_name lname, user_profile.avatar ava, user_profile.city_title city')
            ->join('LEFT JOIN', 'user_profile', 'team.recipient_id = user_profile.user_id')
            ->join('LEFT JOIN', 'geo_country', 'user_profile.country_id = geo_country.id')
            ->where([
                'team.user_tool_id' => $tool_id,
                'team.department' => $dep_id,
                'team.sender_id' => Yii::$app->user->id,
                'team.is_request' => 1])
            ->all();
        return $team;
    }

    public function actionAcceptReq(){
        $team = Team::find()->where(['id' => $_POST['id']])->one();
        if($team){
            $team->status = 1;
            $team->save();
        }
        return json_encode($_POST);
    }

    public function actionDelReq(){
        $team = Team::find()->where(['id' => $_POST['id']])->one();
        if($team){
            $team->delete();
        }
    }

    public static function checkDo($dep_id){
        $do = UserDo::find()->where(['department_id' => $dep_id, 'user_id' => Yii::$app->user->id, 'status_do' => 1])->one();
        return $do;
    }

    public static function getUserProfile(){
        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        return $profile;
    }

}