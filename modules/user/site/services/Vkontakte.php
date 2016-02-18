<?php

namespace modules\user\site\services;

use nodge\eauth\services\VKontakteOAuth2Service;

/**
 * Class VKontakte
 *
 * @author MrArthur
 * @since 1.0.0
 */
class VKontakte extends VKontakteOAuth2Service
{
    /** @inheritdoc */
    protected function fetchAttributes()
    {
        $tokenData = $this->getAccessTokenData();
        $info = $this->makeSignedRequest(
            'users.get.json',
            [
                'query' => [
                    'uids' => $tokenData['params']['user_id'],
                    // uid, first_name and last_name is always available
                    'fields' => '
                        full_name,
                        sex,
                        bdate,
                        birthdate,
                        city,
                        country,
                        timezone,
                        photo,
                        photo_medium,
                        photo_big,
                        photo_rec,
                        connections'
                ],
            ]
        );

        /** @see https://vk.com/pages?oid=-1&p=users.get */
        $this->attributes = $info['response'][0];
        $this->attributes = ['id' => $this->attributes['uid']] + $this->attributes;
        unset($this->attributes['uid']);

        // если есть ID страны и ID города, получаем их названия
        $countryId = empty($this->attributes['country']) ? null : $this->attributes['country'];
        $cityId = empty($this->attributes['city']) ? null : $this->attributes['city'];
        if (!empty($countryId) && !empty($cityId)) {
            // страна
            $geoCountry = $this->makeSignedRequest(
                'places.getCountryById',
                [
                    'query' => [
                        'cids' => $countryId
                    ],
                ]
            );
            if (!empty($geoCountry['response'][0]['name'])) {
                $this->attributes['country_title'] = $geoCountry['response'][0]['name'];
            }

            // город
            $geoCity = $this->makeSignedRequest(
                'places.getCityById',
                [
                    'query' => [
                        'cids' => $cityId
                    ],
                ]
            );
            if (!empty($geoCity['response'][0]['name'])) {
                $this->attributes['city_title'] = $geoCity['response'][0]['name'];
            }

            // если чего-то нет, удаляем и страну и город
            if (empty($this->attributes['country_title']) || empty($this->attributes['city_title'])) {
                unset($this->attributes['country_title']);
                unset($this->attributes['city_title']);
            }
        }

        return true;
    }
}