<?php

namespace modules\user\models;

class UserIndustry extends \yii\db\ActiveRecord
{

    /** @inheritdoc */
    public static function tableName()
    {
        return 'user_industry';
    }
}
