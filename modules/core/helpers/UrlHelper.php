<?php

namespace modules\core\helpers;

/**
 * Хелпер для обработки URL
 *
 * @property string $urlPattern
 *
 * @author MrArthur
 * @since 1.0.0
 */
class UrlHelper
{
    /**
     * Проверяет URL на существование
     *
     * @param $url
     * @return bool
     */
    public static function exists($url)
    {
        if (substr_count($url, 'http') > 1 || substr_count($url, 'https') > 1) {
            return false;
        }
        return curl_init($url) ? true : false;
    }

    /**
     * Шаблон регулярного выражения для URL
     *
     * @return string
     */
    public static function getUrlPattern()
    {
        return "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
    }

    /**
     * Делает ссылки в тексте кликабельными
     *
     * @param $text
     * @return mixed
     */
    public static function clickable($text)
    {
        return preg_replace(
            '!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-ЯёЁ()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>',
            $text
        );
    }
}