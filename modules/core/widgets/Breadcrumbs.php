<?php

namespace modules\core\widgets;

use yii\widgets\Breadcrumbs as YiiBreadcrumbs;

/**
 * Обертка для yii\widgets\Breadcrumbs
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Breadcrumbs extends YiiBreadcrumbs
{
    /** @inheritdoc */
    public $options = ['class' => 'breadcrumb'];
}