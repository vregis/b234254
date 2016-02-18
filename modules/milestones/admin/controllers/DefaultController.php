<?php

namespace modules\milestones\admin\controllers;

use modules\core\admin\base\Controller;
use modules\departments\models\Department;
use modules\milestones\models\Milestone;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs']['actions'] = [
        //    'confirm' => ['post'],
        //    'block' => ['post']
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $milestones = Milestone::find()->all();
        return $this->render('index',[
            'milestones' => $milestones
        ]);
    }

    public function actionCreate() {

        $milestone = new Milestone();
        if ($milestone->load(Yii::$app->request->post())) {
            $milestone->create_date = ''.date('Y-m-d');
            if($milestone->save()) {
                return $this->redirect(['/milestones']);
            }
        }

        return $this->render('form',[
            'milestone' => $milestone,
            'is_create' => true
        ]);
    }
    public function actionUpdate($id) {

        $milestone = Milestone::findOne(['id' => $id]);
        if ($milestone->load(Yii::$app->request->post())) {
            if($milestone->save()) {
                return $this->redirect(['/milestones']);
            }
        }

        return $this->render('form',[
            'milestone' => $milestone,
            'is_create' => false
        ]);
    }
    public function actionView($id) {

        $milestone = Milestone::findOne(['id' => $id]);

        $departments = Department::find()->all();
        $departmentsArr = ArrayHelper::map($departments, 'id' , 'name');
        
        if(Yii::$app->request->get("view") == 'gant'){
            $tpl = 'gant';
        }else{
            $tpl = 'view';
        }
        
        return $this->render($tpl,[
            'milestone' => $milestone,
            'departmentsArr' => $departmentsArr
        ]);
    }
    public function actionDelete($id) {

        $milestone = Milestone::find()->where(['id' => $id])->one();
        $milestone->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }
}