<?php

namespace modules\user\site\services;

use nodge\eauth\services\FacebookOAuth2Service;

/**
 * Class Facebook
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Facebook extends FacebookOAuth2Service
{
	public $fields;
	/** @inheritdoc */
    protected function fetchAttributes()
    {
        /** @see https://developers.facebook.com/docs/graph-api/reference/v2.1/user */
        $this->attributes = $this->makeSignedRequest('me?fields=id,name,email,first_name,last_name,gender');
        return true;
    }
}