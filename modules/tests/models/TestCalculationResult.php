<?php

namespace modules\tests\models;

use Yii;


class TestCalculationResult extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['points'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
        ];
    }
    public static function tableName()
    {
        return 'test_calculation_result';
    }
}
