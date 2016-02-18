<?php

namespace modules\chat\models;

use Yii;

/**
 * This is the model class for table "@_chat.group_members".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $member_id
 * @property integer $is_deleted
 */
class Group_members extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return Yii::$app->params['dbname'].'_chat.group_members';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['group_id', 'member_id'], 'required'],
            [['group_id', 'member_id', 'is_deleted'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'is_deleted' => Yii::t('app', 'Удален ли'),
        ];
    }

    /*
     * @return model
     * Выводит группы где пользователь автор или член
     */

    public static function getGroupsById($id) {
        $model = self::find()
            ->where(['member_id' => $id, 'is_deleted' => 0])

            ->all();

        return $model;
    }
    /*
     * @return model
     * Выводит членов этой группы
     */

    public static function getMembersByGroupId($id) {
        $model = self::find()
                ->where(['group_id' => $id, 'is_deleted' => 0])
                ->all();

        return $model;
    }

    /*
     * @return model
     * Выводит количество все записей
     */

    public static function getTotalMembers() {
        $model = self::find()->all();
        return count($model);
    }

}
