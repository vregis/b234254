<?php

namespace modules\core\site\base;

use modules\core\base\View as CommonView;
use yii\helpers\Url;

/**
 * Класс View
 *
 * Базовый класс View для всех вьюшек фронтенда
 *
 * @property Controller $context
 *
 * @author MrArthur
 * @since 1.0.0
 */
class View extends CommonView
{
    /**
     * Генерирует URL на страницу по алиасу
     *
     * @param $alias
     * @param bool $onlyRule Вернуть только правило (например для параметра 'url' виджета "Menu")
     * @return array|string
     */
    public function pageUrl($alias, $onlyRule = false)
    {
        return $onlyRule ? ['/page/default/view', 'alias' => $alias]
            : Url::to(['/page/default/view', 'alias' => $alias]);
    }

    /**
     * Ссылка на страницу пользователя
     *
     * @param int $id ID пользователя
     * @return string
     */
    public function userUrl($id)
    {
        return $this->url(['/user/profile/profile', 'id' => $id]);
    }
}