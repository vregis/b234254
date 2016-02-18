<?php

/**
 * Основной конфиг фронтенда.
 */


$config = [
    'id' => 'app-site',
    'name' => 'BSB',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'modules\site\controllers',
    'defaultRoute' => 'core/default/index',
    'modules' => require(__DIR__ . '/modules.php'),
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'd MMMM yyyy',

        ],
        'user' => [
            'class' => 'yii\web\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/user/login'],
            'identityClass' => 'modules\user\models\User'
        ],
        // переопределяем request класс для мультиязычности
        'request' => [
            //'class' => 'frontend\modules\core\components\LangRequest',
            'class' => 'yii\web\Request',
            'enableCsrfValidation' => true,
            'enableCookieValidation' => true,
            'cookieValidationKey' => 'mrarthurSecretKeyFrontend',
            'baseUrl'=> ''
        ],
        // urlManager
        'urlManager' => [
            //'class' => 'frontend\modules\core\components\LangUrlManager', // мультиязычность
            'class' => 'yii\web\UrlManager',
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
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'core/default/error',
        ],
        /**
         * Интернационализация (i18n)
         *
         * Настройки i18n для модулей.
         * Настройки перевода для прочих модулей настраиваем в modules/{MODULE_NAME}/Module.php в методе init()
         */
        // отключаем jQuery из Yii
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [ /*'//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'*/]
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@root/yii2/cache',
            'keyPrefix' => 'yii'
        ],
        /**
         * Логи
         */
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => '@root/yii2/logs/site/error.log',
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => '@root/yii2/logs/site/error404.log',
                    'categories' => [
                        'yii\web\HttpException:404',
                    ],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => '@root/yii2/logs/site/warning.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@root/yii2/logs/site/eauth.log',
                    'categories' => ['nodge\eauth\*'],
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => ['payment'],
                    'logFile' => '@root/yii2/logs/site/payment.log',
                    'logVars' => [],
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
              
            ],
        ],
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;