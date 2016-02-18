<?php

namespace modules\tests\models;

use Yii;


class TestProgress extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['option'], 'required'],
        ];
    }
    public static function tableName()
    {
        return 'test_progress';
    }
}
