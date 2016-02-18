<?php

namespace modules\user\site\controllers;

use modules\core\helpers\TextHelper;
use modules\user\models\forms\CompleteForm;
use modules\user\models\Token;
use modules\user\models\User;
use modules\core\site\base\Controller;
use modules\user\site\helpers\SteamHelper;
use nodge\eauth\openid\ControllerBehavior;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use modules\tests\site\controllers\DefaultController;


/**
 * Controller that manages user registration process.
 *
 * @property \frontend\modules\user\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
class RegistrationController extends Controller
{
    //public $layout = "@modules/user/layouts/login";
	/** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['register', 'connect', 'resend', 'reg', 'regvk', 'social'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['complete', 'complete-default'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['confirm', 'confirm-common'],
                        'roles' => ['?', '@']
                    ],
                    'eauth' => [
                        'class' => ControllerBehavior::className(),
                        'only' => ['social'],
                    ],
                ]
            ],
        ];
    }


    /* KOstya
     * Регистрация через логин и пароль
     */

    /* KOstya
  * Регистрация через VK
  */
    public function actionRegvk()
    {
        vd(Yii::$app->request->post('model'));
        $model = $this->module->manager->createRegistrationForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->validate();
            vd($model->getErrors());
            if ($model->validate() && $model->register()) {
                Yii::$app->session->setFlash('success', Yii::t('user', 'На ваш электронный адрес отправлена инструкция для входа'));
                return $this->goHome();
            }
        }
        return $this->render('register', ['model' => $model]);
    }


    /*
     * Регистрация
     *
     * @return array|string|Response
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionRegister()
    {


        //vd(1);
//        if (!$this->isAjax) {
//            return $this->onlyAjax();
//        }

//        if (!$this->module->enableRegistration) {
//            throw new NotFoundHttpException;
//        }

        //Yii::$app->response->format = Response::FORMAT_JSON;





        $md = new DefaultController('default', Yii::$app);



        $test = $md->actionStatictest();

        $start = $md->actionStartpage();


        //$this->layout = '@modules/user/layouts/login';
        $model = $this->module->manager->createRegistrationForm();
//vd($model);
        if ($model->load(Yii::$app->request->post())) {
            //$model->validate();
            //vd($model->getErrors());
            if ($model->validate() && $model->register()) {
                Yii::$app->session->setFlash('confirm_link', Yii::t('user', 'На ваш электронный адрес отправлена инструкция для входа'));
                //return $this->goHome();
                return $this->redirect('/user/login');

            }else{
                $result = [];
                $i=0;
                //$model->validate();
                foreach ($model->getFirstErrors() as $name => $message) {

                    $i++;
                    if($i > 1)//{
                        break;
                    //}
                    $result['error'] = $message;
                }
                //return $this->refresh();
            }
        }
        $document = $this->renderPartial('document', [], true);
        $this->layout = '@modules/user/layouts/register';
        return $this->render('register', ['model' => $model, 'test' => $test, 'start'=>$start, 'document'=>$document]);
    }

    /**
     * Подключение аккаунта к соц. сети
     *
     * @param $account_id
     * @return string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionConnect($account_id)
    {
        $account_id = TextHelper::filterString($account_id);

        $account = $this->module->manager->findSocialAccountById($account_id);

        if ($account === null || $account->getIsConnected()) {
            throw new NotFoundHttpException(Yii::t('user', 'Аккаунт не найден, либо уже подключен'));
        }

        // $this->module->enableConfirmation = false;

        $model = $this->module->manager->createUser(['scenario' => 'connect']);
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            $account->user_id = $model->id;
            $account->save(false);
            Yii::$app->user->login($model, $this->module->rememberFor);
            return $this->goBack();
        }

        return $this->render('connect', ['model' => $model, 'account' => $account]);
    }

    /**
     * Активация аккаунта
     *
     * @param $id
     * @param $code
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionConfirm($id, $code)
    {
        $id = (int)$id;
        $code = TextHelper::filterString($code);

        $user = $this->module->manager->findUserById($id);

        if ($user === null || !$this->module->enableConfirmation) {
            throw new NotFoundHttpException;
        }

        if ($user->attemptConfirmation($code)) {
            Yii::$app->user->login($user);
            $message = Yii::t('user', 'Вы успешно подтвердили E-mail');
            // синхронизация друзей
            $friendsSteamIds = SteamHelper::getUserFriends($user->profile->steam_id);

            $friendsCount = $user->profile->find()
                ->where(['steam_id' => $friendsSteamIds])
                ->count();

            if ($friendsCount > 0) {
                $message .= Html::tag('br');
                $message .= Yii::t(
                    'user',
                    'На сайте найдено {count} ваших друзей из Steam.',
                    ['count' => $friendsCount]
                );
                $message .= Html::tag('br');
                $message .= Html::beginTag(
                    'a',
                    [
                        'href' => 'javascript:void(0)',
                        'id' => 'add-steam-friends',
                        'data-url' => Url::to(['/user/steam/add-friends'])
                    ]
                );
                $message .= Yii::t(
                    'user',
                    'Нажмите на эту ссылку, чтобы отправить им заявки на добавление в друзья.'
                );
                $message .= Html::endTag('a');
            }
            Yii::$app->session->setFlash('success', $message);
        } else {
            $message = Yii::t('user', 'К сожалению ваша ссылка для активации аккаунта недействительна');
            Yii::$app->session->setFlash('error', $message);
            return $this->goHome();
        }
        return $user->profile->getIsComplete() ? $this->goHome() : $this->redirect(['/user/registration/complete']);
    }

    /**
     * Активация Обычного аккаунта
     *
     * @param $id
     * @param $code
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionConfirmCommon()
    {

        //$hash = Yii::$app->request->get('hash');
        $key = Yii::$app->request->get('token');
        //vd( $key);
        $model = User::find()->where(['auth_key' => $key])->one();
        if ($model) {
            if($model->confirmed_at == 0) {
                // регистрирую
                $model->confirmed_at = time();
                $model->updateAttributes(['confirmed_at']);
                //Yii::$app->user->login($model);
                $message = Yii::t('user', 'Вы успешно подтвердили E-mail');
                Yii::$app->session->setFlash('verified', $message);
            }else{
                $message = Yii::t('user', 'ужжжже');
                Yii::$app->session->setFlash('already', $message);
            }
        } else {
            // не регистрирую
            $message = Yii::t('user', 'К сожалению ваша ссылка для активации аккаунта недействительна');
        }
        //if($_SERVER['REQUEST_URI'] == '/user/login') {  // not show message in another page. We find this message in profile page;

       // }
        if($model && !empty($model->email)){
            return $this->redirect('/user/login?email='.$model->email.'');
        }else {
            return $this->redirect('/user/login');
        }
    }

    /**
     * Повторная отправка инструкций
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionResend()
    {
        if (!$this->module->enableConfirmation) {
            throw new NotFoundHttpException;
        }

        $model = $this->module->manager->createResendForm();

        if ($model->load(Yii::$app->request->post()) && $model->resend()) {

            $message = Yii::t('user', 'Письмо успешно отправлено на указанный E-mail.');
            $message .= Html::tag('br') . Yii::t(
                    'user',
                    'Пожалуйста, проверьте ваш почтовый ящик и нажмите на ссылку, чтобы завершить регистрацию.'
                );
            Yii::$app->session->setFlash('success', $message);

            return $this->goHome();
        }

        return $this->render('resend', ['model' => $model]);
    }

    /**
     * Завершение регистрации пользователя
     *
     * Пользователь попадает на данную страницу, если у него не заполнены обязательные поля,
     * которых не было в форме регистрации
     */
    public function actionComplete()
    {
        $user_id = (int)Yii::$app->user->id;

        $profile = $this->module->manager->findProfileByUserId($user_id);
        if ($profile === null) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Профиль не найден'));
            return $this->goHome();
        }

        // регистрация уже завершена
        if ($profile->getIsComplete()) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Вы уже завершили регистрацию'));
            return $this->goHome();
        }

        $model = new CompleteForm();

        // заполняем форму, если уже что-то было заполнено
        $model->birth_day = $profile->birth_day;
        $model->birth_month = $profile->birth_month;
        $model->birth_year = $profile->birth_year;
        $model->city_id = $profile->city_id;
        $model->city_title = $profile->city_title;
        $model->country_title = $profile->country_title;
        $model->email = $profile->user->email;

        $model->scenario = 'steam';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $profile->scenario = 'complete';

            $profile->attributes = $model->attributes;

            $profile->birth_year = $model->birth_year;
            $profile->birth_month = $model->birth_month;
            $profile->birth_day = $model->birth_day;

            if ($profile->save()) {
                // email при регистрации через Steam
                $user = $profile->user;
                $user->email = $model->email;
                $user->scenario = 'steamComplete';
                $user->update(true, ['email']);
                // подтверждение почты
                if ($this->module->enableConfirmation && !$user->getIsConfirmed()) {
                    $user->refresh();
                    $token = $this->module->manager->createToken(['type' => Token::TYPE_CONFIRMATION]);
                    $token->link('user', $user);
                    $this->module->mailer->sendConfirmationMessage($user, $token);
                } else {
                    $user->email = $model->email;
                    $user->unconfirmed_email = null;
                    $user->confirmed_at = time();
                    $user->save(false);
                    Yii::info('Пользователь ' . $user->id . ' активирован');
                }

                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('user', 'Вы успешно завершили регистрацию.'
                    )
                );
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('user', 'Не удалось сохранить изменения'));
                return $this->refresh();
            }
        }

        return $this->render('complete', ['model' => $model]);
    }


    /**
     * Завершение регистрации пользователя зашел через логин и пароль
     *
     * Пользователь попадает на данную страницу, если у него не заполнены обязательные поля,
     * которых не было в форме регистрации
     */
    public function actionCompleteDefault()
    {

        $user_id = (int)Yii::$app->user->id;
        //vd($user_id);
        $profile = $this->module->manager->findProfileByUserId($user_id);
        //vd($profile);
        if ($profile === null) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Профиль не найден'));
            return $this->goHome();
        }
