<?php

namespace modules\tests\admin\controllers;

use modules\core\admin\base\Controller;
use modules\tests\models\Test;
use modules\tests\models\TestCategory;
use modules\tests\models\TestQuestion;
use Yii;
use yii\helpers\Url;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class CategoryController extends Controller
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

        $test_category = new TestCategory();
        $test = Test::findOne(['id' => $id]);
        if ($test_category->load(Yii::$app->request->post())) {
            $test_category->test_id = $id;
            if($test_category->save()) {
                return $this->redirect(Url::toRoute(['/tests/category/view', 'id' => $test_category->id]));
            }
        }

        return $this->render('form',[
                'test' => $test,
                'test_category' => $test_category,
                'is_create' => true
            ]);
    }
    public function actionUpdate($id) {

        $test_category = TestCategory::findOne(['id' => $id]);
        $test = Test::findOne(['id' => $test_category->test_id]);
        if ($test_category->load(Yii::$app->request->post())) {
            if($test_category->save()) {
                return $this->redirect(Url::toRoute(['/tests/view', 'id' => $test->id]));
            }
        }

        return $this->render('form',[
                'test' => $test,
                'test_category' => $test_category,
                'is_create' => false
            ]);
    }
    public function actionView($id) {
        $test_questions = TestQuestion::findAll(['category_id' => $id]);
        $test_category = TestCategory::findOne(['id' => $id]);
        $test = Test::findOne(['id' => $test_category->test_id]);

        return $this->render('view',[
                'test' => $test,
                'test_category' => $test_category,
                'test_questions' => $test_questions
            ]);
    }
    public function actionDelete($id) {

        $test_category = TestCategory::findOne(['id' => $id]);
        $test_id = $test_category->test_id;
        $test_category->delete();

        return $this->redirect(Url::toRoute(['/tests/view', 'id' => $test_id]));
    }
}