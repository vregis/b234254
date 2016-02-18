<?php

namespace modules\core\site\components;

use Yii;
use yii\web\UrlManager;

/**
 * Класс LangUrlManager
 *
 * Расширенный UrlManager для мультиязычности
 *
 * @author MrArthur
 * @since 1.0.0
 */
class LangUrlManager extends UrlManager
{
    /** @inheritdoc */
    public function createUrl($params)
    {
        // vd($params);
        if (isset($params['language'])) {
            // Если указан параметр языка, проверяем есть ли он в массиве доступных языков
            $available = LangHelper::getAvailable();
            $lang = isset($available[$params['language']]) ? $available[$params['language']] : LangHelper::getDefault();
            unset($params['language']);
        } else {
            // Если не указан, то работаем с текущим языком
            $lang = LangHelper::getCurrent();
        }

        // получаем сформированный URL (без префикса идентификатора языка)
        $url = parent::createUrl($params);

        // если это дефолтный язык, не добавляем код языка в URL
        if ($lang['code'] == LangHelper::getDefault()['code']) {
            return $url;
        }

        // добавляем к URL префикс - буквенный идентификатор языка
        return ($url == '/') ? '/' . $lang['code'] : '/' . $lang['code'] . $url;
    }
}