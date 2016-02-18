<?php

namespace modules\tasks\models;

use Yii;


class PaypalPayments extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
        ];
    }

    public static function tableName()
    {
        return 'paypal_payments';
    }
}
