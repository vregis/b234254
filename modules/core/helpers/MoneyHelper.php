<?php

namespace modules\core\helpers;

/**
 * Хелпер для обработки денег/валют
 *
 * @author MrArthur
 * @since 1.0.0
 */
class MoneyHelper
{
    /**
     * Форматирует сумму денег
     *
     * @param $number
     * @param int $decimals
     * @param string $dec_point
     * @param string $thousands_sep
     * @return string
     */
    public static function format($number, $decimals = 2, $dec_point = '.', $thousands_sep = ' ')
    {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }
}