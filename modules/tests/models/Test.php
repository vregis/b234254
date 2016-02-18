<?php

namespace modules\tests\models;

use Yii;


class Test extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 120],
            ['description', 'string', 'max' => 2000],

            [['name','description','start_page'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
        ];
    }
    public static function tableName()
    {
        return 'test';
    }
}
