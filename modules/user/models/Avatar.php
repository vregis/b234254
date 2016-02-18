<?php

namespace modules\user\models;


use yii\base\Model;
use yii\web\UploadedFile;

class Avatar extends Model
{

    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
        ];
    }

}