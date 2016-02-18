<?php

namespace modules\user\models;

class UserSpecialization extends \yii\db\ActiveRecord
{

    var $name;
    var $dname;
    var $dep_id;
    var $spec_name;
    var $skillname;
    var $dep_hide = 0;
    var $spec_hide = 0;

    /** @inheritdoc */
    public static function tableName()
    {
        return 'user_specialization';
    }
}
