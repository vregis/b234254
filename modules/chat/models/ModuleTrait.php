<?php

namespace modules\chat\models;

use Yii;

/**
 * Примесь для моделей модуля [[chat]]
 *
 * @property \common\modules\chat\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
trait ModuleTrait
{
    /**
     * @var null|\common\modules\chat\Module
     */
    private $_module;

    /**
     * @return null|\common\modules\chat\Module
     */
    protected function getModule()
    {
        if ($this->_module === null) {
            $this->_module = Yii::$app->getModule('chat');
        }
        return $this->_module;
    }
}