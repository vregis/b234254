<?php

namespace modules\user\models;

use yii\db\ActiveQuery;

/**
 * Дополнительные фильтры для поиска пользователей
 *
 * @author MrArthur
 * @since 1.0.0
 */
class UserQuery extends ActiveQuery
{
    use ModuleTrait;

    /**
     * Только подтвержденные
     *
     * @return $this
     */
    public function confirmed()
    {
        $this->andWhere('confirmed_at IS NOT NULL');

        return $this;
    }

    /**
     * Только не подтвержденные
     *
     * @return $this
     */
    public function unconfirmed()
    {
        $this->andWhere('confirmed_at IS NULL');

        return $this;
    }
}
