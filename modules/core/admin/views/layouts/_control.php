<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/**
 * @var backend\modules\core\base\View $this
 */

$options = [
    'id' => 'control-bar',
    'renderInnerContainer' => false,
    'brandUrl' => ['index'],
    'options' => [
        'class' => 'navbar-default',
    ]
];

$items = [];

/**
 * Проверяем, есть ли у модуля настройки
 * Если есть, то выводим ссылку на страницу настроек
 */

$mod = $this->context->module;

if ($mod->id !== 'core' && method_exists($mod, 'getEditableParams') && !empty($mod->editableParams)) {
    $items[] = [
        'label' => '<i class="glyphicon glyphicon-cog"></i> ' . Yii::t('core', 'Настройки'),
        'url' => ['/core/settings/edit', 'module' => $mod->id]
    ];
}

if (isset($this->params['control']['brandLabel'])) {
    $options['brandLabel'] = $this->params['control']['brandLabel'];
}

if (isset($this->params['control']['create']) && is_array(
        $this->params['control']['create']
    ) && $this->params['control']['create'] !== false
) {
    $items[] = [
        'label' => '<i class="glyphicon glyphicon-plus-sign"></i> ' . $this->params['control']['create']['label'],
        'url' => $this->params['control']['create']['url']
    ];
} elseif (!isset($this->params['control']['create']) || $this->params['control']['create'] !== false) {
    $items[] = [
        'label' => '<i class="glyphicon glyphicon-plus-sign"></i> ' . Yii::t('core', 'Добавить'),
        'url' => ['create']
    ];
}

if (isset($this->params['control']['modelId'])) {
    $modelId = $this->params['control']['modelId'];
    $items[] = [
        'label' => '<i class="glyphicon glyphicon-pencil"></i> ' . Yii::t('core', 'Редактировать'),
        'url' => ['update', 'id' => $modelId]
    ];
} elseif (isset($this->params['cancel'])) {
    $items[] = [
        'label' => '<i class="glyphicon glyphicon-remove-sign"></i> ' . Yii::t('core', 'Отмена'),
        'url' => ['index']
    ];
}

NavBar::begin($options);

echo Nav::widget(
    [
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        'items' => $items
    ]
);

NavBar::end();