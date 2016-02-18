<?php

namespace modules\core\base;

use modules\core\helpers\DateHelper;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View as YiiView;

/**
 * Базовый класс View для всех вьюшек бэкенда и фронтенда
 *
 * @property string $aliasPlaceholder
 * @property Controller $context
 *
 * @property bool $isGuest
 * @property bool $isAjax
 *
 * @author MrArthur
 * @since 1.0.0
 */
class View extends YiiView
{
    /**
     * Сокращение для Yii::$app->user->isGuest
     *
     * @return bool
     */
    public function getIsGuest()
    {
        return Yii::$app->user->isGuest;
    }

    /**
     * @inheritdoc
     */
    public function formatDate($timestamp, $format = null)
    {
        return DateHelper::formatDate($timestamp, $format);
    }

    /**
     * Обертка для Url::to()
     *
     * @inheritdoc
     */
    public function url($url, $scheme = false)
    {
        return Url::to($url, $scheme);
    }

    /**
     * Обертка для Html::encode()
     *
     * @inheritdoc
     */
    public function encode($content, $doubleEncode = true)
    {
        return Html::encode($content, $doubleEncode);
    }

    public function registerCssFile($url, $options = [], $key = null)
    {
        $url.='?v='.Yii::$app->params['version'];
        return parent::registerCssFile($url,$options,$key);
    }
}