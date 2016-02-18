<?php

namespace modules\tests\admin\controllers;

use modules\core\admin\base\Controller;
use modules\tests\models\Test;
use modules\tests\models\TestCategory;
use modules\tests\models\TestResult;
use modules\tests\models\TestOption;
use Yii;
use yii\helpers\Url;

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
        //    'table' => ['post'],
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $tests = Test::find()->all();
        return $this->render('index',[
                'tests' => $tests
            ]);
    }

    public function actionCreate() {

        $test = new Test();
        if ($test->load(Yii::$app->request->post())) {
                if($test->save()) {
                return $this->redirect(Url::toRoute(['/tests/view', 'id' => $test->id]));
            }
        }

        return $this->render('form',[
                'test' => $test,
                'is_create' => true
            ]);
    }
    public function actionUpdate($id) {

        $test = Test::findOne(['id' => $id]);
        if ($test->load(Yii::$app->request->post())) {
            if($test->save()) {
                return $this->redirect(Url::toRoute('/tests'));
            }
        }

        return $this->render('form',[
                'test' => $test,
                'is_create' => false
            ]);
    }
    public function actionView($id) {

        $test = Test::findOne(['id' => $id]);

        $test_categories = TestCategory::findAll(['test_id' => $id]);
        $test_results = TestResult::findAll(['test_id' => $id]);
        $test_options = TestOption::findAll(['test_id' => $id]);

        return $this->render('view',[
                'test' => $test,
                'test_categories' => $test_categories,
                'test_results' => $test_results,
                'test_options' => $test_options
            ]);
    }
    public function actionDelete($id) {

        $test = Test::findOne(['id' => $id]);
        $test->delete();

        return $this->redirect(Url::toRoute('/tests'));
    }
}