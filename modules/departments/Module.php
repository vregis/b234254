<?php

namespace modules\departments;

use modules\core\base\Module as CommonModule;
use Yii;
use common\modules\departments\models\Department;
use yii\helpers\FileHelper;
use yii\helpers\Html;
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
        return ['departments'];
    }
    public function getTitle()
    {
        return 'Departments';
    }
    
    public function getUrlRules()
    {
        return new GroupUrlRule([
                'prefix' => 'departments',
                'rules' => [
                    'business' => 'business/index',
                //    '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
                ]
            ]);
    }
}