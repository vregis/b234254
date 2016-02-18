<?php

namespace modules\tests\admin\controllers;

use modules\core\admin\base\Controller;
use modules\tests\models\Test;
use modules\tests\models\TestCalculationResult;
use modules\tests\models\TestCategory;
use modules\tests\models\TestQuestion;
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
class QuestionController extends Controller
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

    function createCalculationResults($test_results, $test_options) {
        $result = [];
        foreach($test_results as $test_result) {
            foreach($test_options as $test_option) {
                $result[$test_result->id][$test_option->id] = new TestCalculationResult();
                $result[$test_result->id][$test_option->id]->points = 0;
            }
        }
        return $result;
    }
    function getCalculationResults($test_results, $test_options,$test_id,$category_id,$question_id) {
        $result = [];
        foreach($test_results as $test_result) {
            foreach($test_options as $test_option) {
                $calculation_result = TestCalculationResult::findOne([
                        'test_id' => $test_id,
                        'category_id' => $category_id,
                        'question_id' => $question_id,
                        'result_id' => $test_result->id,
                        'option_id' => $test_option->id,
                    ]);
                if(!is_null($calculation_result)) {
                    $result[$test_result->id][$test_option->id] = $calculation_result;
                }
                else {
                    $result[$test_result->id][$test_option->id] = new TestCalculationResult();
                    $result[$test_result->id][$test_option->id]->points = 0;
                }
            }
        }
        return $result;
    }
    function saveCalculationResults($calculation_results, $test_results, $test_options,$test_id,$category_id,$question_id) {
        foreach($test_results as $test_result) {
            foreach($test_options as $test_option) {
                $calculation_result = $calculation_results[$test_result->id][$test_option->id];
                if(isset(Yii::$app->request->post('TestCalculationResult')[$test_result->id][$test_option->id]['points'])) {
                    $calculation_result->points = Yii::$app->request->post('TestCalculationResult')[$test_result->id][$test_option->id]['points'];
                    $calculation_result->test_id = $test_id;
                    $calculation_result->category_id = $category_id;
                    $calculation_result->question_id = $question_id;
                    $calculation_result->result_id = $test_result->id;
                    $calculation_result->option_id = $test_option->id;
                    $calculation_result->save();
                }
            }
        }
    }

    public function actionCreate($id) {

        $test_question = new TestQuestion();
        $test_category = TestCategory::findOne(['id' => $id]);
        $test = Test::findOne(['id' => $test_category->test_id]);

        $test_results = TestResult::findAll(['test_id' => $test->id]);
        $test_options = TestOption::findAll(['test_id' => $test->id]);

        $calculation_results = $this->createCalculationResults($test_results, $test_options);

        if ($test_question->load(Yii::$app->request->post())) {
            $test_question->category_id = $id;
            $test_question->test_id = $test_category->test_id;
            if($test_question->save()) {
                $this->saveCalculationResults($calculation_results, $test_results, $test_options, $test->id, $test_category->id, $test_question->id);
                return $this->redirect(Url::toRoute(['/tests/category/view', 'id' => $test_question->category_id]));
            }
        }

        return $this->render('form',[
                'test' => $test,
                'test_category' => $test_category,
                'test_question' => $test_question,
                'test_results' => $test_results,
                'test_options' => $test_options,
                'calculation_results' => $calculation_results,
                'is_create' => true
            ]);
    }
    public function actionUpdate($id) {

        $test_question = TestQuestion::findOne(['id' => $id]);
        $test_category = TestCategory::findOne(['id' => $test_question->category_id]);
        $test = Test::findOne(['id' => $test_category->test_id]);

        $test_results = TestResult::findAll(['test_id' => $test->id]);
        $test_options = TestOption::findAll(['test_id' => $test->id]);

        $calculation_results = $this->getCalculationResults($test_results, $test_options, $test->id, $test_category->id, $id);
        if(count($calculation_results) == 0) {
            $calculation_results = $this->createCalculationResults($test_results, $test_options);
        }

        if ($test_question->load(Yii::$app->request->post())) {

            if($test_question->save()) {
                $this->saveCalculationResults($calculation_results, $test_results, $test_options, $test->id, $test_category->id, $test_question->id);
                return $this->redirect(Url::toRoute(['/tests/category/view', 'id' => $test_question->category_id]));
            }
        }

        return $this->render('form',[
                'test' => $test,
                'test_category' => $test_category,
                'test_question' => $test_question,
                'test_results' => $test_results,
                'test_options' => $test_options,
                'calculation_results' => $calculation_results,
                'is_create' => false
            ]);
    }
    public function actionDelete($id) {

        $test_question = TestQuestion::findOne(['id' => $id]);
        $category_id = $test_question->category_id;
        $test_question->delete();

        return $this->redirect(Url::toRoute(['/tests/category/view', 'id' => $category_id]));
    }
}