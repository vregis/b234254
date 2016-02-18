<?php

namespace modules\tasks\site\controllers;

use Faker\Provider\DateTime;
use modules\core\site\base\Controller;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use Yii;
use yii\filters\AccessControl;
use \modules\tasks\site\stripe\Payment;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class StripeController extends Controller
{

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
                            'pay',
                            'createtransfer',
                        ],
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
        {
            return $this->render('index');
        }

    public function actionPay(){

        $stripe = new Payment(array());
        $stripe->createCharge();

    }

    public function actionCreatetransfer(){

        $stripe = new Payment(array());
        $stripe->createTransfer();

    }
}