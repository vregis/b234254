<?php

namespace modules\tests\models;

use yii\base\Model;

class TestProgressForm extends Model
{
    public $option;

    public function rules () {

        return [
            [['option'], 'required'],
        ];
    }
}