<?php

namespace modules\core\site\base;

use modules\core\base\Controller as CommonController;
use modules\core\helpers\BetaHelper;
use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

/**
 * Базовый контроллер для всех контроллеров фронтенда
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Controller extends CommonController
{
    public $layout = "@modules/core/site/views/layouts/main";
    /** @inheritdoc */
    public function init()
    {
        // разрешаем доступ, если в конфиге есть параметр allowAccess
        if (!isset(Yii::$app->params['allowAccess'])) {

            //заглушка на отправку в бетта тест
            $allowAccess = true;
            $route = Yii::$app->requestedRoute;

            // разрешенные всем модули
            $allowedModules = [
                'discussion',
                'page',
            ];
            if (in_array($this->module->id, $allowedModules)) {
                $allowAccess = true;
            }

            // разрешенные роуты
            $allowedRoutes = [
                'user/steam/login',
                'user/security/logout'
            ];
            if (in_array($route, $allowedRoutes)) {
                $allowAccess = true;
            }

            // проверяем пользователя в списке разрешенных
//            if (!Yii::$app->user->isGuest && BetaHelper::getIsDeveloper()) {
                $allowAccess = true;
//            }

            // запрещаем доступ к некоторым модулям
            $devModules = [
                'blog',
                'content',
                'team',
            //    'tournament',
            ];
            if (!BetaHelper::getIsDeveloper() && in_array($this->module->id, $devModules)) {
                throw new ForbiddenHttpException();
            }

            // доступ запрещен
            if (!$allowAccess) {
                if (!$this->isGuest) {
                    Yii::$app->user->logout();
                }
                if ($route != 'core/default/index') {
                    return $this->redirect(['/core/default/index']);
                }
                $this->layout = false;
                echo Yii::$app->request->isAjax
                    ? 'Бета тест завершен'
                    : $this->render('//core/views/default/beta-complete');
                Yii::$app->end();
                exit;
            }
        }

        return parent::init();
    }


    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // по умолчанию запрещаем все
                    [
                        'allow' => false,
                    ],
                ]
            ],
        ];
    }

    /** @inheritdoc */
/*    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {

            $route = Yii::$app->requestedRoute;

            if ($route !== 'page/default/view') {

                if (!$this->isGuest && !$this->isAjax && $route !== 'core/default/connect') {

                    $user = Yii::$app->user->identity;
                    // завершение регистрации
                    $p = $user->profile;
                    // если пользователь не на странице завершения регистрации, редиректим его
                    if (!$p->getIsComplete() && $route !== 'user/registration/complete' && $route !== 'page/default/view') {
                        return $this->redirect(['/user/registration/complete']);
                    } elseif (!$p->getIsComplete() && $route == 'user/registration/complete') {
                        return true;
                    }

                    if ($route !== 'core/default/index' && !$user->getIsConfirmed()) {
                        return $this->goHome();
                    }

                    // steam
                    if(Yii::$app->getModule('user')->onlySteam){
                        $steamConnected = !empty($user->profile->steam_id) ? true : false;
                        if (!$steamConnected && $route !== 'user/steam/connect') {
                            return $this->redirect(['/user/steam/connect']);
                        }
                    }else{

                    }
                    //}


                }
            }

            // записать время текущего пользователь в таблицу user_online
            Online::setOnline();

            return true;
        } else {
            return false;
        }
    }*/
}