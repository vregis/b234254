<?php

namespace modules\tasks\models;

use Yii;


class TaskLink extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
        ];
    }

    public static function tableName()
    {
        return 'task_link';
    }
}
