<?php

/**
 * Основной конфиг бэкенда
 */

return [
    'id' => 'app-backend',
    'name' => Yii::t('core', 'Панель управления'),
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'admin/controllers',
    'defaultRoute' => 'core/default/index',
    'modules' => require(__DIR__ . '/modules.php'),
    'components' => [
        'request' => [
			'baseUrl' => '/admin',
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
            'cookieValidationKey' => 'mrarthurSecretKeyBackend',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/security/login'],
            'identityClass' => 'modules\user\models\User'
        ],
        'assetManager' => [
            'baseUrl' => '/assets',
        ],
        /**
         * Маршрутизация
         *
         * Настройка основных правил маршрутизации.
         * Правила можно указать непосредственно в модуле:
         * modules/{MODULE_NAME}/Module.php метод init()
         */
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            // 'suffix' => '/',
            'rules' => [
                // Модуль [[core]] - главная страница
                '' => 'core/default/index',
                // Общие правила для бэкенда
                '<_m:[\w\-]+>' => '<_m>/default/index',
                // /module/default/action -> /module/action
                '<_m:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/default/<_a>',
                //'<_m:[\w\-]+>/<_sm:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_sm>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'core/default/error',
        ],
        /** Логи */
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => dirname(dirname(__DIR__)) . '/yii2/logs/admin/error.log',
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => dirname(dirname(__DIR__)) . '/yii2/logs/admin/error404.log',
                    'categories' => [
                        'yii\web\HttpException:404',
                    ],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => dirname(dirname(__DIR__)) . '/yii2/logs/admin/warning.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'logFile' => dirname(dirname(__DIR__)) . '/yii2/logs/admin/reverse.log',
                    'categories' => [
                        'reverse',
                    ],
                    'logVars' => [],
                ],
            ],
        ],
    ],
];



