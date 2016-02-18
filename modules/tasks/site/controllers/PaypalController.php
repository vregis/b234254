<?php
namespace modules\tasks\site\controllers;

use Yii;
use yii\web\Controller;
use ak\Paypal;
use modules\tasks\models\DelegateTask;

class PaypalController extends Controller {

    public function actionIndex(){
        $pp = new Paypal();
        $check = $pp->createPayout();
        var_dump($check->items[0]->errors);

        //$this->layout = false;
      // return $this->render('index');
    }

    public function actionCreatepayment(){

        $pp = new Paypal();
        var_dump($pp->createPay($_POST));
    }


    public function actionApprovepay(){
        $pp = new Paypal();
        $pp->approvePay($_GET);
    }

    public function actionCreatepayout(){
        $response['error'] = false;
        $pp = new Paypal();
        $check = $pp->createPayout($_POST);

        if($check->items[0]->errors){
            $response['error'] = true;
            $response['msg'] = $check->items[0]->errors->message;
        }else{
            $response['msg'] = 'Payment successfully';
        }

        return(json_encode($response));
    }


    public function actionClosewindow(){
        $this->layout = false;
        return $this->render('closewindow');
    }

    public function actionPaypalok(){
        $this->layout = false;
        return $this->render('paypalok');
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
?>