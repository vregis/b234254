<?php

namespace modules\departments\admin\controllers;

use modules\core\admin\base\Controller;
use modules\departments\models\Department;
use modules\departments\models\Specialization;
use modules\departments\models\Industry;
use modules\tasks\models\Task;
use modules\milestones\models\Milestone;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DefaultController extends Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs']['actions'] = [
        //    'delete' => ['post'],
        //    'confirm' => ['post'],
        //    'block' => ['post']
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $specializations_counts = [];
        $tasks_counts = [];
        $departments = Department::find()->where(['is_additional' => 0])->all();
        foreach($departments as $department) {
            $specializations_counts[$department->id] = Specialization::find()->where(['department_id' => $department->id])->count();
            $tasks_counts[$department->id] = Task::find()->where(['department_id' => $department->id])->count();
        }

        $additional_departments = Department::find()->where(['is_additional' => 1])->all();
        foreach($additional_departments as $additional_department) {
            $specializations_counts[$additional_department->id] = Specialization::find()->where(['department_id' => $additional_department->id])->count();
            $tasks_counts[$additional_department->id] = Task::find()->where(['department_id' => $additional_department->id])->count();
        }

        return $this->render('index',[
                'departments' => $departments,
                'additional_departments' => $additional_departments,
                'specializations_counts' => $specializations_counts,
                'tasks_counts' => $tasks_counts
            ]);
    }

    public function actionCreate() {

        $department = new Department();
        if ($department->load(Yii::$app->request->post())) {
            if($department->save()) {
                return $this->redirect(Url::toRoute('/departments'));
            }
        }

        return $this->render('form',[
                'department' => $department,
                'is_create' => true
            ]);
    }
    public function actionUpdate($id) {

        $department = Department::findOne(['id' => $id]);
        if ($department->load(Yii::$app->request->post())) {
            if($department->save()) {
                return $this->redirect(Url::toRoute('/departments'));
            }
        }

        return $this->render('form',[
                'department' => $department,
                'is_create' => false
            ]);
    }
    public function actionView($id) {

        $department = Department::findOne(['id' => $id]);

        $specializations = Specialization::findAll(['department_id' => $id]);
        $specializationsArr = ArrayHelper::map($specializations, 'id' , 'name');

        $industries = [];
        if($department->name == 'Idea') {
            $industries = Industry::find()->all();
        }
        $milestones = Milestone::find()->all();
        $milestonesArr = ArrayHelper::map($milestones, 'id' , 'name');

        return $this->render('view',[
            'department' => $department,
            'specializations' => $specializations,
            'specializationsArr' => $specializationsArr,
            'milestonesArr' => $milestonesArr,
            'industries' => $industries
        ]);
    }
    public function actionDelete($id) {

        $department = Department::findOne(['id' => $id]);
        $department->delete();

        return $this->redirect(Url::toRoute('/departments'));
    }
}