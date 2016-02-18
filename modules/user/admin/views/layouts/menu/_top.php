<?php

use kartik\nav\NavX;

/**
 * Меню в шапке админки (Bootstrap Nav)
 *
 * @var backend\modules\core\base\View $this
 */

$itemsLeft = [
    // Контент
    [
        'label' => $this->iconLabel('leaf', 'Контент'),
        'items' => [

            [
                'label' => $this->iconLabel('file', 'Страницы'),
                'url' => '/page/default/index'
            ],
            [
                'label' => $this->iconLabel('th-large', 'Блоки контента'),
                'url' => '/block/default/index'
            ],
            [
                'label' => $this->iconLabel('question-sign', 'Помощь'),
                'items' => [
                    [
                        'label' => $this->iconLabel('book', 'Руководство'),
                        'url' => '/help/manual/index'
                    ],
                    [
                        'label' => $this->iconLabel('leaf', 'FAQ'),
                        'url' => '/help/faq/index'
                    ],
                    [
                        'label' => $this->iconLabel('envelope', 'Обратная связь'),
                        'url' => '/help/feedback/index'
                    ],
                ]
            ],
            // Медиа
            [
                'label' => $this->iconLabel('picture', 'Медиа'),
                'items' => [
                    [
                        'label' => $this->iconLabel('forward', 'Слайдеры'),
                        'url' => '/media/slider/index'
                    ],
                    [
                        'label' => $this->iconLabel('eye-open', 'Баннеры'),
                        'url' => '/media/banner/index'
                    ],
                ],
            ],
        ],
    ],
    // Структура
    [
        'label' => $this->iconLabel('list', 'Структура'),
        'items' => [

            [
                'label' => $this->iconLabel('globe', 'Геолокации'),
                'items' => [
                    [
                        'label' => $this->iconLabel('screenshot', 'Страны'),
                        'url' => '/geo/country/index'
                    ],
                    [
                        'label' => $this->iconLabel('map-marker', 'Города'),
                        'url' => '/geo/city/index'
                    ],
                ]
            ],

        ],
    ],
    // Пользователи
    [
        'label' => $this->iconLabel('user', 'Пользователи'),
        'items' => [
            [
                'label' => $this->iconLabel('user', 'Управление пользователями'),
                'url' => '/user/default/index'
            ],
            [
                'label' => $this->iconLabel('file', 'Содержание книги отзывов'),
                'url' => '/guestbook/default/index'
            ],
        ],
    ],
    // Настройки
    [
        'label' => $this->iconLabel('cog', 'Настройки'),
        'items' => [

            [
                'label' => $this->iconLabel('refresh', 'Кеш'),
                'items' => [
                    [
                        'label' => $this->iconLabel('refresh', 'Очистка assets (frontend)'),
                        'url' => ['/core/cache/clean', 'type' => 'frontend'],
                    ],
                    [
                        'label' => $this->iconLabel('refresh', 'Очистка assets (backend)'),
                        'url' => ['/core/cache/clean', 'type' => 'backend']
                    ],
                    [
                        'label' => $this->iconLabel('refresh', 'Очистка runtime (frontend)'),
                        'url' => ['/core/cache/clean', 'type' => 'frontend-runtime']
                    ],
                    [
                        'label' => $this->iconLabel('refresh', 'Очистка runtime (backend)'),
                        'url' => ['/core/cache/clean', 'type' => 'backend-runtime']
                    ],
                    [
                        'label' => $this->iconLabel('refresh', 'Очистка кеша настроек'),
                        'url' => ['/core/cache/clean', 'type' => 'option']
                    ],
                    [
                        'label' => $this->iconLabel('refresh', 'Полная очистка'),
                        'url' => ['/core/cache/clean', 'type' => 'all']
                    ],
                ],
            ],
            [
                'label' => $this->iconLabel('envelope', 'Почта'),
                'url' => '/mail/queue/index'
            ],
            [
                'label' => $this->iconLabel('cog', 'Основные настройки'),
                'url' => ['/core/settings/edit/', 'module' => 'core']
            ],
        ],
    ],
    // Жалобы
    [
        'label' => $this->iconLabel('cog', 'Жалобы'),
        'items' => [
            [
                'label' => $this->iconLabel('envelope', 'Жалобы на команды'),
                'url' => ['/message/claim/index', 'type' => 'option']
            ],
            [
                'label' => $this->iconLabel('envelope', 'Жалобы на контент'),
                'url' => ['/claim/default/index']
            ],
        ],
    ],
];

echo NavX::widget(
    [
        'id' => 'topmenu',
        'options' => ['class' => 'nav navbar-nav'],
        'encodeLabels' => false,
        'items' => $itemsLeft,
    ]
);