<?php

namespace modules\core\models;

use Yii;

/**
 * Примесь для моделей модуля [[core]]
 *
 * @property \common\modules\core\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
trait ModuleTrait
{
    /** @var null|\common\modules\core\Module */
    private $_module;

    /** @return null|\common\modules\core\Module */
    protected function getModule()
    {
        if ($this->_module === null) {
            $this->_module = Yii::$app->getModule('core');
        }
        return $this->_module;
    }
}