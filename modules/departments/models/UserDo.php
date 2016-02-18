<?php

namespace modules\departments\models;

use Yii;


class UserDo extends \yii\db\ActiveRecord
{

    public $dname = '';
    public $high = '';
    public $icon = '';
    public $color = '';

    public static function tableName()
    {
        return 'user_do';
    }
}