<?php

namespace modules\core\site\widgets;

use yii\widgets\LinkPager as YiiLinkPager;

/**
 * Виджет LinkPager
 *
 * Обертка над стандартным виджетом yii\widgets\LinkPager
 *
 * @author MrArthur
 * @since 1.0.0
 */
class LinkPager extends YiiLinkPager
{
    /** @inheritdoc */
    public $prevPageLabel = '';
    /** @inheritdoc */
    public $nextPageLabel = '';
    /** @inheritdoc */
    public $firstPageLabel = '';
    /** @inheritdoc */
    public $lastPageLabel = '';
    /** @inheritdoc */
    public $options = ['class' => 'pagination-spisok'];
}