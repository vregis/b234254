<?php

namespace modules\core\helpers;

use modules\core\behaviors\PurifierBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;

/**
 * Хелпер для обработки текста
 *
 * @property string $urlPattern
 *
 * @author MrArthur
 * @since 1.0.0
 */
class TextHelper
{
    /**
     * Очищаем входной код от HTML тэгов
     *
     * @param string $text Код который нужно очистить
     * @param int $maxchar максимальное количество допустимых символов
     * @param string $termination строка которая добавляется в конце обработаного текста
     * @param string $encoding кодировка текста
     * @return string обработаная строка
     */
    public static function snippet($text, $maxchar = 90, $termination = '...', $encoding = 'utf-8')
    {
        $text = strip_tags(trim($text));
        if ($maxchar > 0 && mb_strlen($text) > $maxchar) {
            $text = mb_substr($text, 0, $maxchar, $encoding);
            if ($termination) {
                $text .= $termination;
            }
        }
        return $text;
    }

    /**
     * Возвращает все символы алфавита
     *
     * @param $type string Тип символов: 'ru', 'en', 'num' или 'all'
     * @param bool $upperCase Символы в верхнем регистре
     * @return array
     */
    public static function getSymbolArray($type, $upperCase = false)
    {
        // если тип 'all' - получаем все массивы символов и мерджим
        if ($type == 'all') {
            return ArrayHelper::merge(
                self::getSymbolArray('en', $upperCase),
                self::getSymbolArray('ru', $upperCase),
                self::getSymbolArray('num', $upperCase)
            );
        }

        switch ($type) {
            // кириллица
            case 'ru':
                $items = [];
                $range = range(chr(0xC0), chr(0xDF));
                array_splice($range, 6, 0, chr(168)); // + ё
                foreach ($range as $b) {
                    if ($upperCase) {
                        $items[] = iconv('CP1251', 'UTF-8', $b);
                    } else {
                        $items[] = iconv('CP1251', 'UTF-8', mb_strtolower($b, 'CP1251'));
                    }
                }
                return $items;
                break;
            // латиница
            case 'en':
                return $upperCase ? range('A', 'Z') : range('a', 'z');
                break;
            // цифры
            case 'num':
                return range(0, 9);
                break;
        }

        return [];
    }

    /**
     * Удаляет пустые строки из текста
     *
     * @param $string
     * @return mixed
     */
    public static function removeEmptyLines($string)
    {
        return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);
    }

    /**
     * Обрезка длинных слов
     *
     * @param $string
     * @param int $width
     * @param string $break
     * @return string
     *
     * @author cbuckley
     * @see http://stackoverflow.com/questions/9815040/smarter-word-wrap-in-php-for-long-words
     */
    public static function smartWordwrap($string, $width = 32, $break = ' ')
    {
        // split on problem words over the line length
        $pattern = sprintf('/([^ ]{%d,})/', $width);
        $output = '';
        $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        foreach ($words as $word) {
            if (false !== strpos($word, ' ')) {
                // normal behaviour, rebuild the string
                $output .= $word;
            } else {
                // work out how many characters would be on the current line
                $wrapped = explode($break, wordwrap($output, $width, $break));
                $count = $width - (strlen(end($wrapped)) % $width);

                // fill the current line and add a break
                $output .= substr($word, 0, $count) . $break;

                // wrap any remaining characters from the problem word
                $output .= wordwrap(substr($word, $count), $width, $break, true);
            }
        }
        // wrap the final output
        return wordwrap($output, $width, $break);
    }

    /**
     * Скрывает часть E-mail'а
     * Заменяет example@example.com на e******@example.com
     *
     * @param $email
     * @return mixed
     */
    public static function hidePartOfEmail($email)
    {
        return preg_replace('/(?<=.).(?=.*@)/u', '*', $email);
    }

    /**
     * Очищает строку
     *
     * @param $var
     * @return mixed
     */
    public static function filterString($var)
    {
        return trim(filter_var($var, FILTER_SANITIZE_STRING));
    }

    /**
     * Очищает URL
     *
     * @param $var
     * @return mixed
     */
    public static function filterUrl($var)
    {
        return filter_var($var, FILTER_SANITIZE_URL);
    }

    /**
     * Очищает текст с помощью HtmlPurifier
     *
     * @param $text
     * @param string $type
     * @return string
     */
    public static function filterPurify($text, $type = 'text')
    {
        $config = ($type == 'html') ? PurifierBehavior::purifierOptionsHtml() : PurifierBehavior::purifierOptionsText();
        return HtmlPurifier::process($text, $config);
    }
}