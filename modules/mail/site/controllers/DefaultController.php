<?php

namespace backend\modules\mail\controllers;

use backend\modules\core\base\Controller;

/**
 * Class DefaultController
 *
 * @property \backend\modules\mail\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DefaultController extends Controller
{
    /**
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->redirect(['/mail/queue/index']);
    }
}
