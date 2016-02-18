<?php

namespace modules\core\helpers;

use Yii;

/**
 * Вспомогательные методы для работы с датой и временем
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DateHelper
{
    /**
     * Массив с днями
     *
     * @return array
     */
    public static function getDayArray()
    {
        $range = range(1, 31);
        $new_range = [];
        foreach ($range as $v) {
            // добавляем 0 для поля date (5 -> 05)
            $new_range[] = sprintf("%02s", $v);
        }
        return array_combine($new_range, $new_range);
    }

    /**
     * Массив с месяцами
     *
     * @return array
     */
    public static function getMonthArray()
    {
        return [
            '01' => 'Январь',
            '02' => 'Февраль',
            '03' => 'Март',
            '04' => 'Апрель',
            '05' => 'Май',
            '06' => 'Июнь',
            '07' => 'Июль',
            '08' => 'Август',
            '09' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь',
        ];
    }

    /**
     * Массив с годами
     *
     * @param $from
     * @param $to
     * @return array
     */
    public static function getYearArray($from = null, $to = null)
    {
        $from = empty($from) ? 1950 : (int)$from;
        $to = empty($to) ? date('Y') - 16 : (int)$to; // минимальный возраст

        $range = range($to, $from);
        return array_combine($range, $range);
    }

    /**
     * Форматирует таймштамп в читабельную дату
     * Формат по умолчанию: 14 октября 2014 11:26
     *
     * @param $timestamp
     * @param null|string $format
     * @return string
     */
    public static function formatDate($timestamp, $format = null)
    {
        if (empty($timestamp)) {
            return null;
        }

        if ($format === null) {
            return Yii::t('core', '{0, date, dd MMMM YYYY HH:mm}', [$timestamp]);
        }

        return Yii::t('core', $format, [$timestamp]);
    }
}