<?php

/**
 * Общие параметры для фронтенда и бэкенда
 */

return [
    'vendorPath' => dirname(__DIR__) . '/vendor',
    'sourceLanguage' => 'en',
    'language' => 'en',
    'charset' => 'utf-8',
    'timeZone' => 'Europe/Moscow',
    'bootstrap' => ['log'],
    'modules' => [],
    'runtimePath'=>dirname(__DIR__) . '/yii2/runtime',
    'components' => [

       /* 'paypal'=> [
            'class'        => 'marciocamello\Paypal',
            'clientId'     => 'AeAQSEzvflz8ymiU9QC1awrfpQXszDXwrVIgRPk7E7-RDaL-O0dLhSrAnwLJ5XmnF6bJRNs2I034XcHF',
            'clientSecret' => 'EPgWBd3sfwZCgxgeCKWInrXn_09uomJdjCvkclD-TTnTl-HzqxB4u1hhkQbEI9luAFEBcRJgnbhirn4c',
            'isProduction' => false,
            // This is config file for the PayPal system
            'config'       => [
                'http.ConnectionTimeOut' => 30,
                'http.Retry'             => 1,
                'mode'                   => ak\Paypal::MODE_SANDBOX, // development (sandbox) or production (live) mode
                'log.LogEnabled'         => YII_DEBUG ? 1 : 0,
                'log.FileName'           => '@runtime/logs/paypal.log',
                'log.LogLevel'           => ak\Paypal::LOG_LEVEL_FINE,
            ]
        ],*/

        'view' => [
            'class' => 'modules\core\base\View',
        ],
		// i18n
		'i18n' => [
			'translations' => [
				'*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@root/messages',
					'sourceLanguage' => 'ru',
				],
			],
		],
        // RBAC
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => [
                'user',
                'moder',
                'tester',
                'admin'
            ],
            'itemFile' => '@modules/user/rbac/items.php',
            'assignmentFile' => '@modules/user/rbac/assignments.php',
            'ruleFile' => '@modules/user/rbac/rules.php'
        ],
        'assetManager' => [
            'class'=>'yii\web\AssetManager',
            'linkAssets'=>true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js'=>[]
                ],
            ],
        ],
        /**
         * Mailer
         *
         * Отправляем почту через smtp.gmail.com
         */
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@modules/user/site/views/emails',
            'useFileTransport' => false,
            'messageConfig' => [
                'charset' => 'UTF-8',
            ],
            'transport' => require(__DIR__ . '/transport.php'),
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'mrarthurBackendSecretKey',
        ],
        // Основная БД
        'db' => require(__DIR__ . '/db.php'),
        'eauth' => [
            'class' => 'nodge\eauth\EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'httpClient' => array(
                // uncomment this to use streams in safe_mode
                //'useStreamsFallback' => true,
            ),
            'services' => require(__DIR__ . '/services.php'),
        ],
    ],
    'params' => require(__DIR__ . '/params.php'),
    /**
     * Событие beforeRequest
     *
     * Получаем параметры маршрутизации из всех подключенных модулей и добавляем их в массив Yii::$app->getUrlManager()->rules[]
     * Правила модуля добавляются перед правилами из config/main.php, и, следовательно, имеют приортитет перед дефолтными роутами.
     */
    'on beforeRequest' => function () {
        $mods = array_keys(Yii::$app->getModules());
        $urlManager = Yii::$app->getUrlManager();
        foreach ($mods as $mod_name) {
            // основной модуль
            $mod = Yii::$app->getModule($mod_name);
            if (isset($mod->urlRules)) {
                array_unshift($urlManager->rules, $mod->urlRules);
            }

            // подмодули
            if (!empty($mod->modules)) {
                foreach ($mod->modules as $sub_mod_name => $v) {
                    $sub_mod = Yii::$app->getModule($mod_name . '/' . $sub_mod_name);
                    if (isset($sub_mod->urlRules)) {
                        array_unshift($urlManager->rules, $sub_mod->urlRules);
                    }
                }
            }
        }
        //vd($urlManager->rules);
        return true;
    }
];