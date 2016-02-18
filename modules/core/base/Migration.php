<?php

namespace modules\core\base;

use yii\db\Migration as YiiMigration;

/**
 * Базовый класс для миграций, перекрывает yii\db\Migration
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Migration extends YiiMigration
{
    /** @var string Название текущей таблицы */
    protected $tableName;
    /** @var string Настройки для создаваемой таблицы */
    protected $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    /**
     * Получить значение аттрибута из DSN
     *
     * @param $name
     * @param $dsn
     * @return null|mixed
     */
    protected function getDsnAttribute($name, $dsn)
    {
        return preg_match('/' . $name . '=([^;]*)/', $dsn, $match) ? $match[1] : null;
    }
}