<?php

use yii\widgets\Menu;

/**
 * @var frontend\modules\core\base\View $this
 */

echo Menu::widget(
    [
        'items' => [
            [
                'label' => Yii::t('mirprost', 'Новости'),
                'url' => ['/news'],
                'active' => $title == 'Новости'
            ],
            [
                'label' => Yii::t('mirprost', 'Правила'),
                'url' => ['/page/rules'],
                'active' => $title == 'Правила'
            ],
            [
                'label' => Yii::t('mirprost', 'О проекте'),
                'url' => ['/page/about'],
                'active' => $title == 'О проекте'
            ],
        ],
        'options' => [
            'class' => 'menu-title',
        ]
    ]
);

