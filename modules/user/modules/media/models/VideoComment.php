<?php

namespace modules\user\modules\media\models;

use modules\core\base\ActiveRecord;
use modules\core\behaviors\PurifierBehavior;
use modules\user\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Модель для таблицы "{{%user_media_video_comment}}"
 *
 * @property int $id
 * @property int $video_id
 * @property int $user_id
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property Video $video
 *
 * @author MrArthur
 * @since 1.0.0
 */
class VideoComment extends ActiveRecord
{
    use ModuleTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // TimestampBehavior
            [
                'class' => TimestampBehavior::className(),
            ],
            // PurifierBehavior
            [
                'class' => PurifierBehavior::className(),
                'textAttributes' => ['content'],
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
    public static function tableName()
    {
        return 'user_media_video_comment';
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // video_id
            [['video_id'], 'integer'],
            [['video_id'], 'exist', 'targetClass' => Video::className(), 'targetAttribute' => 'id'],
            // user_id
            //[['user_id'], 'integer'],
            //[['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            // content
            [['content'], 'required'],
            [['content'], 'trim'],
            [['content'], 'string', 'max' => 1000],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user-media', 'ID'),
            'video_id' => Yii::t('user-media', 'ID видео'),
            'user_id' => Yii::t('user-media', 'ID пользователя'),
            'content' => Yii::t('user-media', 'Содержимое'),
            'created_at' => Yii::t('user-media', 'Дата создания'),
            'updated_at' => Yii::t('user-media', 'Дата редактирования'),
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
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }

    /** @inheritdoc */
    public function afterSave($insert, $changedAttributes)
    {
        // если новая запись
        if ($insert) {
            // увеличиваем количество комментариев в таблице видео на 1
            Video::findOne($this->video_id)->updateCounters(['total_comments' => 1]);
            // устанавливаем время последнего комментария в сессию
            Yii::$app->session->set('last_comment', time());
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /** @inheritdoc */
    public function afterDelete()
    {
        // уменьшаем количество комментариев в таблице видео на 1
        Video::findOne($this->video_id)->updateCounters(['total_comments' => -1]);

        parent::afterDelete();
    }
}