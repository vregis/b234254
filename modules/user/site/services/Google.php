<?php

namespace modules\user\site\services;

use nodge\eauth\services\GoogleOAuth2Service;

/**
 * Class Google
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Google extends GoogleOAuth2Service
{
    /** @inheritdoc */
    protected function fetchAttributes()
    {
        /** @see https://developers.google.com/+/api/latest/people */
        $this->attributes = $this->makeSignedRequest('https://www.googleapis.com/oauth2/v1/userinfo');
        return true;
    }
}