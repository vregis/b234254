<?php

namespace modules\user\site\helpers;

use modules\core\helpers\TextHelper;
use modules\core\helpers\UrlHelper;
use modules\user\models\User;
use Yii;
use yii\helpers\Json;

/**
 * Вспомогательный класс для работы с социальными сетями
 *
 * Доступные поля профиля:
 * first_name
 * last_name
 * gender
 *
 * @author MrArthur
 * @since 1.0.0
 */
class SocialHelper
{
    /**
     * Приводит данные, полученные из разных соц. сетей к единому виду, для использования в профиле пользователя
     *
     * @param $provider
     * @param $data
     * @return mixed
     * @throws \yii\base\InvalidParamException
     */
    public static function normalizeProfileData($provider, $data)
    {
        $data = Json::decode($data);

        $method = 'getProfileData' . ucfirst($provider);
        // если добавили новые соц. сети, а про хелпер забыли
        if (!method_exists(__CLASS__, $method)) {
            return false;
        }

        $profileData = self::$method($data);

        $userModel = new User();
        $userModel->scenario = 'fillSocial';

        // username
        if (!empty($profileData['username'])) {
            $profileData['username'] = TextHelper::filterString($profileData['username']);
            $userModel->username = $profileData['username'];
            $profileData['username'] = $userModel->validate(['username']) ? $profileData['username'] : null;
        }

        // email
        if (!empty($profileData['email'])) {
            $profileData['email'] = TextHelper::filterString($profileData['email']);
            $userModel->email = $profileData['email'];
            $profileData['email'] = $userModel->validate(['email']) ? $profileData['email'] : null;
        }

        // удаляем пустые
        foreach ($profileData as $k => $v) {
            if (empty($v)) {
                unset($profileData[$k]);
            }
        }

        return $profileData;
    }

    /**
     * Проверяет на существование элемент массива и чистит с помощью TextHelper::filterString()
     *
     * @param $array
     * @param $key
     * @return null
     */
    public static function checkEmpty($array, $key)
    {
        $value = empty($array[$key]) ? null : $array[$key];
        return TextHelper::filterString(trim($value));
    }

    /**
     * Facebook
     *
     * @param $data
     * @return array
     */
    public static function getProfileDataFb($data)
    {
        $profileData = [];
        // name
        $profileData['name'] = self::checkEmpty($data, 'name');
        // first_name
        $profileData['first_name'] = self::checkEmpty($data, 'first_name');
        // last_name
        $profileData['last_name'] = self::checkEmpty($data, 'last_name');
        // gender
        $profileData['gender'] = self::checkEmpty($data, 'gender');
        if ($profileData['gender'] == 'female') {
            $profileData['gender'] = 1;
        } elseif ($profileData['gender'] == 'male') {
            $profileData['gender'] = 2;
        } else {
            $profileData['gender'] = 0;
        }
        // email
        $profileData['service'] = 'Fb';
        $profileData['email'] = self::checkEmpty($data, 'email');

        return $profileData;
    }

    /**
     * Google
     *
     * @param $data
     * @return array
     */
    public static function getProfileDataGg($data)
    {
        $profileData = [];

        // first_name
        $profileData['first_name'] = self::checkEmpty($data, 'given_name');
        // last_name
        $profileData['last_name'] = self::checkEmpty($data, 'family_name');
        // gender
        $profileData['gender'] = self::checkEmpty($data, 'gender');
        if ($profileData['gender'] == 'female') {
            $profileData['gender'] = 1;
        } elseif ($profileData['gender'] == 'male') {
            $profileData['gender'] = 2;
        } else {
            $profileData['gender'] = 0;
        }
        // email
        $profileData['email'] = self::checkEmpty($data, 'email');

        return $profileData;
    }

