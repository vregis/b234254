<?php

namespace modules\tasks;

use modules\core\base\Module as CommonModule;
use Yii;
use yii\web\GroupUrlRule;


/**
 * Модуль [[contact]] - common
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Module extends CommonModule
{
    /** @inheritdoc */
    const VERSION = '1.0.0';

    /** @inheritdoc */
    public function getDependencies()
    {
        return ['tasks'];
    }

    public $inMenu = true;
    public function getTitle()
    {
        return 'Tasks';
    }
    
    /** @inheritdoc */
    public function getUrlRules()
    {
        return new GroupUrlRule([
                'prefix' => 'tasks',
                'rules' => [
                //    '<id:\d+>' => 'default/index',
                //    '<_a:[\w\-]+>/<id:\d+>' => 'default/<_a>',
                ]
            ]);
    }
}