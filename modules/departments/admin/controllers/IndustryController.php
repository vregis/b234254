<?php

namespace modules\departments\admin\controllers;

use modules\core\admin\base\Controller;
use modules\departments\models\Industry;
use Yii;
use yii\helpers\Url;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class IndustryController extends Controller
{
    /** @inheritdoc */

    public function actionCreate() {
        $industry = new Industry();
        if ($industry->load(Yii::$app->request->post())) {
            if($industry->save()) {
                return $this->redirect(Url::toRoute(['/departments/view', 'id' => 8]));
            }
        }

        return $this->render('form',[
                'industry' => $industry,
                'is_create' => true
            ]);
    }
    public function actionUpdate($id) {
        $industry = Industry::find()->where(['id' => $id])->one();
        if ($industry->load(Yii::$app->request->post())) {
            if($industry->save()) {
                return $this->redirect(Url::toRoute(['/departments/view', 'id' => 8]));
            }
        }

        return $this->render('form',[
            'industry' => $industry,
            'is_create' => true
            ]);
    }
    public function actionDelete($id) {
        $industry = Industry::find()->where(['id' => $id])->one();
        $industry->delete();
        return $this->redirect(Url::toRoute(['/departments/view', 'id' => 8]));
    }
}