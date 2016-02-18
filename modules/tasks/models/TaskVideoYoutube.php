<?php

namespace modules\tasks\models;

use Yii;


class TaskVideoYoutube extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
        ];
    }

    public static function tableName()
    {
        return 'task_video_youtube';
    }
}
