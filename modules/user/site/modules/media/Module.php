<?php

namespace modules\user\site\modules\media;

use modules\user\modules\media\Module as CommonUserMediaModule;
use Yii;
use yii\web\GroupUrlRule;

/**
 * Модуль [[user/media]] - frontend
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Module extends CommonUserMediaModule
{
    /** @inheritdoc */
    public function init()
    {
        parent::init();

        $this->defaultAlbumTitle = Yii::t('user-media', 'Без названия');

        // включаем и настраиваем рейтинг
        $this->rating = [
            // фото
            'photo' => [
                'logTable' => 'user_media_photo',
                'jsCounters' => true,
                'allowRevote' => true,
            ],
            // видео
            'video' => [
                'logTable' => 'user_media_video',
                'jsCounters' => true,
                'allowRevote' => true,
            ]
        ];
    }

    /** @inheritdoc */
    public function getUrlRules()
    {
        return new GroupUrlRule([
            'prefix' => 'user/media',
            'rules' => [
                '' => 'default/index',
                'album' => 'album/index',
                '<_a:[\w\-]+>' => 'default/<_a>',
                '<_c:[\w-]+>/<_a:[\w\-]+>/<id:\d+>/<page:\d+>' => '<_c>/<_a>',
                '<_c:[\w-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
                '<_c:[\w-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
            ]
        ]);
    }
}