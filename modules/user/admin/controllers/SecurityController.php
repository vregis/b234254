<?php

namespace modules\user\admin\controllers;

use modules\core\admin\base\Controller;
use Yii;

/**
 * Аутентификация пользователя
 *
 * @author MrArthur
 * @since 1.0.0
 */
class SecurityController extends Controller
{
    public $layout = "@modules/user/admin/views/layouts/login";
		
    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // разрешаем гостю авторизироваться
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['login'],
            'roles' => ['?', '@']
        ];
        // и разрешаем юзеру выйти
        $behaviors['access']['rules'][] = [
            'allow' => true,
            'actions' => ['logout'],
            'roles' => ['@']
        ];
        return $behaviors;
    }

    /**
     * Вход
     *
     * @return string|\yii\web\Response
     */
	public function actionLogin()
    {

        if (!$this->isGuest) {
            return $this->onlyGuest();
        }

        $model = $this->module->manager->createLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->login()) {
            return $this->goBack();
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
        Yii::$app->user->logout();
        header('Location: /');
        die();
        return $this->goHome();
    }
}
