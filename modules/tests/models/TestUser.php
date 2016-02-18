<?php

namespace modules\tests\models;

use Yii;


class TestUser extends \yii\db\ActiveRecord
{

    var $result;
    var $points;

    public static function tableName()
    {
        return 'test_user';
    }
}
