<?php

namespace modules\user\models;

use modules\departments\models\Industry;

class UserIndustry extends \yii\db\ActiveRecord
{

    /** @inheritdoc */
    public static function tableName()
    {
        return 'user_industry';
    }


    public static function getUserIndustry($user_id, $ind_id=0){

        $ind = UserIndustry::find()->where(['user_id' => $user_id])->all();
        if($ind){
            $industry_array = [];
            $i = 0;
            foreach($ind as $in){
                if($in->industry_id != $ind_id) {
                    $industry_array[$i] = $in->industry_id;
                    $i++;
                }
            }
            $industry = Industry::find()->where(['not in','id',$industry_array])->all();
        }else{
            $industry = Industry::find()->all();
        }

        return $industry;

    }

}
