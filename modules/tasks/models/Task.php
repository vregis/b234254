<?php

namespace modules\tasks\models;

use Yii;


class Task extends \yii\db\ActiveRecord
{

    /*var $start = '';
    var $end = '';*/
    var $task_id = '';
    var $status = '';
    var $duration = '';
    var $task = '';
    var $spec = '';
    var $tool = '';
    var $task_user;
    var $delegate_user;
    var $is_pay;
    var $dname;
     public $delegate_task_status;
    public $task_user_status;
    public $is_request;

    public $spec_name;

    public $del_id;

    static public $task_steve_roadmap_personal_id = 287;
    static public $task_steve_bussiness_role_id = 285;
    static public $task_steve_comfort_place_id = 286;
    static public $task_roadmap_personal_id = 287;
    static public $task_bussiness_role_id = 285;
    static public $task_comfort_place_id = 286;
    /*static public $task_roadmap_personal_id = 284;
    static public $task_bussiness_role_id = 282;
    static public $task_comfort_place_id = 283;*/
    static public $task_person_goal_id = 168;
    static public $task_idea_id = 37;
    static public $task_idea_benefits_id = 38;
    static public $task_idea_share_id = 39;

    public function rules()
    {
        return [
            ['name', 'string', 'max' => 120],
            array(
                'name',
                'match', 'pattern' => '/^[\*a-zA-Z0-9]/',
                'message' => 'Invalid characters in name.',
            ),
            ['description', 'string', 'max' => 2000],
            array(
                'description',
                'match', 'pattern' => '/http|www|https|<a.*>/',
                'message' => 'Links can not be used in description.',
                'not' => true
            ),
            ['temp_id', 'string'],
            ['sort', 'integer'],
            ['specialization_id', 'integer'],
            ['time', 'integer'],
            ['recommended_time', 'integer', 'min' => 1],

            ['is_roadmap', 'integer'],

            [['market_rate', 'button_name', 'second_button_name', 'roadmap_name'], 'string'],

            [['name','description','director_name','priority','performed_immediately'], 'required'],
            [['department_id'],'required', 'message' => 'Please choose department']
        ];
    }

    public function attributeLabels()
    {
        return [
            'director_name' => 'The director of the task',
            'performed_immediately' => 'Performed immediately after the end of preceding tasks',
            'performed_after' => 'Performed only after the preceding tasks',
            'sort' => 'Ordering',
            'department_id' => 'Department',
            'specialization_id' => 'Specialization'
        ];
    }
    public static function tableName()
    {
        return 'task';
    }

    public function getIs_custom() {
        if($this->id == static::$task_roadmap_personal_id ||
            $this->id == static::$task_bussiness_role_id ||
            $this->id == static::$task_comfort_place_id ||
            $this->id == static::$task_person_goal_id ||
            $this->id == static::$task_idea_id ||
            $this->id == static::$task_idea_benefits_id ||
            $this->id == static::$task_idea_share_id ||
            $this->is_roadmap) {
            return 1;
        }
        return 0;
    }


}
