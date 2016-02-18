<?php

namespace modules\user\site\services;

use nodge\eauth\services\YandexOAuth2Service;

/**
 * Class Yandex
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Yandex extends YandexOAuth2Service
{
    /** @inheritdoc */
    protected function fetchAttributes()
    {
        /** @see http://api.yandex.ru/login/doc/dg/reference/response.xml */
        $this->attributes = $this->makeSignedRequest('https://login.yandex.ru/info');
        return true;
    }
}