<?php

namespace modules\chat;

use modules\core\base\Module as CommonModule;
use Yii;
use yii\web\GroupUrlRule;

/**
 * Модуль [[chat]] - common
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
        return ['core', 'user'];
    }
    
    public function getUrlRules()
    {
        return new GroupUrlRule([
            'prefix' => 'chat',
            'rules' => [
                //'<alias:[\w\-]+>' => 'default/view',
                //'default/<action:[\w\-]+>' => 'default/<action>',
            ]
        ]);
    }
}