<?php

use yii\widgets\Menu;

/**
 * @var frontend\modules\core\base\View $this
 */

echo Menu::widget(
    [
        'items' => [
            //['label' => Yii::t('mirprost', 'О Mirprost'), 'url' => $this->pageUrl('o-mirprost', true)],
        ],
        'options' => [
            'class' => 'menu-title',
        ],
    ]
);