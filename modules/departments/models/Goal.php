<?php

namespace modules\departments\models;

use Yii;


class Goal extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['count_money', 'integer'],
            [['date'], 'date', 'format' => 'yyyy-M-d', 'message' => 'Invalid date format.'],

            [['count_money'], 'required'],
            [['date'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'count_money' => 'I want to make',
            'date' => 'By this date',
        ];
    }

    public static function tableName()
    {
        return 'goal';
    }
}
