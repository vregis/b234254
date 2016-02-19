<?php

namespace modules\user\site\controllers;

use modules\core\site\base\Controller;
use modules\user\helpers\PasswordHelper;
use modules\user\models\forms\ForgottpassForm;
use modules\user\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use modules\tests\site\controllers\DefaultController;

/**
 * Аутентификация пользователя
 *
 * @property \frontend\modules\user\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
class SecurityController extends Controller
{
    public $layout = "@modules/user/layouts/login";
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'logout', 'ajaxlogin', 'forgot-password', 'set-mail-from-pass', 'sendforgotpass', 'login-from-main-page'],
                        // разрешаем всем, но проверяем в экшнах
                        'roles' => ['?', '@']
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    /*'logout'  => ['post']*/
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Авторизация пользователя
     *
     * @return array|string|Response
     */
    public function actionLogin()
    {
        if(Yii::$app->getModule('user')->onlySteam){
            return $this->redirect('/user/steam/login');
        }

        $model = $this->module->manager->createLoginForm();

        if ($model->load(Yii::$app->request->post())) {

            // успешная авторизация
            if ($model->validate() && $model->login()) {
                // AJAX
                if ($this->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    //return ['url' => Url::previous()];
                    return $this->redirect('/departments/business');

                } else // обычный запрос
                {
                    return $this->redirect(Url::previous());
                }
                // не удалось авторизироваться
            } else {
                if ($this->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return $model->getFirstErrors();
                }
            }
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Выход
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        if ($this->getIsGuest()) {
            return $this->onlyUser();
        }
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionAjaxlogin(){

        $_POST['LoginForm'] = $_POST;
        $response = [];
        $response['error'] = false;
        $model = $this->module->manager->createLoginForm();
        if ($model->load(Yii::$app->request->post())) {

            // успешная авторизация
            if ($model->validate() && $model->login()) {
                // AJAX
                if ($this->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                } else // обычный запрос
                {
                    //return $this->redirect(Url::toRoute('/tests/start'));
                }
                // не удалось авторизироваться
            } else {
                if ($this->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $response['error'] = true;
                    $response['msg'] = $model->getFirstErrors();
                }
            }
        }
         die(json_encode($response));
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

    public function actionForgotPassword(){

        if(isset($_POST['ForgottpassForm']['password']) && !empty($_POST['ForgottpassForm']['password']) && isset($_POST['token']) && !empty($_POST['token'])){
            $pass = User::find()->where(['auth_key' => $_POST['token']])->one();
            if($pass){
                $pass->password_hash = PasswordHelper::hash($_POST['ForgottpassForm']['password']);
                if($pass->save()){
                    return $this->redirect('/user/login');
                }
            }
        }else {
            $model = new ForgottpassForm();
            return $this->render('forgotpass', ['model' => $model]);
        }
    }

    public function actionSetMailFromPass(){
        return $this->render('setmail');
    }

    public function actionSendforgotpass(){

        $response['error'] = false;
        $response['msg'] = 'Check your email to restore your password';

        if(isset($_POST['email']) && !empty($_POST['email'])){
            $user = User::find()->where(['email' => $_POST['email']])->one();
            if($user){
                Yii::$app->mailer->compose()
                    ->setFrom(['support@bigsbusiness.com' => 'Bigsbusiness'])
                    ->setTo($_POST['email'])
                    ->setSubject('Password recovery')
                    ->setHtmlBody('To change your password, go to the link <a href="http://'.$_SERVER['HTTP_HOST'].'/user/security/forgot-password?token='.$user->auth_key.'">http://'.$_SERVER['HTTP_HOST'].'/user/security/forgot-password?token='.$user->auth_key.'</a>')
                    ->send();
            }else{
                $response['error'] = true;
                $response['msg'] = 'User with this email is not found';
            }

        }else{
            $response['error'] = true;
            $response['msg'] = 'Something wrong. Please try again';
        }

        return json_encode($response);

    }

    public function actionLoginFromMainPage()
    {
        if(Yii::$app->getModule('user')->onlySteam){
            return $this->redirect('/user/steam/login');
        }

        $model = $this->module->manager->createLoginForm();

        if ($model->load(Yii::$app->request->post())) {

            // успешная авторизация
            if ($model->validate() && $model->login()) {
                // AJAX
                if ($this->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['url' => Url::previous()];
                } else // обычный запрос
                {
                    return $this->redirect('/departments/business');
                }
                // не удалось авторизироваться
            } else {
                if ($this->isAjax) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return $model->getFirstErrors();
                }
            }
        }

        return $this->render('login', ['model' => $model]);
    }



}