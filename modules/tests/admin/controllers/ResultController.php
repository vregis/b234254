<?php

namespace modules\tests\admin\controllers;

use modules\core\admin\base\Controller;
use modules\tests\models\Test;
use modules\tests\models\TestResult;
use Yii;
use yii\helpers\Url;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class ResultController extends Controller
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

    public function actionCreate($id) {

        $test_result = new TestResult();
        $test = Test::findOne(['id' => $id]);
        if ($test_result->load(Yii::$app->request->post())) {
            $test_result->test_id = $id;
            if($test_result->save()) {
                return $this->redirect(Url::toRoute(['/tests/view', 'id' => $test->id]));
            }
        }

        return $this->render('form',[
                'test' => $test,
                'test_result' => $test_result,
                'is_create' => true
            ]);
    }
    public function actionUpdate($id) {


        $test_result = TestResult::findOne(['id' => $id]);
        $test = Test::findOne(['id' => $test_result->test_id]);
        if ($test_result->load(Yii::$app->request->post())) {
            if($test_result->save()) {
                return $this->redirect(Url::toRoute(['/tests/view', 'id' => $test->id]));
            }
        }

        return $this->render('form',[
                'test' => $test,
                'test_result' => $test_result,
                'is_create' => false
            ]);
    }

    public function actionDelete($id) {

        $test_result = TestResult::findOne(['id' => $id]);
        $test_id = $test_result->test_id;
        $test_result->delete();

        return $this->redirect(Url::toRoute(['/tests/view', 'id' => $test_id]));
    }
}