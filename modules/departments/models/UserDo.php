<?php

namespace modules\departments\models;

use Yii;


class UserDo extends \yii\db\ActiveRecord
{

    public $dname = '';
    public $high = '';
    public $icon = '';
    public $color = '';
    public $ava = '';
    public $fname = '';
    public $lname = '';
    public $country = '';
    public $city = '';
    public $idd = '';

    public static function tableName()
    {
        return 'user_do';
    }
}