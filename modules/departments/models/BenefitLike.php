<?php

namespace modules\departments\models;

use Yii;


class BenefitLike extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
        ];
    }

    public static function tableName()
    {
        return 'benefit_like';
    }
}