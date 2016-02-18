<?php

namespace modules\core\site\components;

use Yii;

/**
 * Класс LangHelper
 *
 * Вспомогательные методы для мультиязычности
 *
 * @author MrArthur
 * @since 1.0.0
 */
class LangHelper
{
    /**
     * @var string/null Переменная для хранения текущего объекта языка
     */
    public static $current = null;

    /**
     * Получение дополнительных параметров языков
     *
     * @return array Массив доступных языков (Локаль => Код для URL)
     */
    public static function getAvailable()
    {
        return [
            'ru' => [
                'code' => 'ru',
                'title' => Yii::t('core', 'Русский')
            ],
            'en' => [
                'code' => 'en',
                'title' => Yii::t('core', 'English')
            ],
        ];
    }

    /**
     * Получение языка по умолчанию
     *
     * @return mixed
     */
    public static function getDefault()
    {
        return self::getAvailable()['ru'];
    }

    /**
     * Получение текущего языка
     *
     * @return string
     */
    public static function getCurrent()
    {
        if (self::$current === null) {
            self::$current = self::getDefault();
        }
        return self::$current;
    }

    /**
     * Установка текущего языка и локали пользователя
     *
     * @param null $url
     */
    public static function setCurrent($url = null)
    {
        $language = self::getByUrl($url);
        self::$current = ($language === null) ? self::getDefault() : $language;
        Yii::$app->language = self::$current['code'];
    }

    /**
     * Удаляет код языка из URL
     *
     * @param null $code
     * @return null
     */
    public static function getByUrl($code = null)
    {
        if ($code === null) {
            return null;
        } else {
            $available = self::getAvailable();
            return isset($available[$code]) ? $available[$code] : null;
        }
    }
}