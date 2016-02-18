<?php

use yii\widgets\Menu;

/**
 * @var frontend\modules\core\base\View $this
 */

$curModId = $this->context->module->id;

echo Menu::widget(
    [
        'items' => [
            [
                'label' => Yii::t('mirprost', 'Игры'),
                'url' => ['/games'],
                'active' => false
            ],
            [
                'label' => Yii::t('mirprost', 'Турниры'),
                'url' => ['/tournament/default/index'],
                'active' => false
            ],
            [
                'label' => Yii::t('mirprost', 'Магазин'),
                'url' => ['/store'],
                'active' => false
            ],
            [
                'label' => Yii::t('mirprost', 'Проект'),
                'url' => ['/news'],
                'active' => false
            ],


        ],
        'options' => [
            'class' => 'menu-title',
        ],
    ]
);

