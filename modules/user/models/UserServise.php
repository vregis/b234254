<?php

namespace modules\user\models;

use Yii;
use modules\core\base\ActiveRecord as ActiveRecord;

class UserServise extends ActiveRecord
{
    /** @inheritdoc */
    public static function tableName()
    {
        return 'user_service';
    }
}