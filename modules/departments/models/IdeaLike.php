<?php

namespace modules\departments\models;

use Yii;


class IdeaLike extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
        ];
    }
    public static function tableName()
    {
        return 'idea_like';
    }
}