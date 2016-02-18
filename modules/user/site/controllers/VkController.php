<?php

namespace modules\user\site\controllers;

use modules\core\site\base\Controller;
use Yii;
use yii\filters\AccessControl;
use modules\user\models\User;

class VkController extends Controller
{
    public $layout = "@modules/user/layouts/login";

    public function behaviors() {
        return array(
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', ],
                        'roles' => ['?', '@']
                    ],
                ]
            ],
            'eauth' => array(
                // required to disable csrf validation on OpenID requests
                'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                'only' => array('login'),
            ),
        );
    }

    public function actionLogin()
    {

        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        //vd($serviceName);
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

            try {
                if ($eauth->authenticate()) {
//                  var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;

                    $identity = User::findByEAuth($eauth);
                    Yii::$app->getUser()->login($identity);

                    // special redirect with closing popup window
                    $eauth->redirect();
                } else {
                    // close popup window and redirect to cancelUrl
                    $eauth->cancel();
                }
            } catch (\nodge\eauth\ErrorException $e) {
                // save error to show it later
                Yii::$app->getSession()->setFlash('error', 'EAuthException: ' . $e->getMessage());

                // close popup window and redirect to cancelUrl
//              $eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }
        }

        // default authorization code through login/password ..
        $this->goBack();
    }
}