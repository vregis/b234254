<?php

namespace modules\chat\models;

use Yii;

/**
 * This is the model class for table "@_chat.group_alternative_name".
 *
 * @property integer $id
 * @property integer $group_id
 * @property string $alternative_name
 * @property integer $user_id
 *
 * @property User $user
 * @property Group $group
 */
class GroupAlternativeName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Yii::$app->params['dbname'].'_chat.group_alternative_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'alternative_name', 'user_id'], 'required'],
            [['group_id', 'user_id'], 'integer'],
            [['alternative_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'alternative_name' => Yii::t('app', 'Alternative Name'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }
}