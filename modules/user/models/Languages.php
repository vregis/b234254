<?php

namespace modules\user\models;

class Languages extends \yii\db\ActiveRecord
{
    /** @inheritdoc */
    public static function tableName()
    {
        return 'language';
    }
}
