<?php

namespace modules\departments\models;

use Yii;


class Department extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 120],
            ['icons', 'string', 'max' => 120],

            [['name', 'description', 'icons', 'is_additional'], 'required'],
        ];
    }
    public static function tableName()
    {
        return 'department';
    }
}
