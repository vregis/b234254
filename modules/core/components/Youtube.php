<?php

namespace modules\core\components;

use Exception;
use Madcoda\Youtube as MadcodaYoutube;
use Yii;

/**
 * Перекрываем Madcoda\Youtube для фикса проблемы с SSL
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Youtube extends MadcodaYoutube
{
    /**
     * Отключаем проверку SSL
     *
     * @inheritdoc
     */
    public function api_get($url, $params)
    {
        //set the youtube key
        $params['key'] = $this->youtube_key;

        //boilerplates for CURL
        $tuCurl = curl_init();
        curl_setopt($tuCurl, CURLOPT_URL, $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($params));
        if (strpos($url, 'https') === false) {
            curl_setopt($tuCurl, CURLOPT_PORT, 80);
        } else {
            curl_setopt($tuCurl, CURLOPT_PORT, 443);
        }
        curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
        // отключаем проверку SSL
        curl_setopt($tuCurl, CURLOPT_SSL_VERIFYPEER, false);
        /////////////////////////
        $tuData = curl_exec($tuCurl);
        if (curl_errno($tuCurl)) {
            throw new \Exception('Curl Error : ' . curl_error($tuCurl));
        }
        return $tuData;
    }

    /** @inheritdoc */
    public static function parseVIdFromURL($youtube_url)
    {
        if (strpos($youtube_url, 'youtube.com')) {
            $params = static::_parse_url_query($youtube_url);
            return $params['v'];
        } else {
            if (strpos($youtube_url, 'youtu.be')) {
                $path = static::_parse_url_path($youtube_url);
                $vid = substr($path, 1);
                return $vid;
            } else {
                return false;
            }
        }
    }

    /** @inheritdoc */
    public static function _parse_url_query($url)
    {
        $array = parse_url($url);
        $query = $array['query'];

        $queryParts = explode('&', $query);

        $params = [];

        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = empty($item[1]) ? '' : $item[1];
        }
        return $params;
    }
}