<?php

namespace modules\tests\models;

use Yii;


class TestOption extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 255],
            [['name'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
        ];
    }
    public static function tableName()
    {
        return 'test_option';
    }
}
