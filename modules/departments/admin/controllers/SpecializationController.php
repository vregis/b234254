<?php

namespace modules\departments\admin\controllers;

use modules\core\admin\base\Controller;
use modules\departments\models\Department;
use modules\departments\models\Specialization;
use Yii;
use yii\helpers\Url;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class SpecializationController extends Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs']['actions'] = [
        //    'next' => ['post'],
        ];
        return $behaviors;
    }

    public function actionCreate($id) {

        $specialization = new Specialization();
        $specialization->recommend_payment_low = 0;
        $specialization->recommend_payment_medium = 0;
        $specialization->recommend_payment_high = 0;
        $department = Department::findOne(['id' => $id]);
        if ($specialization->load(Yii::$app->request->post())) {
            $specialization->department_id = $id;
            if($specialization->save()) {
                return $this->redirect(Url::toRoute(['/departments/view', 'id' => $id]));
            }
        }

        return $this->render('form',[
                'department' => $department,
                'specialization' => $specialization,
                'is_create' => true
            ]);
    }
    public function actionUpdate($id) {

        $specialization = Specialization::findOne(['id' => $id]);
        $department = Department::findOne(['id' => $specialization->department_id]);
        if ($specialization->load(Yii::$app->request->post())) {
            if($specialization->save()) {
                return $this->redirect(Url::toRoute(['/departments/view', 'id' => $department->id]));
            }
        }

        return $this->render('form',[
                'department' => $department,
                'specialization' => $specialization,
                'is_create' => false
            ]);
    }
    public function actionView($id) {

        $specialization = Specialization::findOne(['id' => $id]);
        $department = Department::findOne(['id' => $specialization->department_id]);

        return $this->render('view',[
            'department' => $department,
            'specialization' => $specialization,
        ]);
    }
    public function actionDelete($id) {

        $specialization = Specialization::findOne(['id' => $id]);
        $department_id = $specialization->department_id;
        $specialization->delete();

        return $this->redirect(Url::toRoute(['/departments/view', 'id' => $department_id]));
    }
}