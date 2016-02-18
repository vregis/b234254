<?php

namespace modules\user\models;

use Yii;
use modules\core\base\ActiveRecord as ActiveRecord;

class SkillTag extends ActiveRecord
{

    /** @inheritdoc */
    public static function tableName()
    {
        return 'skill_tag';
    }
}