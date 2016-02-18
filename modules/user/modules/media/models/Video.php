<?php

namespace modules\user\modules\media\models;

use modules\core\base\ActiveRecord;
use modules\core\behaviors\PurifierBehavior;
use modules\core\components\Youtube;
use modules\core\helpers\TextHelper;
use modules\core\helpers\UrlHelper;
use modules\user\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Модель для таблицы "{{%user_media_video}}"
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property int $rating_like
 * @property int $rating_dislike
 * @property int $created_at
 * @property int $updated_at
 * @property int $total_comments
 * @property int $status
 *
 * @property User $user
 * @property VideoComment[] $userMediaVideoComments
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Video extends ActiveRecord
{
    use ModuleTrait;

    /**
     * @var string URL на видео с youtube.com, который вводит пользователь
     */
    public $url;

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
                'textAttributes' => ['title', 'code', 'description'],
            ],
            // BlameableBehavior
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => 'user_id',
                ]
            ],
        ];
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return 'user_media_video';
    }

    /** @inheritdoc */
    public function scenarios()
    {
        return [
            'default' => ['rating_like', 'rating_dislike'],
            'checkUrl' => ['url'],
            'saveVideo' => ['code', 'title', 'description'],
            'updateVideo' => ['title', 'description']
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // user_id
            //[['user_id'], 'integer', 'on' => ['saveVideo']],
            /*[
                ['user_id'],
                'exist',
                'targetClass' => User::className(),
                'targetAttribute' => 'id',
                'on' => ['saveVideo']
            ],*/
            // code
            [['code'], 'required', 'on' => ['saveVideo']],
            [['code'], 'trim', 'on' => ['saveVideo']],
            [['code'], 'string', 'min' => 10, 'max' => 16, 'on' => ['saveVideo']],
            [
                ['code'],
                'unique',
                'targetAttribute' => ['code', 'user_id'],
                'message' => Yii::t('user-media', 'У вас уже есть данное видео'),
                'on' => ['saveVideo']
            ],
            // title
            [['title'], 'required', 'on' => ['saveVideo', 'updateVideo']],
            [['title'], 'trim', 'on' => ['saveVideo', 'updateVideo']],
            [['title'], 'string', 'min' => 2, 'max' => 255, 'on' => ['saveVideo', 'updateVideo']],
            // description
            [['description'], 'trim', 'on' => ['saveVideo', 'updateVideo']],
            [['description'], 'string', 'max' => 10000, 'on' => ['saveVideo', 'updateVideo']],
            // rating_like
            //[['rating_like'], 'integer'],
            // rating_dislike
            //[['rating_dislike'], 'integer'],
            // total_comments
            //[['total_comments'], 'integer'],
            // status
            //[['status'], 'integer', 'on' => ['saveVideo']],
            // url
            [['url'], 'required', 'on' => ['checkUrl']],
            [['url'], 'trim', 'on' => ['checkUrl']],
            [['url'], 'string', 'max' => 255, 'on' => ['checkUrl']],
            [
                'url',
                function ($attr) {
                    $code = Youtube::parseVIdFromURL($this->$attr);
                    if (empty($code)) {
                        $this->addError($attr, Yii::t('user-media', 'Неправильная ссылка'));
                    }
                    if (static::checkVideoExists($code, Yii::$app->user->id)) {
                        $this->addError($attr, Yii::t('user-media', 'У вас уже есть данное видео'));
                    }
                },
                'on' => ['checkUrl']
            ],
            [
                ['url'],
                'unique',
                'targetAttribute' => ['code', 'user_id'],
                'message' => Yii::t('user-media', 'У вас уже есть данное видео'),
                'on' => ['checkUrl']
            ],
            [
                ['url'],
                'url',
                'message' => Yii::t(
                        'user-media',
                        'Неправильная ссылка. Пожалуйста введите ссылку на видео с youtube'
                    ),
                'on' => ['checkUrl']
            ],
            [
                ['url'],
                'match',
                'pattern' => $this->module->youtubePattern,
                'message' => Yii::t(
                        'user-media',
                        'Неправильная ссылка. Пожалуйста введите ссылку на видео с youtube'
                    ),
                'on' => ['checkUrl']
            ],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user-media', 'ID'),
            'user_id' => Yii::t('user-media', 'ID пользователя'),
            'code' => Yii::t('user-media', 'Код видео на youtube'),
            'title' => Yii::t('user-media', 'Название'),
            'description' => Yii::t('user-media', 'Описание'),
            'rating_like' => Yii::t('user-media', 'Понравилось'),
            'rating_dislike' => Yii::t('user-media', 'Не понравилось'),
            'created_at' => Yii::t('user-media', 'Дата создания'),
            'updated_at' => Yii::t('user-media', 'Дата редактирования'),
            'total_comments' => Yii::t('user-media', 'Всего комментариев'),
            'status' => Yii::t('user-media', 'Статус'),
            'url' => Yii::t('user-media', 'Ссылка на видео')
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
    public function getComments()
    {
        return $this->hasMany(VideoComment::className(), ['video_id' => 'id'])->orderBy('id');
    }

    /**
     * Возвращает видео пользователя
     *
     * @param null $user_id
     * @return static[]
     */
    public static function getUserVideos($user_id)
    {
        $user_id = (int)$user_id;

        /** @var \frontend\modules\user\modules\media\Module $userMediaMod */
        $userMediaMod = Yii::$app->getModule('user/media');

        return static::find()
            ->where(['user_id' => $user_id])
            ->orderBy(['id' => SORT_DESC])
            ->limit($userMediaMod->videosLimitIndex)
            ->all();
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        // очищаем описание
        $this->description = static::cleanDescription($this->description);

        return parent::beforeSave($insert);
    }

    /** @inheritdoc */
    public function afterDelete()
    {
        $this->module->removeYoutubePreviewDir($this->id);
        parent::afterDelete();
    }

    /** @inheritdoc */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            // создаем директорию, если ее еще нет
            $this->module->createYoutubePreviewDir($this->id);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Возвращает все видео пользователя, кроме текущего
     *
     * @param int $video_id ID текущего видео
     * @param int $user_id ID пользователя, которому пренадлежит текущий альбом
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getOtherVideos($video_id, $user_id)
    {
        return static::find()
            ->where(
                'user_id=:user_id AND id !=:current_id',
                [':user_id' => $user_id, 'current_id' => $video_id]
            )
            ->orderBy('RAND()') // @todo оптимизировать
            ->limit(10)
            ->all();
    }

    /**
     * Проверяет, существует ли уже видео по коду (youtube id) и id пользователя
     *
     * @param $code
     * @param $user_id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function checkVideoExists($code, $user_id)
    {
        $video = static::find()
            ->select('id')
            ->where('code=:code AND user_id=:user_id', [':code' => $code, ':user_id' => $user_id])
            ->one();

        return empty($video) ? false : true;
    }

    /**
     * Очищает описание, полученное с ютуба
     *
     * @param $desc
     * @return mixed|string
     */
    public static function cleanDescription($desc)
    {
        // удаляем ссылки
        $desc = preg_replace(UrlHelper::getUrlPattern(), '', $desc);
        // разбиваем длинные слова
        $desc = TextHelper::smartWordwrap($desc);
        // чистим пурифером
        $desc = TextHelper::filterPurify($desc);
        // удаляем пустые строки
        $desc = TextHelper::removeEmptyLines($desc);

        return $desc;
    }
}