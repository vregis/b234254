<?php

namespace common\modules\mail\models;

use Yii;

/**
 * Примесь для моделей модуля [[mail]]
 *
 * @property \common\modules\mail\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
trait ModuleTrait
{
    /**
     * @var null|\common\modules\mail\Module
     */
    private $_module;

    /**
     * @return null|\common\modules\mail\Module
     */
    protected function getModule()
    {
        if ($this->_module === null) {
            $this->_module = Yii::$app->getModule('mail');
        }
        return $this->_module;
    }
}