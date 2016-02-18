<?php

namespace modules\user\site\services;

use nodge\eauth\services\MailruOAuth2Service;

/**
 * Class Mailru
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Mailru extends MailruOAuth2Service
{
    /** @inheritdoc */
    protected function fetchAttributes()
    {
        $tokenData = $this->getAccessTokenData();
        $info = $this->makeSignedRequest(
            '/',
            [
                'query' => [
                    'uids' => $tokenData['params']['x_mailru_vid'],
                    'method' => 'users.getInfo',
                    'app_id' => $this->clientId,
                ],
            ]
        );
        /** @see http://api.mail.ru/docs/reference/rest/users-getinfo/ */
        $this->attributes = $info[0];
        $this->attributes = ['id' => $this->attributes['uid']] + $this->attributes;
        unset($this->attributes['uid']);
        return true;
    }
}
