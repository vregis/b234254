<?php

namespace modules\user\models;

use Yii;

/**
 * Примесь для моделей модуля [[user]]
 *
 * @property \common\modules\user\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
trait ModuleTrait
{
    /**
     * @var null|\common\modules\user\Module
     */
    private $_module;

    /**
     * @return null|\common\modules\user\Module
     */
    protected function getModule()
    {
        if ($this->_module === null) {
            $this->_module = Yii::$app->getModule('user');
        }
        return $this->_module;
    }
}