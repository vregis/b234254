<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../config/bootstrap.php');
require(__DIR__ . '/../config/site/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/site/main.php')
);

define('BPATH', __DIR__);

$config['params'] += $config;
$application = new yii\web\Application($config);
$application->run();
if(YII_DEBUG) {
    if(!Yii::$app->request->isAjax) {
        require(__DIR__ . '/version.php');
    }
}