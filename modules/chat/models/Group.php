<?php

namespace modules\chat\models;

use Yii;
use modules\chat\models\GroupAlternativeName;

/**
 * This is the model class for table "@_chat.group".
 *
 * @property integer $id
 * @property string $name
 *
 * @property GroupMembers[] $groupMembers
 * @property GroupMessages[] $groupMessages
 */
class Group extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return Yii::$app->params['dbname'].'_chat.group';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Наименование'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupMembers() {
        return $this->hasMany(GroupMembers::className(), ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupMessages() {
        return $this->hasMany(GroupMessages::className(), ['group_id' => 'id']);
    }

    // Вернет имя группы по Id группы , приоритет если есть альтернативное имя , то вернуть его в аервую очередь
    public static function getGroupNameById($id) {
        // Поиск альтернативного имени
        $result = GroupAlternativeName::find()->where(['group_id' => $id, 'user_id' => Yii::$app->user->id])->one();
        if ($result) {
            return $result->alternative_name;
        } else {
            $model = Group::find()->where(['id' => $id])->one();
            return $model->name;
        }
    }

    public static function getGroupsById($id) {
        $model = self::find()->where(['id' => $id])->one();
        return $model->name;
    }

    // Проверка моя ли группа
    public static function Is_my($id) {
        $model = Group::find()->where(['id' => $id])->one();
        $author = $model->author_id;
        //vd($author);
        if ($author == Yii::$app->user->id) {
            return true;
        } else {
            return false;
        }
    }

}
