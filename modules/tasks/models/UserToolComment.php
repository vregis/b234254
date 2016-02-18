<?php

namespace modules\tasks\models;

use modules\departments\models\Idea;
use Yii;


class UserToolComment extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
        ];
    }
    public static function tableName()
    {
        return 'user_tool_comment';
    }
}