//vd($profile);
        // регистрация уже завершена
        if ($profile->getIsComplete()) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Вы уже завершили регистрацию'));
            return $this->goHome();
        }
        // vd(22);

        $model = new CompleteForm();

        // заполняем форму, если уже что-то было заполнено
        $model->birth_day = $profile->birth_day;
        $model->birth_month = $profile->birth_month;
        $model->birth_year = $profile->birth_year;
        $model->city_id = $profile->city_id;
        $model->city_title = $profile->city_title;
        $model->country_title = $profile->country_title;
        $model->email = $profile->user->email;
        //vd($model);

        // vd(Yii::$app->request->post());

        //$model->load(Yii::$app->request->post());


        $model->scenario = 'default';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //$model->validate();
            //vd($model->getErrors());

            $profile->scenario = 'complete';

            $profile->attributes = $model->attributes;

            $profile->birth_year = $model->birth_year;
            $profile->birth_month = $model->birth_month;
            $profile->birth_day = $model->birth_day;
            //vd($profile);
            //$profile->validate();
            //vd($profile->getErrors());
            if ($profile->save()) {
                $user = $profile->user;

                //vd(1);
                // подтверждение почты
                if ($this->module->enableConfirmation && !$user->getIsConfirmed()) {
                    $user->refresh();
                    $token = $this->module->manager->createToken(['type' => Token::TYPE_CONFIRMATION]);
                    $token->link('user', $user);
                    $this->module->mailer->sendConfirmationMessage($user, $token);
                } else {
                    $user->email = $model->email;
                    $user->unconfirmed_email = null;
                    $user->confirmed_at = time();
                    $user->save(false);
                    Yii::info('Пользователь ' . $user->id . ' активирован');
                }

                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('user', 'Вы успешно завершили регистрацию.'
                    )
                );
                //vd(3);
                return $this->goHome();
            } else {
                //vd(2);
                Yii::$app->session->setFlash('error', Yii::t('user', 'Не удалось сохранить изменения'));
                return $this->refresh();
            }
        }

        return $this->render('complete', ['model' => $model]);
    }

    public function actionSocial()
    {
        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        //vd($serviceName);
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('/core/index'));
			
            try {
                if ($eauth->authenticate()) {
                    //var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;

                    $UserIdentity = $eauth->getAttributes();
                    //vd($UserIdentity);

                    $model = $this->module->manager->createLoginForm();
                    if($serviceName == 'vkontakte') {
                        $model->email = 'vk_' . $UserIdentity['id'] . '@justtoo.ru';
                    }
                    else if($serviceName == 'fb') {
                        $model->email = 'fb_' . $UserIdentity['id'] . '@justtoo.ru';
                    }
                    $model->password = '23sdrtgHHgds23656vk';
                    if($serviceName == 'vkontakte') {
                        $avatar = $UserIdentity['photo_medium'];
                    }
                    else if($serviceName == 'fb') {
                        $avatar = 'http://graph.facebook.com/' . $UserIdentity['id'] . '/picture';
                    }
                    //vd($avatar);
                    // Зарегистрировать
                    $modelR = $this->module->manager->createRegistrationForm(['scenario' => 'social']);

                    //$modelR->scenario = 'vk';
                    $modelR->username = $UserIdentity['name'];
                    $modelR->email = $model->email;
                    $modelR->password = $model->password;
                    $modelR->password_repeat = $model->password;
                    $modelR->agree = 1;
                    $modelR->im18years = 1;

                    //$modelR->validate();
                    //vd($modelR->getErrors());

                    // ToDo если уже существует то редарект
                    $userDublicate = User::find()->where(['email' => $model->email])->one();
                    if ($userDublicate){
                        //vd(2);
                        Yii::$app->user->login($userDublicate);
//                        $concursId = CompetitionContent::getFistConcursId();
                        return $this->redirect('/');
                    }else{

//                        if ($modelR->validate() && $modelR->registerSocial($avatar)) {
//                            $concursId = CompetitionContent::getFistConcursId();
                            return $this->redirect('/');
//                        }

                    }
                    $this->redirect('/');


                    $identity = User::findByEAuth($eauth);
                    vd($identity);
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
                $eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }
        }

        // default authorization code through login/password ..
        $this->goBack();
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



}