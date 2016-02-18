<?php

namespace modules\milestones\models;

use Yii;


class Milestone extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['short_description', 'string', 'max' => 255],
            ['is_pay', 'integer'],
            ['is_hidden', 'integer'],
            [['name','description'], 'required'],
        ];
    }
    public static function tableName()
    {
        return 'milestone';
    }
    public static function getAllMilestone() {
        $all_milestone = new static();
        $all_milestone->id = -1;
        $all_milestone->name = "All Tasks";
        return $all_milestone;
    }
}
