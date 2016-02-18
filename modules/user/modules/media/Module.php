<?php

namespace modules\user\modules\media;

use modules\core\base\Module as CommonModule;
use modules\user\modules\media\models\PhotoAlbum;
use Yii;
use yii\helpers\FileHelper;

/**
 * Модуль [[user/media]] - common
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Module extends CommonModule
{
    /** @var int Количество альбомов на главной странице пользователя */
    public $albumsLimitIndex = 4;
    /** @var int Количество видео на главной странице пользователя */
    public $videosLimitIndex = 2;
    /** @var int Количество видео на главной странице пользователя */
    public $videosPerPage = 10;
    /** @var array Массив размеров изображений */
    public $sizes = [
        'small' => [
            'width' => 160,
            'height' => 120
        ],
    ];
    /** @var int Максимальный размер изображения в байтах */
    public $imageMaxSize = 10485760; // 10 мб
    /** @var int Минимальная длина изображения */
    public $imageMinWidth = 16;
    /** @var int Максимальная длина изображения */
    public $imageMaxWidth = 10000;
    /** @var int Минимальная высота изображения */
    public $imageMinHeight = 16;
    /** @var int Максимальная высота изображения */
    public $imageMaxHeight = 10000;
    /** @var int Максимальное количество загружаемых файлов за один раз */
    public $maxNumberOfFiles = 100;
    /** @var string Регулярное выражение для проверки URL на видео с youtube */
    public $youtubePattern = '/^(?:https?:\/\/)?(?:www\.)?youtu(?:\.be|be\.com)\/(?:watch\?v=)?([\w-]{10,})/';
    /** @var string Название дефолтного альбома */
    public $defaultAlbumTitle;

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        // i18n
        Yii::$app->i18n->translations['user-media'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru',
            'basePath' => '@common/messages',
        ];
    }

    /** @inheritdoc */
    public function getDependencies()
    {
        return ['core', 'user', 'rating'];
    }

    /**
     * Создает директории для изображений альбома (фото)
     *
     * @param $album_id
     * @param $unique_id
     * @return bool
     */
    public function createPhotoAlbumDirectory($album_id, $unique_id)
    {
        $albumPath = self::getPhotoAlbumPath(Yii::$app->user->id, $album_id, $unique_id);

        $ok = false;
        // создаем директорию альбома
        if (FileHelper::createDirectory($albumPath)) {
            $ok = true;
        }
        // создаем директории для различных размеров изображений
        foreach ($this->sizes as $size => $params) {
            if (!FileHelper::createDirectory($albumPath . '/' . $size)) {
                $ok = false;
            }
        }
        // если все создалось - возвращаем true
        if ($ok) {
            return true;
        }
        // если не удлось создать одну из директорий -
        // удаляем директорию альбома и возвращаем false
        else {
            FileHelper::removeDirectory($albumPath);
            return false;
        }
    }

    /**
     * Возвращает полный путь к директории альбома
     *
     * @param $user_id
     * @param $album_id
     * @param $unique_id
     * @return string
     */
    public static function getPhotoAlbumPath($user_id, $album_id, $unique_id)
    {
        return Yii::getAlias('@static') .  '/web/user/' . $user_id . '/photo/' . $album_id . $unique_id;
    }

    /**
     * Возвращает URL к директории альбома
     *
     * @param $user_id
     * @param $album_id
     * @param $unique_id
     * @return string
     */
    public static function getPhotoAlbumUrl($user_id, $album_id, $unique_id)
    {
        return Yii::$app->params['staticDomain'] . 'user/' . $user_id . '/photo/' . $album_id . $unique_id;
    }

    /**
     * Получение пути к изображению
     *
     * @param $albumPath
     * @param $photo_id
     * @param $photo_unique_id
     * @param $size
     * @return string
     */
    public static function getPhotoPath($albumPath, $photo_id, $photo_unique_id, $size = null)
    {
        $path = empty($size) ? $albumPath : $albumPath . '/' . $size;
        return $path . '/' . $photo_id . $photo_unique_id . '.jpg';
    }


    /**
     * Получение URL к изображению
     *
     * @param $albumUrl
     * @param $photo_id
     * @param $photo_unique_id
     * @param $size
     * @return string
     */
    public static function getPhotoUrl($albumUrl, $photo_id, $photo_unique_id, $size = null)
    {
        $url = empty($size) ? $albumUrl : $albumUrl . '/' . $size;
        return $url . '/' . $photo_id . $photo_unique_id . '.jpg';
    }

    /**
     * Получение URL к обожке альбома
     *
     * @param $album
     * @return string
     */
    public static function getAlbumCoverUrl(PhotoAlbum $album)
    {
        if (!empty($album->cover)) {

            $albumUrl = self::getPhotoAlbumUrl($album->user_id, $album->id, $album->unique_id);

            return self::getPhotoUrl(
                $albumUrl,
                $album->cover->id,
                $album->cover->unique_id,
                'small'
            );
        } else {
            return Yii::$app->params['staticDomain'] . 'default/album_cover.png';
        }
    }

    /**
     * Получение пути к директории с изображениями для видео
     *
     * @return string
     */
    public static function getVideoDir()
    {
        /** @var \common\modules\user\Module $userMod */
        $userMod = Yii::$app->getModule('user');
        return $userMod->getUserDir() . '/video';
    }

    /**
     * Возвращает URL к директории с видео
     *
     * @param $user_id
     * @return string
     */
    public static function getVideoDirUrl($user_id)
    {
        /** @var \common\modules\user\Module $userMod */
        $userMod = Yii::$app->getModule('user');
        return $userMod->getUserDirUrl($user_id) . '/video';
    }

    /**
     * Возвращает путь к директории с изображениями для видео
     *
     * @param $videoId
     * @return string
     */
    public static function getYoutubePreviewDir($videoId)
    {
        return self::getVideoDir() . '/youtube/' . $videoId;
    }

    /**
     * Возвращает URL к директории с превьюшками к видео
     *
     * @param $videoId
     * @param $user_id
     * @return string
     */
    public static function getYoutubePreviewDirUrl($videoId, $user_id)
    {
        return self::getVideoDirUrl($user_id) . '/youtube/' . $videoId;
    }

    /**
     * Возвращает URL к превьюшке по $videoId с размером $size,
     *
     * @param $videoId
     * @param $user_id
     * @param string $size
     * @return string
     */
    public static function getYoutubePreviewUrl($videoId, $user_id, $size = 'medium')
    {
        return self::getYoutubePreviewDirUrl($videoId, $user_id) . '/' . $size . '.jpg';
    }

    /**
     * Создает директорию для превьюшек к видео с ютуба
     *
     * @param $videoId
     * @return string
     */
    public static function createYoutubePreviewDir($videoId)
    {
        return FileHelper::createDirectory(self::getYoutubePreviewDir($videoId));
    }

    /**
     * Удаляет директорию для превьюшек к видео с ютуба
     *
     * @param $videoId
     * @return string
     */
    public static function removeYoutubePreviewDir($videoId)
    {
        FileHelper::removeDirectory(self::getYoutubePreviewDir($videoId));
    }
}