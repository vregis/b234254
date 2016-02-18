<?php

namespace modules\user\site\services;

use nodge\eauth\services\TwitterOAuth1Service;

/**
 * Class Twitter
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Twitter extends TwitterOAuth1Service
{

    protected $providerOptions = array(
        'request' => 'https://api.twitter.com/oauth/request_token',
        'authorize' => 'https://api.twitter.com/oauth/authenticate?force_login=true', //https://api.twitter.com/oauth/authorize
        'access' => 'https://api.twitter.com/oauth/access_token',
    );
    /** @inheritdoc */
    protected function fetchAttributes()
    {
        /** @see  */
        $this->attributes = $this->makeSignedRequest('account/verify_credentials.json');
        return true;
    }
}