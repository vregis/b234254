<?php

use yii\helpers\BaseVarDumper;

Yii::setAlias('root', dirname(__DIR__));
Yii::setAlias('modules', dirname(__DIR__) . '/modules');
Yii::setAlias('cache', dirname(__DIR__) . '/cache');
Yii::setAlias('static', dirname(__DIR__) . '/static/web');
//$test = Yii::getAlias('@static');

/**
 * Обертка для VarDumper'а Yii
 *
 * @param $var
 * @param bool $exit
 */
function vd($var, $exit = true)
{
    BaseVarDumper::dump($var, 10, true);
    if ($exit) {
        exit;
    }
}