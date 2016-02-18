<?php

namespace modules\departments\models;

use Yii;


class Industry extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 255],

            [['name','description', 'icons'], 'required'],
        ];
    }

    public static function tableName()
    {
        return 'industry';
    }
}
