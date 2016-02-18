<?php

namespace modules\user\site\services;

use nodge\eauth\services\OdnoklassnikiOAuth2Service;

/**
 * Class Odnoklassniki
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Odnoklassniki extends OdnoklassnikiOAuth2Service
{
    /** @inheritdoc */
    protected function fetchAttributes()
    {
        $this->attributes = $this->makeSignedRequest(
            '',
            [
                'query' => [
                    'method' => 'users.getCurrentUser',
                    'format' => 'JSON',
                    'application_key' => $this->clientPublic,
                    'client_id' => $this->clientId,
                ],
            ]
        );
        /** @see http://apiok.ru/wiki/display/api/users.getInfo */
        $this->attributes = ['id' => $this->attributes['uid']] + $this->attributes;
        unset($this->attributes['uid']);
        return true;
    }
}