<?php

/**
 * Модули фронтенда
 *
 * @author MrArthur
 * @since 1.0.0
 */

return [
    // core
    'core' => [
        'class' => 'modules\core\Module',
        'basePath' => Yii::getAlias('@root').'/modules/core/site',
        'controllerNamespace' => 'modules\core\site\controllers',
    ],
    // user
    'user' => [
        'class' => 'modules\user\Module',
        'basePath' => Yii::getAlias('@root').'/modules/user/site',
        'controllerNamespace' => 'modules\user\site\controllers',
        'onlySteam' => false, // Активирует разные типы входа на сайт
        'steamApiKey' => '5095E47275F3FA8EC1362ED07EAEEA7E',
        'enableRegistration' => true,
        'enablePasswordRecovery' => true,
        'enableConfirmation' => true,// Активирует email письмо подтверждения  и делает поле confirmed_at  пустым
        /*'modules' => [
            // user-media
            'media' => [
                'class' => 'frontend\modules\user\modules\media\Module'
            ],
        ]*/
    ],
    // chat
    'chat' => [
        'class' => 'modules\chat\Module',
        'basePath' => Yii::getAlias('@modules').'/chat/site',
        'controllerNamespace' => 'modules\chat\site\controllers',
    ],
    // mail
    'mail' => [
        'class' => 'modules\mail\Module'
    ],
    // departments
    'departments' => [
        'class' => 'modules\departments\Module',
        'basePath' => Yii::getAlias('@modules').'/departments/site',
        'controllerNamespace' => 'modules\departments\site\controllers',
    ],
    // tests
    'tests' => [
        'class' => 'modules\tests\Module',
        'basePath' => Yii::getAlias('@modules').'/tests/site',
        'controllerNamespace' => 'modules\tests\site\controllers',
    ],
    // tasks
    'tasks' => [
        'class' => 'modules\tasks\Module',
        'basePath' => Yii::getAlias('@modules').'/tasks/site',
        'controllerNamespace' => 'modules\tasks\site\controllers',
    ],
    'social' => [
        // the module class
        'class' => 'kartik\social\Module',

        // the global settings for the disqus widget
        'disqus' => [
            'settings' => ['shortname' => 'DISQUS_SHORTNAME'] // default settings
        ],

        // the global settings for the facebook plugins widget
        'facebook' => [
            'appId' => 'FACEBOOK_APP_ID',
            'secret' => 'FACEBOOK_APP_SECRET',
        ],

        // the global settings for the google plugins widget
        'google' => [
            'clientId' => 'GOOGLE_API_CLIENT_ID',
            'pageId' => 'GOOGLE_PLUS_PAGE_ID',
            'profileId' => 'GOOGLE_PLUS_PROFILE_ID',
        ],

        // the global settings for the google analytic plugin widget
        'googleAnalytics' => [
            'id' => 'TRACKING_ID',
            'domain' => 'TRACKING_DOMAIN',
        ],

        // the global settings for the twitter plugins widget
        'twitter' => [
            'screenName' => 'TWITTER_SCREEN_NAME'
        ],
    ],
];