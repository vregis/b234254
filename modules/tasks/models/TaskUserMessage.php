<?php

namespace modules\tasks\models;

use Yii;


class TaskUserMessage extends \yii\db\ActiveRecord
{
    public $name;
    public $ava;
    public $milestone_id;
    public $tool_id;

    public function rules()
    {
        return [
        ];
    }

    public static function tableName()
    {
        return 'task_user_message';
    }
}
