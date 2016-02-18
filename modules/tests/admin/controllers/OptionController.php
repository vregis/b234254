<?php

namespace modules\tests\admin\controllers;

use modules\core\admin\base\Controller;
use modules\tests\models\Test;
use modules\tests\models\TestOption;
use Yii;
use yii\helpers\Url;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class OptionController extends Controller
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

        $test_option = new TestOption();
        $test = Test::findOne(['id' => $id]);
        if ($test_option->load(Yii::$app->request->post())) {
            $test_option->test_id = $id;
            if($test_option->save()) {
                return $this->redirect(Url::toRoute(['/tests/view', 'id' => $test->id]));
            }
        }

        return $this->render('form',[
                'test' => $test,
                'test_option' => $test_option,
                'is_create' => true
            ]);
    }
    public function actionUpdate($id) {

        $test_option = TestOption::findOne(['id' => $id]);
        $test = Test::findOne(['id' => $test_option->test_id]);
        if ($test_option->load(Yii::$app->request->post())) {
            if($test_option->save()) {
                return $this->redirect(Url::toRoute(['/tests/view', 'id' => $test->id]));
            }
        }

        return $this->render('form',[
                'test' => $test,
                'test_option' => $test_option,
                'is_create' => false
            ]);
    }

    public function actionDelete($id) {

        $test_option = TestOption::findOne(['id' => $id]);
        $test_id = $test_option->test_id;
        $test_option->delete();

        return $this->redirect(Url::toRoute(['/tests/view', 'id' => $test_id]));
    }
}