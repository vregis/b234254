<?php

namespace modules\tasks\models;

use modules\departments\models\Idea;
use Yii;


class UserTool extends \yii\db\ActiveRecord
{
    const STATUS_CREATION = 0;
    const STATUS_IDEA_FILLED = 1;
    const STATUS_IDEA_BENEFITS_FILLED = 2;
    const STATUS_IDEA_SHARED = 3;

    public $name;
    public $country;
    public $idea_name;
    public $idea_description_like;
    public $idea_description_problem;
    public $industry_name;
    public $benefit_first;
    public $benefit_second;
    public $benefit_third;
    public $industry_id;
    public $location_id;
    public $avatar;

    public $idea_like;
    public $idea_dislike;




    public function rules()
    {
        return [
        ];
    }
    public static function tableName()
    {
        return 'user_tool';
    }

    public static function getCurrentUserTool($is_my = false) {
        $user_id = Yii::$app->user->identity->id;
        if(!isset(Yii::$app->session['tool_id']) || $is_my) {
            $userTool = UserTool::find();
            $userTool->where(['user_id' => $user_id])->orderBy(['id' => SORT_DESC]);
            $userTool = $userTool->one();
            if($userTool && !$is_my) {
                Yii::$app->session['tool_id'] = $userTool->id;
            }
        }else {
            $userTool = UserTool::find()->where(['id' => Yii::$app->session['tool_id']])->one();
        }
        return $userTool;
    }
    public static function createUserTool() {
        $userTool = new UserTool();
        $userTool->user_id = Yii::$app->user->id;
        $userTool->create_date = '' . date('Y-m-d h:i:s');
        $userTool->save();
        return $userTool;
    }
    public static function createNewUserTool() {
        $userTool = new UserTool();
        $userTool->user_id = Yii::$app->user->id;
        $userTool->status = 10;
        $userTool->create_date = '' . date('Y-m-d h:i:s');
        $userTool->save();
        return $userTool;
    }
}
