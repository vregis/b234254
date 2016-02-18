<?php

namespace modules\departments\models;

use Yii;


class Idea extends \yii\db\ActiveRecord
{

    var $iname;
    var $ideaname;


    public function rules()
    {
        return [
            ['name', 'string', 'max' => 150, 'tooLong' => 'This field should contain at most 255 characters'],
            ['create_date', 'string'],

            [['name','description_like', 'description_problem'], 'required', 'message' => 'This field cannot be blank.'],
            [['industry_id'], 'required', 'message' => 'Please choose industry'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'What’s the name of it?',
            'description_like' => 'What is it like?',
            'description_problem' => 'What problem does it solve?',
            'description_planning' => 'How are you planning to do that?',
            'industry_id' => 'Industry'
        ];
    }

    public static function tableName()
    {
        return 'idea';
    }
}
