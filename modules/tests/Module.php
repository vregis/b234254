<?php

namespace modules\tests;

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
        return ['tests'];
    }

    public $inMenu = true;
    public function getTitle()
    {
        return 'Tests';
    }
    
    /** @inheritdoc */
    public function getUrlRules()
    {
        return new GroupUrlRule([
                'prefix' => 'tests',
                'rules' => [
                    '<_a:[\w\-]+>' => 'default/<_a>',
                    '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
                ]
            ]);
    }
}