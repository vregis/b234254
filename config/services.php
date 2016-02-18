<?php

/**
 * Настройки для авторизации через соц. сети для nodge\eauth
 */

return [
    // Steam
    /*'st' => [
        'title' => Yii::t('user', 'Steam'),
        'class' => 'frontend\modules\user\services\Steam',
        //'realm' => '*.example.org', // your domain, can be with wildcard to authenticate on subdomains.
    ],*/
    // Facebook
    'fb' => [
        // register your app here: https://developers.facebook.com/apps/
        'title' => Yii::t('user', 'Facebook'),
        'class' => 'modules\user\site\services\Facebook',
        'clientId' => '1612139002340068',
        'clientSecret' => 'f6576aa6b53dfb7adbe868aa366de2da',
        /*'clientId' => '1038203012891359',
        'clientSecret' => 'b9cd613083981fbc0e826a3f18ec9a6c',*/
    ],
    // Вконтакте
    /*'vkontakte' => [
// register your app here: https://vk.com/editapp?act=create&site=1
        'class' => 'nodge\eauth\services\VKontakteOAuth2Service',
        'clientId' => '5114773',
        'clientSecret' => 'NhUC0FfsvIK8M9T3wMYw',


    ],*/
    // Twitter
    'tw' => [
        // register your app here: https://dev.twitter.com/apps/new
        'title' => Yii::t('user', 'Twitter'),
        'class' => 'modules\user\site\services\Twitter',
        'key' => 'x3JOQktxKRY4alFVnlUrvf560',
        'secret' => 'yvn3tyoj9a0FkaTmzYUMK3JHyr2TywClFTLVWtj27VlEegcykd',
        /*'key' => 'mr2KqL6jBd7EFE3rcYJjpd7RD',
        'secret' => 'GFX5z4puq0nDhyg7dvu1Uprx7zhc0UqgIbmCSPABsKhEiWxcX4',*/
    ],
    // Google
    /*'gg' => [
        // register your app here: https://code.google.com/apis/console/
        'title' => Yii::t('user', 'Google'),
        'class' => 'frontend\modules\user\services\Google',
        'clientId' => '737844591376-vi6ffd2aa9397gg7p206mcveumgkr64t.apps.googleusercontent.com',
        'clientSecret' => 'UcDGc4cxn1sa_dYUFR39adIk',
    ],*/
    // Яндекс
    /*'ya' => [
        // register your app here: https://oauth.yandex.ru/client/my
        'title' => Yii::t('user', 'Яндекс'),
        'class' => 'frontend\modules\user\services\Yandex',
        'clientId' => 'caeffdf6ccc24436ad7cffb0791776d7',
        'clientSecret' => '1a7073dbfc384289959a531399b30798',
    ],*/

    // Одноклассники
    /*'ok' => [
        // register your app here: http://dev.odnoklassniki.ru/wiki/pages/viewpage.action?pageId=13992188
        // ... or here: http://www.odnoklassniki.ru/dk?st.cmd=appsInfoMyDevList&st._aid=Apps_Info_MyDev
        'title' => Yii::t('user', 'Одноклассники'),
        'class' => 'frontend\modules\user\services\Odnoklassniki',
        'clientId' => '1092342528',
        'clientSecret' => 'D43451FE9EA33AE35520C5B1',
        'clientPublic' => 'CBAENMBCEBABABABA',
    ],*/
    // Mail.ru
    /*'mr' => [
        // register your app here: http://api.mail.ru/sites/my/add
        'title' => Yii::t('user', 'Mail.ru'),
        'class' => 'frontend\modules\user\services\Mailru',
        'clientId' => '721706',
        'clientSecret' => '57073ee6409fdbab15cbbcbc8bbeebb2',
    ],*/
];