<?php

namespace modules\departments\models;

use Yii;


class Specialization extends \yii\db\ActiveRecord
{

    var $dname;

    public function rules()
    {
        return [
            ['name', 'string', 'max' => 120],
            ['description', 'string', 'max' => 2000],
            ['icons', 'string', 'max' => 120],

            ['recommend_payment_low', 'double'],
            ['recommend_payment_medium', 'double'],
            ['recommend_payment_high', 'double'],
            ['market_rate_min', 'double'],
            ['market_rate_max', 'double'],

            [['name', 'description', 'icons', 'market_rate_min', 'market_rate_max'], 'required'],
        ];
    }
    public static function tableName()
    {
        return 'specialization';
    }
}
