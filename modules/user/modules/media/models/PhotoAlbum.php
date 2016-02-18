<?php

namespace modules\user\modules\media\models;

use modules\core\base\ActiveRecord;
use modules\core\behaviors\PurifierBehavior;
use modules\user\models\User;
use modules\user\modules\media\Module as UserMediaModule;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;

/**
 * Модель для таблицы "{{%user_media_photo_album}}"
 *
 * @property int $id
 * @property int $user_id
 * @property int $cover_id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 * @property int $total_photos
 * @property int $unique_id
 *
 * @property Photo $cover
 * @property User $user
 * @property Photo[] $photos
 *
 * @author MrArthur
 * @since 1.0.0
 */
class PhotoAlbum extends ActiveRecord
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
                'textAttributes' => ['title'],
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
        return 'user_media_photo_album';
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // user_id
            //[['user_id'], 'integer'],
            //[['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            // cover_id
            [['cover_id'], 'integer'],
            [['cover_id'], 'exist', 'targetClass' => Photo::className(), 'targetAttribute' => 'id'],
            // title
            [['title'], 'required'],
            [['title'], 'trim'],
            [['title'], 'string', 'min' => 2, 'max' => 255],
            /*[
                ['title'],
                'unique',
                'targetAttribute' => ['title', 'user_id'],
                'message' => Yii::t('user-media', 'У Вас уже есть альбом') . ' "{value}"'
            ],*/
            // total_photos
            //[['total_photos'], 'integer'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user-media', 'ID'),
            'user_id' => Yii::t('user-media', 'ID пользователя'),
            'cover_id' => Yii::t('user-media', 'ID обложки'),
            'title' => Yii::t('user-media', 'Название'),
            'created_at' => Yii::t('user-media', 'Дата создания'),
            'updated_at' => Yii::t('user-media', 'Дата редактирования'),
            'total_photos' => Yii::t('user-media', 'Всего фотографий'),
            'unique_id' => Yii::t('user-media', 'Уникальный код для названия директории альбома'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCover()
    {
        return $this->hasOne(Photo::className(), ['id' => 'cover_id']);
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
    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['album_id' => 'id']);
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        // если новая запись
        if ($insert) {
            // обложка альбома
            $this->cover_id = null;
            // код для названия директории альбома
            $this->unique_id = uniqid();
        }
        return parent::beforeSave($insert);
    }

    /**
     * Возвращает альбомы пользователя
     *
     * @param null $user_id
     * @return static[]
     */
    public static function getUserAlbums($user_id)
    {
        $user_id = (int)$user_id;

        /** @var \frontend\modules\user\modules\media\Module $userMediaMod */
        $userMediaMod = Yii::$app->getModule('user/media');

        return static::find()
            ->where(['user_id' => $user_id])
            ->orderBy(['id' => SORT_DESC])
            ->limit($userMediaMod->albumsLimitIndex)
            ->all();
    }

    /**
     * Возвращает все альбомы пользователя, кроме текущего
     *
     * @param int $album_id ID текущего альбома
     * @param int $user_id ID пользователя, которому пренадлежит текущий альбом
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getOtherAlbums($album_id, $user_id)
    {
        return static::find()
            ->where(
                'user_id=:user_id AND id !=:current_id',
                [':user_id' => $user_id, 'current_id' => $album_id]
            )
            ->all();
    }

    /**
     * Устанавливает фото с наименьшим ID обложкой альбома
     *
     * @param $album_id
     */
    public static function setFirstPhotoAsCover($album_id)
    {
        $album = static::findOne($album_id);

        if (!empty($album)) {
            /** @var Photo $firstPhoto */
            $firstPhoto = Photo::find()
                ->where('album_id=:album_id', [':album_id' => $album_id])
                ->orderBy('id')
                ->one();

            if (!empty($firstPhoto)) {
                $album->cover_id = $firstPhoto->id;
                $album->save();
            }
        }
    }

    /**
     * Проверяет, не существует ли уже альбома с дефолтным названием у текущего пользователя
     *
     * @return bool
     */
    /*public static function defaultAlbumExists()
    {
        $defaultAlbum = static::find()
            ->where('user_id=:user_id AND title=:title')
            ->addParams(
                [
                    ':user_id' => Yii::$app->user->id,
                    ':title' => Yii::$app->getModule('user/media')->defaultAlbumTitle
                ]
            )
            ->one();

        return $defaultAlbum === null ? false : true;
    }*/

    /**
     * Удаляет альбомы без фотографий, которые были созданы более 30 дней назад
     *
     * @return mixed
     */
    public static function cronRemoveUnusedDefaultAlbums()
    {
        // Время в секундах, по истечении которого записи устаревают и удаляются
        $expireTime = 60 * 60 * 24 * 7; // 7 дней
        $sqlSelect = "SELECT id, unique_id, user_id
                FROM {{%user_media_photo_album}}
                WHERE total_photos=0 AND created_at < (UNIX_TIMESTAMP() - :expireTime)";
        $command = Yii::$app->db->createCommand($sqlSelect);
        $command->bindParam(':expireTime', $expireTime, \PDO::PARAM_INT);
        $albums = $command->queryAll();

        // если ничего не найдено, возвращаем 0
        if (empty($albums)) {
            return 0;
        }

        $userMediaMod = new UserMediaModule('user/media');

        $countDeleted = 0;

        // удаляем в цикле альбомы с директориями
        foreach ($albums as $album) {
            // получаем путь к директории с изображениями альбома
            $albumPath = $userMediaMod::getPhotoAlbumPath($album['user_id'], $album['id'], $album['unique_id']);
            // удаляем альбом по ID
            $sqlDelete = "DELETE FROM {{%user_media_photo_album}} WHERE id=:album_id";
            $command = Yii::$app->db->createCommand($sqlDelete);
            $command->bindParam(':album_id', $album['id'], \PDO::PARAM_INT);
            $deleted = $command->execute();
            // если удалили альбом, увеличиваем счетчик удаленных альбомов и удаляем директорию с изображениями альбома
            if (!empty($deleted)) {
                $countDeleted++;
                FileHelper::removeDirectory($albumPath);
            }
        }
        return $countDeleted;
    }
}