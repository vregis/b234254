<?php

namespace modules\departments\models;

use Yii;


class Benefit extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['first','second', 'third'], 'required', 'message' => 'This field cannot be blank.']
        ];
    }

    public static function tableName()
    {
        return 'benefit';
    }
}