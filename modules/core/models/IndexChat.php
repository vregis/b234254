<?php

namespace modules\core\models;

use modules\core\base\ActiveRecord;
use modules\core\behaviors\PurifierBehavior;
use modules\user\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Модель для таблицы "{{%index_chat}}"
 *
 * @property string $id
 * @property integer $user_id
 * @property string $username
 * @property string $message
 * @property integer $created_at
 *
 * @property User $user
 */
class IndexChat extends ActiveRecord
{
    use ModuleTrait;

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%index_chat}}';
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // TimestampBehavior
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
            // PurifierBehavior
            [
                'class' => PurifierBehavior::className(),
                'textAttributes' => ['message', 'username'],
            ],
            // BlameableBehavior
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'user_id',
                ]
            ],
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // user_id
            //[['user_id'], 'integer'],
            //[['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            // username
            //[['username'], 'required'],
            //[['username'], 'trim'],
            //[['username'], 'string'],
            // message
            [['message'], 'required'],
            [['message'], 'trim'],
            [['message'], 'string', 'min' => 2, 'max' => $this->module->chatMessageMaxLength],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('dota', 'ID'),
            'user_id' => Yii::t('dota', 'ID пользователя'),
            'username' => Yii::t('dota', 'Ник пользователя'),
            'message' => Yii::t('dota', 'Текст сообщения'),
            'created_at' => Yii::t('dota', 'Дата добавления'),
        ];
    }

    /** @return \yii\db\ActiveQuery */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /** @inheritdoc */
    public function afterSave($insert, $changedAttributes)
    {
        // если новая запись
        if ($insert) {
            // устанавливаем время последнего комментария в сессию
            Yii::$app->session->set('last_comment', time());
        }
        parent::afterSave($insert, $changedAttributes);
    }


    /**
     * Возвращает последние сообщения в чате
     *
     * @return array
     */
    public static function getMessages()
    {
        /** @var \frontend\modules\core\Module $coreMod */
        $coreMod = Yii::$app->getModule('core');

        return self::find()
            ->orderBy(['id' => SORT_DESC])
            ->limit($coreMod->chatMessagesLimit)
            ->asArray()
            ->all();
    }

    /**
     * Удаляет устаревшие сообщения чата
     *
     * @return int
     */
    public static function cronCleanChat()
    {
        // @todo сделать позже удаление старых сообщений чата
    }

    /**
     * Проверяет, есть ли новые сообщения в чате с момента последней проверки
     *
     * @param int $id ID последнего сообщения в чате
     * @return bool|int
     */
    public static function hasNewMessages($id)
    {
        $sql = "SELECT MAX(id) as last_message_id FROM {{%index_chat}}";
        $result = Yii::$app->db->createCommand($sql)->queryOne();
        return $result['last_message_id'] > $id ? (int)$result['last_message_id'] : false;
    }
}