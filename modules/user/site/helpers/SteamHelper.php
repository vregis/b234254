<?php

namespace modules\user\site\helpers;

use modules\core\helpers\TextHelper;
use JMS\Serializer\SerializerBuilder as SteamSerializerBuilder;
use Steam\Adapter\Guzzle as SteamGuzzle;
use Steam\Api\User as SteamUser;
use Steam\Configuration as SteamConfiguration;
use Yii;
use yii\base\Exception;

// Steam API

/**
 * Вспомогательный класс для работы со Steam API
 *
 * @author MrArthur
 * @since 1.0.0
 */
class SteamHelper
{
    /**
     * Создает подключение к Steam API
     */
    public static function connectToApi()
    {
        /** @var \common\modules\user\Module $userMod */
        $userMod = Yii::$app->getModule('user');
        $config = new SteamConfiguration(['steamKey' => $userMod->steamApiKey]);
        $adapter = new SteamGuzzle($config);
        $adapter->setSerializer(SteamSerializerBuilder::create()->build());
        $steam = new SteamUser();
        $steam->setAdapter($adapter);
        return $steam;
    }

    /**
     * Получение информации об игроке из Steam API по Steam ID
     *
     * 'steamid' => '76561198117140879'
     * 'communityvisibilitystate' => 3
     * 'profilestate' => 1
     * 'personaname' => 'arthur'
     * 'lastlogoff' => 1409314341
     * 'profileurl' => 'http://steamcommunity.com/id/mrarthur/'
     * 'avatar' => 'http://media.steampowered.com/steamcommunity/public/images/avatars/c9/c9b3e5a18dae23274effaf251a8bfa51d1bd8aff.jpg'
     * 'avatarmedium' => 'http://media.steampowered.com/steamcommunity/public/images/avatars/c9/c9b3e5a18dae23274effaf251a8bfa51d1bd8aff_medium.jpg'
     * 'avatarfull' => 'http://media.steampowered.com/steamcommunity/public/images/avatars/c9/c9b3e5a18dae23274effaf251a8bfa51d1bd8aff_full.jpg'
     * 'personastate' => 0
     * 'realname' => 'Arthur'
     * 'primaryclanid' => '103582791429521408'
     * 'timecreated' => 1386260828
     * 'personastateflags' => 0
     * 'loccountrycode' => 'RU'
     *
     * @param $steam_id
     * @return mixed
     * @throws \yii\base\Exception
     */
    public static function getUserInfoById($steam_id)
    {
        $steam_id = TextHelper::filterString((string)$steam_id);

        $steam = self::connectToApi();

        $player = $steam->getPlayerSummaries(["{$steam_id}"]);

        if (empty($player['response']['players'][0]['personaname'])) {
            throw new Exception(Yii::t('user', 'Не удалось получить информацию об игроке'));
        } else {
            return $player['response']['players'][0];
        }
    }

    /**
     * Получение Steam ID
     *
     * http://steamcommunity.com/openid/id/76561198117140879
     *
     * @param $url
     * @return array|mixed|null
     */
    public static function getIdFromUrl($url)
    {
        $parseUrl = explode('/', parse_url($url, PHP_URL_PATH));
        return empty($parseUrl[3]) ? null : TextHelper::filterString($parseUrl[3]);
    }

    /**
     * Возвращает массив с Steam ID друзей текущего пользователя (Steam API)
     *
     * @param $steam_id
     * @return array
     */
    public static function getUserFriends($steam_id)
    {
        $steam_id = TextHelper::filterString((string)$steam_id);

        $steam = self::connectToApi();

        $friends = $steam->getFriendList("{$steam_id}");
        $friends = isset($friends['friendslist']['friends']) ? $friends['friendslist']['friends'] : [];

        $info = [];
        foreach ($friends as $friend) {
            $info[] = (string)$friend['steamid'];
        }

        return $info;
    }

    /**
     * Копирует аватарку из стима в директорию пользователя $user_id
     *
     * @param $user_id int ID пользователя, для которого загружается аватарка
     * @param string $avatar_url URL к изображению аватара на steam.com
     * @return bool
     */
    public static function copyAvatar($user_id, $avatar_url)
    {
        $user_id = (int)$user_id;
        $avatar_url = TextHelper::filterUrl($avatar_url);
        if (empty($avatar_url)) {
            return null;
        }
        /** @var \common\modules\user\Module $userMod */
        $userMod = Yii::$app->getModule('user');
        $path = $userMod->getAvatarPath($user_id);
        $old_md5 = file_exists($path) ? md5_file($path) : null;
        $copied = curl_init($avatar_url) && copy($avatar_url, $path) ? true : null;
        $new_md5 = file_exists($path) ? md5_file($path) : null;
        // если изображение не изменилось - возвращаем null
        return $old_md5 === $new_md5 ? false : $copied;
    }

    /**
     * Конвертирует Dota 2 ID пользователя в Steam ID
     *
     * @param $id
     * @return null|string
     */
    public static function convertId($id)
    {
        if (empty($id)) {
            return null;
        }

        if (strlen($id) === 17) {
            $id = substr($id, 3) - 61197960265728;
        } else {
            $id = '765' . ($id + 61197960265728);
        }
        return (string)$id;
    }
}