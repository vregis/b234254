<?php

namespace modules\departments\site\controllers;


use modules\departments\models\Department;
use modules\departments\models\Team;
use modules\departments\models\UserDo;
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
            ->groupBy('user_profile.user_id')
            ->limit(5)
            ->all();

        return $users;

    }

    public function actionInviteUser(){
        if($_POST){
            $req = new Team();
        }
    }

}