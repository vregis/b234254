<?php

namespace modules\user\site\controllers;

use modules\core\helpers\TextHelper;
use modules\core\site\comments\Comments;
use modules\user\models\Profile;
use modules\user\models\ProfileCommentary;
use modules\user\models\User;
use modules\core\site\base\Controller;
use modules\user\site\helpers\SocialHelper;
use nodge\eauth\ErrorException;
use nodge\eauth\openid\ControllerBehavior;
use tmn\oauth\tmhOAuth;
use twitter\ouath\TwitterAPIExchange;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Авторизация через социальные сети
 *
 * @property \frontend\modules\user\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
class SocialController extends Controller
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
                        'actions' => ['login', 'connect', 'showsocial', 'shared-profile'],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['shared-profile', 'add-comment', 'pagination'],
                        'roles' => ['@']
                    ],
                ]
            ],
            // eauth (отключает CSRF для OpenID)
            'eauth' => [
                'class' => ControllerBehavior::className(),
                'only' => ['login'],
            ],
        ];
    }

    /**
     * Авторизация через соц. сеть
     *
     * @param $service
     * @return bool
     * @throws ErrorException
     */


    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionLogin($service)
    {
		
        if (empty($service)) {
            return $this->goHome();
        }

        /** @var \nodge\eauth\EAuth $eauthCom */
        $eauthCom = Yii::$app->eauth;
        $eauth = $eauthCom->getIdentity($service);
        $eauth->setRedirectUrl(Yii::$app->user->returnUrl);
        $eauth->setCancelUrl(Yii::$app->urlManager->createUrl(['/user/security/login']));
        try {
            // авторизируем пользователя через соц. сеть
            if (!$eauth->authenticate()) {
                $eauth->cancel(); // закрывает окно и редиректит на cancelUrl
            }

            $clientId = $eauth->getId();
            if (empty($clientId)) {
                $eauth->cancel();
            }

            // проверяем аккаунт (user_social_account)
            $account = $this->module->manager->findSocialAccount($service, $clientId);

            // если аккаунта нет в БД - создаем новый
            if ($account === null) {

                $account = $this->module->manager->createSocialAccount(
                    [
                        'provider' => $service,
                        'client_id' => $clientId,
                        'data' => Json::encode($eauth->getAttributes())
                    ]
                );
                $account->save(false);
            }

            // проверяем, не присоединена ли уже соц. сеть у пользователя
            /** @var User $user */
            $user = $account->user;
            // если нет, устанавливаем redirectUrl в на страницу завершения подключения соц. сети
            if ($user === null) {
                $eauth->setRedirectUrl(
                    Url::to(
                        [
                            '/user/social/connect',
                            'provider' => $account->provider,
                            'client_id' => $account->client_id,
                        ]
                    )
                );
            } else {
                // пользователь еще не подтвердил E-mail
                $confirmRequired = $this->module->enableConfirmation && !$this->module->enableUnconfirmedLogin;
                if ($confirmRequired && !$user->getIsConfirmed()) {
                    //Yii::$app->session->setFlash('error', Yii::t('yii', 'Вы должны подтвердить свой E-mail.'));
                    return $this->goHome();
                }

                // пользователь заблокирован
                if ($user->getIsBlocked()) {
                    Yii::$app->session->setFlash('error', Yii::t('user', 'Ваш аккаунт заблокирован'));
                    return $this->goHome();
                }

                // все ок, авторизируем

                Yii::$app->user->login($user, $this->module->rememberFor);
            }

            $eauth->redirect();

        } catch (ErrorException $e) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Произошла ошибка') . ': ' . $e->getMessage());
            $eauth->cancel();
        }
        return true;
    }

    /**
     * Завершение подключения соц. сети
     *
     * @param $provider
     * @param $client_id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionConnect($provider, $client_id)
    {
        $this->layout = '@modules/user/layouts/register';
        $provider = TextHelper::filterString($provider);
        $client_id = TextHelper::filterString($client_id);

        $account = $this->module->manager->findSocialAccount($provider, $client_id);
		
        if ($account === null) {
            throw new NotFoundHttpException(Yii::t('user', 'Не удалось получить информацию об аккаунте'));
        }



        $model = $this->module->manager->createUser();
        $model->scenario = 'connect';

        $document = $this->renderPartial('@modules/user/site/views/registration/document', [], true);

        // заполняем профиль данными из соц. сети

        $profileData = SocialHelper::normalizeProfileData($account->provider, $account->data);
        $service = strtolower($profileData['service']);
        if (!empty($profileData['email'])) {
            $model->email = $profileData['email'];
        }
        if (!empty($profileData['name'])) {
            $model->username = $profileData['name'];
        }

        if ($model->load(Yii::$app->request->post()) && $model->create()) {

            $account->user_id = $model->id;

            $account->save(false);

            $message = '';
            // заполняем пустые поля профиля данными, полученными из соц. сетей
            Profile::fillFromSocial($account);

            $message .= Yii::t('user', 'Вы успешно зарегистрировались на сайте.');
            $message .= Html::tag('br');
            $message .= Yii::t('user', 'На указанный E-mail отправлено письмо с данными учетной записи.');
            $message .= Html::tag('br');
            $message .= Yii::t('user', 'Для завершения регистрации, перейдите по ссылке в письме.');

            Yii::$app->session->setFlash('success', $message);

            return $this->redirect(Url::to(['social/login','service'=>$service]));
        }

        return $this->render('connect', ['model' => $model, 'account' => $account, 'document' => $document]);
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

    public function actionShareProfileFb(){
        die('asdhfkasdj');
    }

    public function actionSharedProfile($id){

        $profile = Profile::find()
            ->select('user_profile.*, title_en as country_title, user.email as email')
            ->join('LEFT JOIN', 'geo_country', 'user_profile.country_id = geo_country.id')
            ->join('LEFT JOIN', 'user', 'user.id = user_profile.user_id')
            ->where(['user_profile.user_id' => $id])
            ->one();

        $com = ProfileCommentary::find()
            ->select('profile_commentary.*, user_profile.avatar as ava, user_profile.first_name as fn, user_profile.last_name as ln, user_profile.user_id as uid')
            ->join('LEFT JOIN', 'user_profile', 'user_profile.user_id = profile_commentary.sender_id')
            ->where(['profile_commentary.user_id' => $id])
            ->orderBy(['profile_commentary.time' => SORT_DESC])->limit(5)
            ->all();
        $new_com = new Comments();
        $count = $new_com->getCount($_GET['id']);

        $comments = $this->renderPartial('_blocks/comments', ['comments' => $com, 'count'=>$count, 'user_id' => $_GET['id']]);


        $this->layout = false;
        if($profile){
            return $this->render('shared_profile', ['model' => $profile, 'comments' => $comments, 'count' => $count]);
        }else{
            throw new \yii\web\NotFoundHttpException();
        }
    }

    public function actionAddComment(){
        $comment = new Comments();
        $comment->addComment($_POST['text'], $_POST['user_id']);
        $count = $comment->getCount($_POST['user_id']);
        $response['html'] = $comment->render($_POST['user_id']);
        $response['count'] = $count;
        return json_encode($response);
    }

    public function actionPagination(){
        $comment = new Comments();
        $response['html'] = $comment->render($_POST['user_id'], $_POST['page']);
        return json_encode($response);
    }


}