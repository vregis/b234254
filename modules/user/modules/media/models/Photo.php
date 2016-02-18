<?php

namespace modules\user\modules\media\models;

use modules\core\base\ActiveRecord;
use modules\core\behaviors\PurifierBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Модель для таблицы "{{%user_media_photo}}"
 *
 * @property int $id
 * @property int $album_id
 * @property string $description
 * @property int $rating_like
 * @property int $rating_dislike
 * @property int $img_width
 * @property int $img_height
 * @property int $created_at
 * @property int $updated_at
 * @property int $total_comments
 * @property int $unique_id
 *
 * @property PhotoAlbum $album
 * @property PhotoComment[] $comments
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Photo extends ActiveRecord
{
    use ModuleTrait;

    /**
     * @var string Загружаемое изображение
     */
    public $image_file;

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
                'textAttributes' => ['description'],
            ],
        ];
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return 'user_media_photo';
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // album_id
            [['album_id'], 'integer'],
            [['album_id'], 'exist', 'targetClass' => PhotoAlbum::className(), 'targetAttribute' => 'id'],
            // description
            [['description'], 'required', 'on' => 'default'],
            [['description'], 'trim'],
            [['description'], 'string', 'max' => 3000],
            // rating_like
            //[['rating_like'], 'integer'],
            // rating_dislike
            //[['rating_dislike'], 'integer'],
            // img_width
            //[['img_width'], 'integer'],
            // img_height
            //[['img_height'], 'integer'],
            // total_comments
            //[['total_comments'], 'integer'],
            // image_file
            [
                'image_file',
                'image',
                'extensions' => ['png', 'jpg'],
                'maxSize' => $this->module->imageMaxSize,
                'minWidth' => $this->module->imageMinWidth,
                'maxWidth' => $this->module->imageMaxWidth,
                'minHeight' => $this->module->imageMinHeight,
                'maxHeight' => $this->module->imageMaxHeight,
                'on' => 'image',
            ],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user-media', 'ID'),
            'album_id' => Yii::t('user-media', 'ID альбома'),
            'description' => Yii::t('user-media', 'Описание'),
            'rating_like' => Yii::t('user-media', 'Понравилось'),
            'rating_dislike' => Yii::t('user-media', 'Не понравилось'),
            'img_width' => Yii::t('user-media', 'Длина изображения'),
            'img_height' => Yii::t('user-media', 'Высота изображения'),
            'created_at' => Yii::t('user-media', 'Дата создания'),
            'updated_at' => Yii::t('user-media', 'Дата редактирования'),
            'total_comments' => Yii::t('user-media', 'Всего комментариев'),
            'unique_id' => Yii::t('user-media', 'Уникальный код для названия директории альбома'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(PhotoAlbum::className(), ['id' => 'album_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(PhotoComment::className(), ['photo_id' => 'id'])->orderBy('id');
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        // если новая запись
        if ($insert) {
            // Код для названия файла
            $this->unique_id = uniqid();
        }
        return parent::beforeSave($insert);
    }

    /** @inheritdoc */
    public function afterSave($insert, $changedAttributes)
    {
        // если новая запись
        if ($insert) {
            // увеличиваем количество фото в альбоме на 1
            PhotoAlbum::findOne($this->album_id)->updateCounters(['total_photos' => 1]);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /** @inheritdoc */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            // уменьшаем количество фото в альбоме на 1
            PhotoAlbum::findOne($this->album_id)->updateCounters(['total_photos' => -1]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Формирует JSON массив с изображениями альбома для JS переменной "img_massiv"
     *
     * @param $photos
     * @param $album
     * @return string
     */
    public static function getPhotosJson($photos, $album)
    {
        /** @var \frontend\modules\user\modules\media\Module $userMediaMod */
        $userMediaMod = Yii::$app->getModule('user/media');

        $total_photos = count($photos);

        $albumUrl = $userMediaMod->getPhotoAlbumUrl(
            $album->user_id,
            $album->id,
            $album->unique_id
        );

        $arr = [];
        foreach ($photos as $photo) {

            $photoUrl = $userMediaMod->getPhotoUrl(
                $albumUrl,
                $photo->id,
                $photo->unique_id
            );

            $arr[] = [
                'id' => (int)$photo->id,
                'description' => Html::encode($photo->description),
                'img_url' => Html::encode($photoUrl),
                'img_width' => (int)$photo->img_width,
                'img_height' => (int)$photo->img_height,
                'total_photos' => (int)$total_photos,
                'total_comments' => (int)$photo->total_comments,
            ];
        }
        return Json::encode($arr, JSON_FORCE_OBJECT); // чтобы остались ключи [0=>[...], 1=> [...]]
    }
}