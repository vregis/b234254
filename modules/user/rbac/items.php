<?php
return [
    'user' => [
        'type' => 1,
        'description' => 'Администратор',
        'ruleName' => 'userRole',
    ],
    'moder' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'user',
        ],
    ],
    'tester' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'user',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'moder',
            'tester'
        ],
    ],
];
