<?php

/**
 * Модули бэкенда
 *
 * @author MrArthur
 * @since 1.0.0
 */
return [
    // core
    'core' => [
        'class' => 'modules\core\Module',
        'basePath' => Yii::getAlias('@modules').'/core/admin',
        'controllerNamespace' => 'modules\core\admin\controllers',
    ],
    // departments
    'departments' => [
        'class' => 'modules\departments\Module',
        'basePath' => Yii::getAlias('@modules').'/departments/admin',
        'controllerNamespace' => 'modules\departments\admin\controllers',
    ],
    // milestones
    'milestones' => [
        'class' => 'modules\milestones\Module',
        'basePath' => Yii::getAlias('@modules').'/milestones/admin',
        'controllerNamespace' => 'modules\milestones\admin\controllers',
    ],
    // tasks
    'tasks' => [
        'class' => 'modules\tasks\Module',
        'basePath' => Yii::getAlias('@modules').'/tasks/admin',
        'controllerNamespace' => 'modules\tasks\admin\controllers',
    ],
    // tests
    'tests' => [
        'class' => 'modules\tests\Module',
        'basePath' => Yii::getAlias('@modules').'/tests/admin',
        'controllerNamespace' => 'modules\tests\admin\controllers',
    ],
    // user
    'user' => [
        'class' => 'modules\user\Module',
        'basePath' => Yii::getAlias('@modules').'/user/admin',
        'controllerNamespace' => 'modules\user\admin\controllers',
    ],
];
