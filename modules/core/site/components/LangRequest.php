<?php

namespace modules\core\site\components;

use Yii;
use yii\web\Request;

/**
 * Класс LangRequest
 *
 * Расширенный yii\web\Request для мультиязычности
 *
 * @author MrArthur
 * @since 1.0.0
 */
class LangRequest extends Request
{
    /** @inheritdoc */
    protected function resolveRequestUri()
    {
        $requestUri = parent::resolveRequestUri();
        $lang_prefix = null;
        $requestUriToList = explode('/', $requestUri);

        // получаем язык из URL
        $lang_url = (isset($requestUriToList[1]) && isset(LangHelper::getAvailable()[$requestUriToList[1]]))
            ? $requestUriToList[1] : null;

        // устанавливаем язык
        LangHelper::setCurrent($lang_url);

        // если язык - дефолтный - удаляем его из URL и редиректим на адрес без языкового параметра
        if ($lang_url == 'ru') {
            $cleanUrl = substr($requestUri, strlen($lang_url) + 1);
            $redirectUrl = $cleanUrl ? $cleanUrl : '/';
            Yii::$app->response->redirect($redirectUrl);
        }

        // удаляем язык из URL
        if ($lang_url !== null && $requestUri !== '/' && strpos($requestUri, $lang_url) === 1) {
            $requestUri = substr($requestUri, strlen($lang_url) + 1);
        }

        return $requestUri;
    }
}