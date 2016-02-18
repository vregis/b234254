<?php

namespace modules\tests\models;

use Yii;


class TestResult extends \yii\db\ActiveRecord
{

    public $dep_id;
    public $icons;


    public function rules()
    {
        return [
            ['name', 'string', 'max' => 255],
            ['color', 'string', 'max' => 10],
            [['name', 'color'], 'required'],
            [['title_high', 'description_high'], 'required'],
            [['title_medium', 'description_medium'], 'required'],
            [['title_low', 'description_low'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
        ];
    }
    public static function tableName()
    {
        return 'test_result';
    }
}
