<?php

namespace modules\milestones;

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

    public $inMenu = true;
    /** @inheritdoc */
    public function getDependencies()
    {
        return ['milestones'];
    }
    public function getTitle()
    {
        return 'Milestones';
    }
    
    /** @inheritdoc */
    public function getUrlRules()
    {
        return new GroupUrlRule([
                'prefix' => 'milestones',
                'rules' => [
                //    '<id:\d+>' => 'default/index',
                //    '<_a:[\w\-]+>/<id:\d+>' => 'default/<_a>',
                ]
            ]);
    }
}