<?php

namespace modules\user\site\controllers;

use modules\core\site\base\Controller;
use modules\departments\models\Idea;
use modules\tests\models\TestUser;
use modules\user\models\Language;
use modules\user\models\Languages;
use modules\user\models\Skills;
use modules\user\models\User;
use modules\user\models\UserSpecialization;
use Yii;
use yii\filters\AccessControl;
use \modules\user\models\Profile;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class BusinessController extends Controller
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
                            'index',
                        ],
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function actionIndex(){
        $user = User::find()->where(['id'=>Yii::$app->user->getId()])->one();
        $profile = Profile::find()->where(['user_id' => Yii::$app->user->getId()])->one();

        $special = UserSpecialization::find()->select('*, department.name dname, specialization.name name')->join('LEFT OUTER JOIN', 'specialization', '`specialization`.`id` = `user_specialization`.`specialization_id`')->join('LEFT JOIN', 'department', '`specialization`.`department_id` = `department`.`id`')->where(['user_id' => Yii::$app->user->getId()])->all();

        $idea = Idea::find()->select('*, industry.name iname, idea.name ideaname')->join('LEFT JOIN', 'industry', '`idea`.industry_id = `industry`.`id`')->where(['user_id'=>Yii::$app->user->getId()])->one();

        $test_result = TestUser::find()->select('*, test_user_result.points points, test_result.name result')->join('LEFT JOIN', 'test_user_result', '`test_user_result`.`test_user_id` = `test_user`.`id`')->join('LEFT JOIN', 'test_result', '`test_result`.`id` = `test_user_result`.`result_id`')->where(['user_id' => Yii::$app->user->getId()])->all();

        $languages = Language::find()->where(['user_id' => Yii::$app->user->getId()])->one();

        $skills = Skills::find()->where(['user_id' => Yii::$app->user->getId()])->one();

        return $this->render('index', ['user'=>$user, 'profile'=>$profile, 'special'=>$special, 'idea'=>$idea, 'test_result'=>$test_result, 'language'=>$languages, 'skills'=>$skills]);
    }
}