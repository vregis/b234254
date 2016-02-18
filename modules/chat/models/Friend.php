<?php

namespace modules\chat\models;

use Yii;
use modules\user\models\User;
Use modules\user\models\Online;

/**
 * This is the model class for table "@_chat.friend".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $friend_id
 * @property integer $status
 * @property integer $is_visible
 * @property integer $not_friend
 *
 * @property User $friend
 * @property User $user
 */
class Friend extends \yii\db\ActiveRecord {

    
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return Yii::$app->params['dbname'].'_chat.friend';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'friend_id'], 'required'],
            [['user_id', 'friend_id', 'status', 'is_visible', 'is_favorite','not_friend','is_blocked'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'friend_id' => Yii::t('app', 'Friend ID'),
            'status' => Yii::t('app', '0-не включено, 1- включено'),
            'is_visible' => Yii::t('app', '0-видимый, 1 - не видимый'),
            'is_favorite' => Yii::t('app', '0-обычный, 1 - избранный'),
            'not_friend' => Yii::t('app', '0-друг, 1 - еще не друг'),
            'is_blocked' => Yii::t('app', '0-разблок, 1 - блокирован'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFriend() {
        return $this->hasOne(User::className(), ['id' => 'friend_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /*
     * 
     * return model
     */

    public static function getModelByUserId($id) {
        $model = self::find()->where(['user_id' => $id,'kill_dialog' => 0])->orderBy('created_at DESC')->all();
        return $model;
    }

    /*
     * 
     * return bool : true / false
     */

    public static function getVisible($id) {

        $model = self::find()->where(['user_id' => $id,'kill_dialog' => 0])->one();
        if (empty($model->is_visible)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 
     * return int count
     */

    public static function getOnlineCountity($model) {
        //Получить количество онлайн
        $i = 0;
        foreach ($model as $user) {
            $res = Online::getStatus($user->friend_id);
            if ($res == true && $user->friend_id != Yii::$app->user->id) {
                $i++;
            }
        }
        return $i;
    }

    /*
     * 
     * return string active
     */

    public static function getFavorit($id) {
        //Получить класс активе
//vd($id);
        $model = self::find()->where(['friend_id' => $id, 'user_id' => Yii::$app->user->id])->one();
        if (!empty($model) && $model->is_favorite == 1) {         
            return "active";
        } else {
            return '';
        }
    }
    /*
     * 
     * return bool true or false
     */

    public static function getIsFriendOfMine($id) {
        //Получить true or false
        $test = Yii::$app->user->id;
        $model = self::find()->where(['friend_id' => $id, 'user_id' => Yii::$app->user->id,'kill_dialog' => 0,'not_friend' => 0])->one();
        if (!$model) {
            return true;
        } else {
            return false;
        }
    }
    /*
     * 
     * return bool true or false
     */

    public static function getIsBlokedUser($id) {
        //Получить true or false

        $model = self::find()->where(['friend_id' => $id, 'user_id' => Yii::$app->user->id])->one();
        if ( isset($model) && $model->is_blocked == 1 ) {
            return true;
        } else {
            return false;
        }
    }
    /*
     * 
     * return bool true or false
     */

    public static function isIamBlokedByUser($id) {
        //Получить true or false

        $model = self::find()->where(['friend_id' => Yii::$app->user->id, 'user_id' => $id])->one();
        if ( isset($model) && $model->is_blocked == 1 ) {
            return true;
        } else {
            return false;
        }
    }
    /*
     * 
     * return bool true or false
     */
    public static function IsKillDialog($id){
       //Получить true or false

        $model = self::find()->where(['user_id' => Yii::$app->user->id, 'friend_id' => $id])->one();
        if ( isset($model) && $model->kill_dialog == 1 ) {
            return true;
        } else {
            return false;
        } 
    }

}
