<?php

namespace modules\user\site\controllers;

use modules\core\helpers\TextHelper;
use modules\user\models\Profile;
use modules\user\models\User;
use modules\core\site\base\Controller;
use modules\user\site\helpers\SteamHelper;
use nodge\eauth\ErrorException;
use nodge\eauth\openid\ControllerBehavior;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;

/**
 * Контроллер для Steam
 *
 * @property \frontend\modules\user\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
class SteamController extends Controller
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
                        'actions' => ['login', 'connect', 'add-friends'],
                        'roles' => ['?', '@']
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
     */
    public function actionLogin()
    {
        if (!$this->isGuest) {

            return $this->onlyGuest();
        }

        if (!$this->module->onlySteam) {
      // перенаправить на обычную регистрацию
            //vd(1);
            return $this->redirect('/user/security/login');

        }

        $messages = [];
        $service = 'st';
        /** @var \nodge\eauth\EAuth $eauthCom */
        $eauthCom = Yii::$app->eauth;
        $eauth = $eauthCom->getIdentity($service);
        $eauth->setRedirectUrl(Yii::$app->urlManager->createUrl(['/user/steam/login']));
        $eauth->setCancelUrl(Yii::$app->urlManager->createUrl(['/user/security/login']));

        try {
            // авторизируем пользователя через steam
            if (!$eauth->authenticate()) {
                $eauth->cancel();
            }

            $clientId = SteamHelper::getIdFromUrl($eauth->getId());
            if (empty($clientId)) {
                $eauth->cancel();
            }

            // проверяем аккаунт (user_social)
            /** @var \common\modules\user\models\SocialAccount $account */
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
                if (!$account->save(false)) {
                    $eauth->cancel();
                }
            }

            // проверяем, не присоединена ли уже соц. сеть у пользователя
            /** @var User $user */
            $user = $account->user;

            // заполняем профиль данными из соц. сети
            $info = SteamHelper::getUserInfoById($account->client_id);

            // если нет, регистрируем пользователя
            if ($user === null) {

                $user = $this->module->manager->createUser();
                $user->scenario = 'connect';

                // временный username
                $user->username = uniqid();

                if ($user->create()) {

                    // username
                    $newUsername = str_replace('<', ' ', $info['personaname']);
                    $newUsername = str_replace('>', ' ', $newUsername);
                    $newUsername = str_replace('  ', ' ', $newUsername);
                    $newUsername = TextHelper::filterString($newUsername);

                    $user->username = empty($newUsername) ? $user->username : $newUsername;
                    $usernameExists = $this->module->manager->findUserByUsername($user->username);
                    // если такой ник существует, добавляем к нику ID пользователя
                    if ($usernameExists !== null) {
                        $user->username = $user->username . $user->id;
                    }

                    $user->save(true, ['username']);

                    $account->user_id = $user->id;
                    $account->save(false, ['user_id']);

                    $profile = $this->module->manager->findProfileByUserId($user->id);

                    // steam_id
                    $steamIdExists = Profile::find()
                        ->where('steam_id=:steam_id')
                        ->addParams([':steam_id' => (string)$account->client_id])
                        ->exists();
                    if (!$steamIdExists) {
                        $profile->steam_id = (string)$account->client_id;
                        $profile->updateAttributes(['steam_id']);
                    } else {
                        Yii::error(Yii::t('core', 'Дубликат steam_id: {steam_id}',
                            ['steam_id' => (string)$account->client_id]));
                    }

                    if (empty($profile->steam_id)) {
                        $user->delete();
                        Yii::$app->session->setFlash('error', Yii::t('user', 'Не удалось получить Steam ID'));
                        return $this->goHome();
                    }

                    // @todo убрать
                    $user->balance = 50;
                    $user->updateAttributes(['balance']);
                    $messages[] = Yii::t('user', 'Вы успешно зарегистрировались на сайте');
                } else {
                    $account->delete();
                    Yii::$app->session->setFlash('error', Yii::t('user', 'Не удалось сохранить пользователя'));
                    return $this->goHome();
                }

            } else {
                // пользователь заблокирован
                if ($user->getIsBlocked()) {
                    Yii::$app->session->setFlash('error', Yii::t('user', 'Ваш аккаунт заблокирован'));
                    return $this->goHome();
                }

                // проверяем, не изменился ли логин на стиме
                if ($user->changeUsernameFromSteam($info['personaname'])) {
                    $messages[] = Yii::t('user', 'Ваш ник был изменен');
                }
            }

            // обновляем аватар со стима, если его еще нет,
            // либо если текущий аватар был загружен со стима
            $profile = $user->profile;
            if ($profile->avatar_from_steam == 1 || !$user->hasAvatar()) {
                if (SteamHelper::copyAvatar($user->id, $info['avatarfull'])) {
                    $profile->avatar_from_steam = 1;
                    if ($profile->updateAttributes(['avatar_from_steam'])) {
                        $messages[] = Yii::t('user', 'Ваш аватар был изменен');
                    }
                }
            }

            if (!empty($messages)) {
                $messages = implode(Html::tag('br'), $messages);
                Yii::$app->session->setFlash('success', $messages);
            }

            // все ок, авторизируем
            Yii::$app->user->login($user, $this->module->rememberFor);
            Yii::$app->session->removeAllFlashes();
            $eauth->redirect();

        } catch (ErrorException $e) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Произошла ошибка') . ': ' . $e->getMessage());
            $eauth->cancel();
        }
        return $this->goHome();
    }

    /**
     * Страница подключения аккаунта к Steam
     *
     * @return string|Response
     */
    public function actionConnect()
    {
        /** @var \common\modules\user\models\User $identity */
        $identity = Yii::$app->user->identity;
        $steamConnected = empty($identity->profile->steam_id) ? false : true;
        if ($steamConnected) {
            return $this->goHome();
        }
        return $this->render('connect');
    }

    /**
     * Отправка заявок на добавление в друзья
     *
     * @return array|Response
     */
    public function actionAddFriends()
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = ['url' => '', 'message' => ''];

        if ($this->getIsGuest()) {
            return $this->onlyUser();
        }

        if (!$this->module->onlySteam) {
            $data['url'] = Yii::$app->homeUrl;
            return $data;
        }

        $user_id = Yii::$app->user->id;

        $profile = $this->module->manager->findProfileByUserId($user_id);

        // синхронизация друзей
        $friendsSteamIds = SteamHelper::getUserFriends($profile->steam_id);

        $friends = $profile->find()
            ->where(['steam_id' => $friendsSteamIds])
            ->all();

        $sentCount = 0;
        /** @var Profile $friend */
        foreach ($friends as $friend) {
            $exists = Contact::find()
                ->where('user_id=:user_id AND friend_id=:friend_id')
                ->addParams([':user_id' => $profile->user_id, ':friend_id' => $friend->user_id])
                ->one();
            if ($exists === null) {
                $contact = new Contact();
                $contact->user_id = $profile->user_id;
                $contact->friend_id = $friend->user_id;
                $contact->offer_status = 0;
                $contact->deleted_status = 0;
                if ($contact->save()) {
                    $msg = Yii::t(
                        'user',
                        'Пользователь {username} отправил вам приглашение стать другом.{br}{link}',
                        [
                            'username' => Html::encode($profile->user->username),
                            'br' => Html::tag('br'),
                            'link' => Html::a(Yii::t('user', 'Перейти к заявкам'),
                                ['/contact/default/ask-from-friend'], ['class' => 'button-green'])
                        ]
                    );
                    Message::sendSystemMessage($friend->user_id, Yii::t('user', 'Приглашение стать другом'), $msg);
                    $sentCount++;
                }
            }
        }
        if ($sentCount > 0) {
            $data['message'] = Yii::t(
                'user',
                'Заявки на добавление в друзья успешно отправлены ({count})',
                ['count' => $sentCount]
            );
        }
        return $data;
    }
}