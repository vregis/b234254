<?php

/**
 * Модули фронтенда
 *
 * @author MrArthur
 * @since 1.0.0
 */

return [
    // core
    'core' => [
        'class' => 'modules\core\Module',
        'basePath' => Yii::getAlias('@root').'/modules/core/site',
        'controllerNamespace' => 'modules\core\site\controllers',
    ],
    // user
    'user' => [
        'class' => 'modules\user\Module',
        'basePath' => Yii::getAlias('@root').'/modules/user/site',
        'controllerNamespace' => 'modules\user\site\controllers',
        'onlySteam' => false, // Активирует разные типы входа на сайт
        'steamApiKey' => '5095E47275F3FA8EC1362ED07EAEEA7E',
        'enableRegistration' => true,
        'enablePasswordRecovery' => true,
        'enableConfirmation' => true,// Активирует email письмо подтверждения  и делает поле confirmed_at  пустым
        /*'modules' => [
            // user-media
            'media' => [
                'class' => 'frontend\modules\user\modules\media\Module'
            ],
        ]*/
    ],
    // chat
    'chat' => [
        'class' => 'modules\chat\Module'
    ],
    // mail
    'mail' => [
        'class' => 'modules\mail\Module'
    ],
    // departments
    'departments' => [
        'class' => 'modules\departments\Module',
        'basePath' => Yii::getAlias('@modules').'/departments/site',
        'controllerNamespace' => 'modules\departments\site\controllers',
    ],
    // tests
    'tests' => [
        'class' => 'modules\tests\Module',
        'basePath' => Yii::getAlias('@modules').'/tests/site',
        'controllerNamespace' => 'modules\tests\site\controllers',
    ],
    // tasks
    'tasks' => [
        'class' => 'modules\tasks\Module',
        'basePath' => Yii::getAlias('@modules').'/tasks/site',
        'controllerNamespace' => 'modules\tasks\site\controllers',
    ],
];