    /**
     * Mail.ru
     *
     * @param $data
     * @return array
     */
    public static function getProfileDataMr($data)
    {
        $profileData = [];

        // first_name
        $profileData['first_name'] = self::checkEmpty($data, 'first_name');
        // last_name
        $profileData['last_name'] = self::checkEmpty($data, 'last_name');
        // gender
        $profileData['gender'] = self::checkEmpty($data, 'sex'); // 0 - мужчина, 1 - женщина
        if ($profileData['gender'] === 1) {
            $profileData['gender'] = 1;
        } elseif ($profileData['gender'] === 0) {
            $profileData['gender'] = 2;
        } else {
            $profileData['gender'] = 0;
        }
        // email
        $profileData['email'] = self::checkEmpty($data, 'email');

        return $profileData;
    }

    /**
     * Odnoklassniki
     *
     * @param $data
     * @return array
     */
    public static function getProfileDataOk($data)
    {
        $profileData = [];

        // first_name
        $profileData['first_name'] = self::checkEmpty($data, 'first_name');
        // last_name
        $profileData['last_name'] = self::checkEmpty($data, 'last_name');
        // gender
        $profileData['gender'] = self::checkEmpty($data, 'gender');
        if ($profileData['gender'] == 'female') {
            $profileData['gender'] = 1;
        } elseif ($profileData['gender'] == 'male') {
            $profileData['gender'] = 2;
        } else {
            $profileData['gender'] = 0;
        }

        return $profileData;
    }

    /**
     * Vkontakte
     *
     * @param $data
     * @return array
     */
    public static function getProfileDataVk($data)
    {
        $profileData = [];

        // first_name
        $profileData['first_name'] = self::checkEmpty($data, 'first_name');
        // last_name
        $profileData['last_name'] = self::checkEmpty($data, 'last_name');
        // gender
        $profileData['gender'] = (int)self::checkEmpty($data, 'sex');

        return $profileData;
    }
    /**
     * Twitter
     *
     * @param $data
     * @return array
     */
    public static function getProfileDataTw($data)
    {
        $profileData = [];
        $profileData['service'] = 'Tw';
        $profileData['name'] = self::checkEmpty($data, 'name');
        return $profileData;
    }
    /**
     * Yandex
     *
     * @param $data
     * @return array
     */
    public static function getProfileDataYa($data)
    {
        $profileData = [];

        // first_name
        $profileData['first_name'] = self::checkEmpty($data, 'first_name');
        // last_name
        $profileData['last_name'] = self::checkEmpty($data, 'last_name');
        // gender
        $profileData['gender'] = self::checkEmpty($data, 'sex');
        if ($profileData['gender'] == 'female') {
            $profileData['gender'] = 1;
        } elseif ($profileData['gender'] == 'male') {
            $profileData['gender'] = 2;
        } else {
            $profileData['gender'] = 0;
        }
        // email
        if (!empty($info['emails'][0])) {
            $profileData['email'] = self::checkEmpty($info['emails'][0], 'email');
        }

        return $profileData;
    }

    /**
     * Проверяет, является ли $url ссылкой на соц. сеть $provider
     *
     * @param $url
     * @param $provider
     * @return bool
     */
    public static function checkUrl($url, $provider)
    {
        if (empty($url) || empty($provider) || !preg_match(UrlHelper::getUrlPattern(), $url)) {
            return false;
        }

        $parse = parse_url($url);
        $invalidScheme = ($parse['scheme'] !== 'http' && $parse['scheme'] !== 'https') ? true : false;
        if ($invalidScheme || empty($parse['host'])) {
            return false;
        }
        switch ($provider) {
            case 'vk':
                return (bool)(strpos($parse['host'], 'vk.com') !== false);
            case 'fb':
                return (bool)(strpos($parse['host'], 'facebook.com') !== false);
            case 'tw':
                return (bool)(strpos($parse['host'], 'twitter.com') !== false);
            case 'in':
                return (bool)(strpos($parse['host'], 'instagram.com') !== false);
            case 'gg':
                return (bool)(strpos($parse['host'], 'google.com') !== false);
            case 'yt':
                return (bool)(strpos($parse['host'], 'youtube.com') !== false);
        }
        return false;
    }
}