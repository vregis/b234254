<?php

namespace modules\user\modules\media\models;

use Yii;

/**
 * Примесь для моделей модуля [[user/media]]
 *
 * @property \frontend\modules\user\modules\media\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
trait ModuleTrait
{
    /**
     * @var null|\common\modules\user\modules\media\Module
     */
    private $_module;

    /**
     * @return null|\common\modules\user\modules\media\Module
     */
    protected function getModule()
    {
        if ($this->_module === null) {
            $this->_module = Yii::$app->getModule('user/media');
        }
        return $this->_module;
    }
}