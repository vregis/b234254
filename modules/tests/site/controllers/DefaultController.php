<?php

namespace modules\tests\site\controllers;

use modules\core\site\base\Controller;
use modules\tasks\models\Task;
use modules\tasks\models\UserTool;
use modules\tests\models\Test;
use modules\tests\models\TestCategory;
use modules\tests\models\TestQuestion;
use modules\tests\models\TestOption;
use modules\tests\models\TestResult;
use modules\tests\models\TestUser;
use modules\tests\models\TestUserResult;
use modules\tests\models\TestCalculationResult;
use modules\tests\models\TestProgress;
use modules\tests\models\TestProgressForm;
use modules\user\models\User;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DefaultController extends Controller
{
    public $layout = "@modules/core/site/views/layouts/main";
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'start',
                            'progress',
                            'result',
                            'statictest',
                            'startpage',
                            'startpagewithoutlayout',
                            'clear'
                        ],
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    function redirectEndTest() {
        return $this->redirect(Url::toRoute('/departments'));
    }

    public function actionStart() {

        $test = Test::find()->one();

        $user_id = Yii::$app->user->identity->id;
        $test_user = TestUser::findOne([
                'user_id' => $user_id
            ]);
        if(!is_null($test_user) && $test_user->is_finish) {
            if(Yii::$app->user->can('tester')) {
                return $this->render('tester');
            }
            return $this->redirectEndTest();
        }

        return $this->redirect(Url::toRoute($test->start_page));
    }
    public function actionClear()
    {
        $user_id = Yii::$app->user->identity->id;
        $test_user = TestUser::findOne([
            'user_id' => $user_id
        ]);
        if($test_user) {
            $test_user->delete();
        }
        $this->redirect(Url::toRoute('/tests/start'));
    }

    public function actionProgress($step = -1)
    {
        $test = Test::find()->one();

        $user_id = Yii::$app->user->identity->id;

        $test_user = TestUser::findOne([
                'user_id' => $user_id
            ]);
        if(is_null($test_user)) {
            $test_user = new TestUser();
            $test_user->user_id = $user_id;
            $test_user->test_id = $test->id;
            $test_user->save();
        }

        $test_id = $test_user->test_id;
        if($step == -1) {
            $step = $test_user->step;
        }
        $test = Test::findOne(['id' => $test_id]);
        $count = TestCategory::find()->where(['test_id' => $test_id])->count();
        $count_category = 0;
        if($step < $count) {
            $count_category = 1;
        }
        if($step + 1 < $count) {
            $count_category = 2;
        }
        $test_category = [];
        $test_questions = [];
        $test_progress_model = [];
        $test_options = TestOption::findAll(['test_id' => $test->id]);
        $progress_model = new TestProgressForm;
        for($i=0; $i < $count_category; $i++) {
            $test_category[$i] = TestCategory::find()->where(['test_id' => $test->id])->offset($step + $i)->one();
            $test_questions[$i] = TestQuestion::findAll(['category_id' => $test_category[$i]->id]);

            $j=0;
            foreach($test_questions[$i] as $question) {
                $test_progress_model[$i][$j] = TestProgress::find()->where([
                    'test_id' => $test->id,
                    'test_user_id' => $test_user->id,
                    'category_id' => $test_category[$i]->id,
                    'question_id' => $question->id
                ])->one();
                if(is_null($test_progress_model[$i][$j])) {
                    $test_progress_model[$i][$j] = new TestProgress();
                }
                $progress = $test_progress_model[$i][$j];
                $progress->test_id = $test->id;
                $progress->test_user_id = $test_user->id;
                $progress->category_id = $test_category[$i]->id;
                $progress->question_id = $question->id;
                $progress_model->option[$i][$j] = $progress->option;
                $j++;
            }
        }

        $test_progress_form = Yii::$app->request->post('TestProgressForm');
        if(!is_null($test_progress_form)) {
            $step = Yii::$app->request->post('step');
            $i=0;
            foreach($test_progress_form['option'] as $TestProgress) {
                $j=0;
                foreach($TestProgress as $progress) {
                    $test_progress_model[$i][$j]->option = $progress;
                    $test_progress_model[$i][$j]->save();
                    $j++;
                }
                $i++;
            }
            if($step == $test_user->step) {
                $test_user->step = $step + 2;
                $test_user->save();
            }
            return $this->redirect(Url::toRoute(['/tests/progress', 'step' => $step + 2]));
        }

        if($step < $count) {
            $test_options = TestOption::findAll(['test_id' => $test_id]);
            return $this->render('progress',[
                    'test' => $test,
                    'test_category' => $test_category,
                    'test_questions' => $test_questions,
                    'progress_model' => $progress_model,
                    'test_progress_model' => $test_progress_model,
                    'test_options' => $test_options,
                    'count' => $count,
                    'step' => $step
                ]);
        }
        if(!$test_user->is_finish) {
            $test_results = TestResult::findAll(['test_id' => $test->id]);
            foreach ($test_results as $test_result) {
                $test_user_result = TestUserResult::findOne(
                    [
                        'test_user_id' => $test_user->id,
                        'result_id' => $test_result->id,
                    ]
                );
                if (is_null($test_user_result)) {
                    $test_user_result = new TestUserResult();
                    $test_user_result->test_user_id = $test_user->id;
                    $test_user_result->result_id = $test_result->id;
                }

                $calculation_result = null;
                $test_categories = TestCategory::find()->where(['test_id' => $test->id])->all();
                foreach($test_categories as $test_category) {
                    $test_questions = TestQuestion::findAll(['category_id' => $test_category->id]);
                    foreach ($test_questions as $test_question) {
                        $test_progress = TestProgress::find()->where([
                            'test_id' => $test->id,
                            'test_user_id' => $test_user->id,
                            'category_id' => $test_category->id,
                            'question_id' => $test_question->id
                        ])->one();
                        $calculation_result = TestCalculationResult::findOne(
                            [
                                'test_id' => $test->id,
                                'category_id' => $test_category->id,
                                'question_id' => $test_question->id,
                                'result_id' => $test_result->id,
                                'option_id' => $test_options[$test_progress->option]->id,
                            ]
                        );
                        if (!is_null($calculation_result)) {
                            $test_user_result->points += $calculation_result->points;
                        }
                    }
                }
                if (!is_null($calculation_result)) {
                    $test_user_result->save();
                }
            }
            $test_user->is_finish = 1;
            $test_user->save();
        }
        return $this->redirect(Url::toRoute('/tests/result'));
    }

    static function compare_points($a, $b)
    {
        return $a['user_result']->points < $b['user_result']->points ? 1 : -1;
    }

    public function getResultInform(&$min_points,&$max_points) {
        $user_id = Yii::$app->user->identity->id;
        $test_user = TestUser::find()->where(['user_id' => $user_id])->orderBy(['id' => SORT_DESC])->one();
        $test_result_inform = [];
        if($test_user) {
            $test = Test::findOne(['id' => $test_user->test_id]);
            $test_user_results = TestUserResult::findAll(
                [
                    'test_user_id' => $test_user->id
                ]
            );

            foreach ($test_user_results as $test_user_result) {
                if ($test_user_result->points > $max_points) {
                    $max_points = $test_user_result->points;
                } else if ($test->id == 1 && $test_user_result->result_id == 10 && $test_user_result->points == $max_points) //Idea главней остальных результатов
                {
                    $max_points = $test_user_result->points;
                }
                if ($test_user_result->points < $min_points) {
                    $min_points = $test_user_result->points;
                }
                $test_result_inform[] = [
                    'result' => TestResult::find()->where(['id' => $test_user_result->result_id])->one(),
                    'user_result' => $test_user_result
                ];
            }

            usort($test_result_inform, [$this->className(), 'compare_points']);
        }
        return $test_result_inform;
    }

    public function actionResult()
    {
        $user_id = Yii::$app->user->identity->id;
        $test_user = TestUser::find()->where(['user_id' => $user_id])->orderBy(['id' => SORT_DESC])->one();
        if(!is_null($test_user) && !$test_user->is_finish) {
            return $this->redirect(Url::toRoute('/tests/progress'));
        }
        if($test_user) {
            $test = Test::findOne(['id' => $test_user->test_id]);
            $test_user_results = TestUserResult::findAll(
                [
                    'test_user_id' => $test_user->id
                ]
            );

            $min_points = 10000;
            $max_points = -1;
            $test_result_inform = $this->getResultInform($min_points, $max_points);

            $user = User::find()->where(['id' => Yii::$app->user->id])->one();

            $redirect_url = Url::toRoute(['/departments']);
            if($user->user_type == User::TYPE_SPECIALIST || $user->user_status >= User::STATUS_TEST_PASSED) {
                $redirect_url = Url::toRoute(['/core/profile']);
            }

            if($user->user_status == User::STATUS_ROADMAP_PASSED) {
                $user->user_status = User::STATUS_TEST_PASSED;
                $user->save(false);
            }

            return $this->render(
                'results',
                [
                    'test' => $test,
                    'test_user' => $test_user,
                    'test_result_inform' => $test_result_inform,
                    'max_points' => $max_points,
                    'min_points' => $min_points,
                    'redirect_url' => $redirect_url
                ]
            );
        }
        else {
            return $this->redirect(Url::toRoute('/tests/progress'));
        }
    }
    function getQuestionName($name) {
        $data = [];
        if( preg_match("/^(.*?) - (.*?)$/", $name, $data)) {
            $result[] = $data[1];
            $result[] = $data[2];
        }
        else {
            $result = $name;
        }
        return $result;
    }

    public function actionStatictest($step = 0){

       $test = Test::find()->one();

        $this->layout = false;

        //$test = Test::findOne(['id' => $test_id]);
        $count = TestCategory::find()->where(['test_id' => 1])->count();
        $count_category = 0;
        if($step < $count) {
            $count_category = 1;
        }
        if($step + 1 < $count) {
            $count_category = 2;
        }
        $test_category = [];
        $test_questions = [];
        $test_progress_model = [];
        $test_options = TestOption::findAll(['test_id' => $test->id]);
        $progress_model = new TestProgressForm;
        for($i=0; $i < $count_category; $i++) {
            $test_category[$i] = TestCategory::find()->where(['test_id' => $test->id])->offset($step + $i)->one();
            $test_questions[$i] = TestQuestion::findAll(['category_id' => $test_category[$i]->id]);

            $j=0;
            foreach($test_questions[$i] as $question) {
                $test_progress_model[$i][$j] = TestProgress::find()->where([
                    'test_id' => $test->id,
                    'category_id' => $test_category[$i]->id,
                    'question_id' => $question->id
                ])->one();
                if(is_null($test_progress_model[$i][$j])) {
                    $test_progress_model[$i][$j] = new TestProgress();
                }
                $progress = $test_progress_model[$i][$j];
                $progress->test_id = $test->id;
                $progress->category_id = $test_category[$i]->id;
                $progress->question_id = $question->id;
                $progress_model->option[$i][$j] = $progress->option;
                $j++;
            }
        }

        $test_progress_form = Yii::$app->request->post('TestProgressForm');
        if(!is_null($test_progress_form)) {
            $step = Yii::$app->request->post('step');
            $i=0;

            return $this->redirect(Url::toRoute(['/tests/progress', 'step' => $step + 2]));
        }

        if($step < $count) {
            $test_options = TestOption::findAll(['test_id' => 1]);
            return $this->render('@modules/tests/site/views/default/progress',[
                'test' => $test,
                'test_category' => $test_category,
                'test_questions' => $test_questions,
                'progress_model' => $progress_model,
                'test_progress_model' => $test_progress_model,
                'test_options' => $test_options,
                'count' => $count,
                'step' => $step
            ]);
        }

    }

    public function actionStartpage(){
        $this->layout = '@modules/user/layouts/start';
        return $this->render('@modules/tests/site/views/default/startpage');
    }

    public function actionStartpagewithoutlayout(){
        return $this->render('@modules/tests/site/views/default/startpage');
    }



}