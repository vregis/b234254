<?php
namespace modules\user\models\forms;
use yii\base\Model;
use Yii;

class ForgottpassForm extends Model {

    public $password;
    public $password_repeat;

    public function rules(){

        return [

            // password
            ['password', 'required'],
            ['password', 'trim'],
            ['password', 'string', 'min' => 6],
            // password_repeat
            ['password_repeat', 'required'],
            ['password', 'trim'],
            ['password_repeat', 'string', 'min' => 6],
            [
                'password_repeat',
                'compare',
                'compareAttribute' => 'password',
                'message' => Yii::t('user', 'Passwords do not match')
            ],
        ];

    }

}