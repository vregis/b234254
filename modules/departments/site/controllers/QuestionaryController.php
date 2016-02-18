<?php

namespace modules\departments\site\controllers;

use modules\core\site\base\Controller;
use modules\departments\models\Questionary;
use modules\departments\models\Department;
use modules\departments\models\Specialization;
use modules\departments\models\Idea;
use modules\departments\models\Industry;
use modules\user\models\UserSpecialization;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class QuestionaryController extends Controller
{
    public $layout = "questionary";
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
                            'next',
                            'finish',
                        ],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'clear',
                        ],
                        'roles' => ['tester']
                    ]
                ]
            ],
        ];
    }

    public function actionStart() {

        $user_id = Yii::$app->user->identity->id;

        $questionary = Questionary::findOne([
                'user_id' => $user_id
            ]);
        if(is_null($questionary)) {
            $questionary = new Questionary();
            $questionary->user_id = $user_id;
            $questionary->save();
        }
        if($questionary->is_finish) {
            if(Yii::$app->user->can('tester')) {
                return $this->render('tester');
            }
            return $this->redirect(Url::toRoute('/departments/questionary/finish'));
        }
        return $this->redirect(Url::toRoute('/departments/questionary/progress'));
    }
    public function actionClear() {

        $user_id = Yii::$app->user->identity->id;
        $questionary = Questionary::findOne([
            'user_id' => $user_id
        ]);
        if($questionary) {
            $questionary->delete();
        }
        return $this->redirect(Url::toRoute('/departments/questionary/progress'));
    }

    function goFinish($questionary) {
        if(!$questionary->is_finish) {
            $questionary->is_finish = 1;
            $questionary->save();
        }
        return $this->redirect(Url::toRoute('/departments/questionary/finish'));
    }

    public function actionProgress($step = -1)
    {
        $user_id = Yii::$app->user->identity->id;
        $questionary = Questionary::findOne([
                'user_id' => $user_id
            ]);
        if(is_null($questionary)) {
            return $this->redirect(Url::toRoute('/departments/questionary/start'));
        }

        $open_step = $questionary->open_step;
        if($step < 0 || $step >= $open_step) {
            $step = $open_step;
        }
        $count = Department::find()->where(['is_additional' => 0])->count();
        if($step < $count + 1) {
            $department = Department::find()->where(['is_additional' => 0])->offset($step)->one();

            $is_idea = false;
            if(is_null($department)) {
                $department = Department::find()->where(['icons' => 'idea'])->one();
                $is_idea = true;
            }
            $departments = Department::find()->where(['is_additional' => 0])->all();

            $specializations = Specialization::findAll(['department_id' => $department->id]);

            $is_check = false;
            $user_specializations = [];
            foreach($specializations as $specialization) {
                $user_specialization = UserSpecialization::findOne(
                    [
                        'user_id' => $user_id,
                        'specialization_id' => $specialization->id
                    ]
                );
                $user_specializations[] = !is_null($user_specialization);
                if(!is_null($user_specialization)) {
                    $is_check = true;
                }
            }
            if($is_idea && !$is_check) {
                return $this->goFinish($questionary);
            }
            $idea = null;
            $industries = [];
            if($department->icons == 'idea') {

                $industries = Industry::find()->all();
                $industries = ArrayHelper::map( $industries, 'id' , 'name');
                $idea = Idea::findOne(
                    [
                        'user_id' => $user_id
                    ]
                );
                if(is_null($idea)) {
                    $idea = new Idea();
                }
                if ($idea->load(Yii::$app->request->post())) {
                    $idea->user_id = $user_id;
                    if($idea->save()) {
                        return $this->redirect(Url::toRoute(['/departments/questionary/next']));
                    }
                }
            }
            return $this->render('progress',[
                    'department' => $department,
                    'departments' => $departments,
                    'specializations' => $specializations,
                    'user_specializations' => $user_specializations,
                    'step' => $step,
                    'open_step' => $open_step,
                    'idea' => $idea,
                    'industries' => $industries
                ]);
        }
        return $this->goFinish($questionary);
    }
    public function actionNext($step = -1)
    {
        $user_id = Yii::$app->user->identity->id;
        $questionary = Questionary::findOne([
                'user_id' => $user_id
            ]);

        $departments_count = Department::find()->where(['is_additional' => 0])->count();

        $post = Yii::$app->request->post();
        if(!empty($post)) {
            $step = Yii::$app->request->post('step');
            $open_step = Yii::$app->request->post('open_step');

            $department = Department::find()->where(['is_additional' => 0])->offset($step)->one();
            $specializations = Specialization::findAll(['department_id' => $department->id]);

            $i=0;
            foreach($specializations as $specialization) {
                $is_on = false;
                $QuestionaryProgress = Yii::$app->request->post('QuestionaryProgress');
                if (!is_null($QuestionaryProgress) && array_key_exists($i, $QuestionaryProgress)) {
                    $progress = $QuestionaryProgress[$i];
                    if ($progress == 'on') {
                        $is_on = true;
                        $user_specialization = UserSpecialization::findOne(
                            [
                                'user_id' => $user_id,
                                'specialization_id' => $specialization->id
                            ]
                        );
                        if (is_null($user_specialization)) {
                            $user_specialization = new UserSpecialization();
                            $user_specialization->user_id = $user_id;
                            $user_specialization->specialization_id = $specialization->id;
                            $user_specialization->save();
                        }
                    }
                }
                if(!$is_on) {
                    $user_specialization = UserSpecialization::findOne(
                        [
                            'user_id' => $user_id,
                            'specialization_id' => $specialization->id
                        ]
                    );
                    if (!is_null($user_specialization)) {
                        $user_specialization->delete();
                    }
                }
                $i++;
            }
            if($step < $departments_count && $step == $open_step) {
                $questionary->open_step = $open_step + 1;
                $questionary->save();
                $step = $questionary->open_step;
            }
            else {
                $step = $open_step;
            }
        }
        else {
            if($step < $departments_count && $step == -1) {
                $open_step = $questionary->open_step;
                $questionary->open_step = $open_step + 1;
                $questionary->save();
                $step = $questionary->open_step;
            }
        }

        return $this->redirect(Url::toRoute(['/departments/questionary/progress','step' => $step]));
    }
    public function actionFinish()
    {
        return $this->redirect(Url::toRoute('/core/main'));

    /*    $user_id = Yii::$app->user->identity->id;
        $questionary = Questionary::findOne([
                'user_id' => $user_id
            ]);
        $open_step = $questionary->step;
        $step = $open_step;

        $department = Department::find()->where(['is_additional' => 1])->one();
        $departments = Department::find()->where(['is_additional' => 0])->all();
        return $this->render('finish',[
                'department' => $department,
                'departments' => $departments,
                'step' => $step,
                'open_step' => $open_step
            ]);*/
    }
}