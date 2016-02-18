<?php

namespace modules\user\site\controllers;

use modules\core\helpers\TextHelper;
use modules\user\models\Token;
use modules\core\site\base\Controller;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Класс RecoveryController
 *
 * Восстановление данных
 *
 * @property \frontend\modules\user\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
class RecoveryController extends Controller
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
                        'actions' => ['request', 'reset','form'],
                        'roles' => ['?']
                    ]
                ]
            ],
        ];
    }

    /**
     * Отправка запроса на смену пароля
     *
     * @return array|string|Response
     * @throws NotFoundHttpException
     */
    public function actionRequest()
    {

        if (!$this->module->enablePasswordRecovery) {
            throw new NotFoundHttpException;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->module->manager->createRecoveryRequestForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->sendRecoveryMessage()) {
                $message = Yii::t('user', 'Вам были отправлены инструкции по смене пароля.');
                $message .= Html::tag('br') . Yii::t(
                        'yii',
                        'Пожалуйста, проверьте ваш почтовый ящик и нажмите ссылку для восстановления пароля.'
                    );
                $message .= Html::tag('br') . Yii::t(
                        'yii',
                        'Отправка письма может занять несколько минут. Если письмо так и не пришло, вы можете запросить новое.'
                    );
                Yii::$app->session->setFlash('success', $message);
                return $this->goHome();
            } else {
                return $model->getFirstErrors();
            }
        }
        return $this->render('request', ['model' => $model]);
    }

    /**
     * Страница смены пароля, после перехода по ссылке из письма
     *
     * @param $id
     * @param $code
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionReset($id, $code)
    {
        if (!$this->module->enablePasswordRecovery) {
            throw new NotFoundHttpException;
        }

        $id = (int)$id;
        $code = TextHelper::filterString($code);

        if (($token = $this->module->manager->findToken($id, $code, Token::TYPE_RECOVERY)) === null) {
            throw new NotFoundHttpException;
        }

        try {
            $model = $this->module->manager->createRecoveryForm(['token' => $token]);
        } catch (InvalidParamException $e) {
            $message = Yii::t(
                'yii',
                'К сожалению, ссылка для сброса пароля недействительна. Возможно истек ее срок действия или она вовсе не существует. Вы можете попробовать запросить новую.'
            );

            Yii::$app->session->setFlash('success', $message);

            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {

            $message = Yii::t(
                'yii',
                'Ваш пароль был успешно изменен. Теперь вы можете авторизоваться используя новый пароль.'
            );

            Yii::$app->session->setFlash('success', $message);

            return $this->goHome();
        }

        return $this->render('reset', ['model' => $model, 'id' => $id, 'token' => $token]);
    }

    /*
     * Выводит форму для востановления пароля
     */
    public function actionForm(){
        $model = $this->module->manager->createRecoveryRequestForm();
        return $this->render('request',['model'=> $model]);

}
    public function getIsAjax()
    {
        return Yii::$app->request->isAjax;
    }


}