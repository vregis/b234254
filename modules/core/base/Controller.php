<?php

namespace modules\core\base;

use modules\core\models\Settings;
use Yii;
use yii\base\ErrorException;
use yii\web\Controller as YiiController;
use yii\web\ForbiddenHttpException;

/**
 * Базовый контроллер для бэкенда и фронтенда
 *
 * @property bool $isGuest
 * @property bool $isAjax
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Controller extends YiiController
{
    /** @var array Настройки рейтинга для модуля [[content]] */
    public $rating = [];

    /** @inheritdoc */
    public function init()
    {
        // подгружаем настройки
        $this->getSettings();
        return parent::init();
    }

    /**
     * Получение настроек модуля
     *
     * @param bool $reset Удалить кеш
     * @return bool
     */
    public function getSettings($reset = false)
    {
        try {
            // получаем данные из БД или кеша
            $duration = $reset ? null : 600;

            $models = Yii::$app->db->cache(
                function () {
                    return Settings::find()->all();
                },
                $duration
            );

            if (empty($models)) {
                return true;
            }

            foreach ($models as $param) {

                // проверяем, существует ли модуль
                /** @var \common\modules\core\base\Module $module */
                $module = Yii::$app->getModule($param['module_id']);
                if ($module === null) {
                    continue;
                }
                // получаем доступные параметры для реадкитрования
                $editableParams = $module->getEditableParams();
                // если параметр существует, присваиваем ему значение из БД
                if (property_exists($module, $param['param_name'])
                    && (in_array($param['param_name'], $editableParams)
                        || array_key_exists($param['param_name'], $editableParams))
                ) {
                    $module->{$param['param_name']} = $param['param_value'];
                }
            }
        } catch (ErrorException $e) {
            return false;
        }
        return true;
    }

    /**
     * Проверяет, совпадает ли $user_id с ID текущего пользователя
     *
     * Возвращает true или false
     *
     * @param int $user_id
     * @return bool
     */
    public function isMy($user_id)
    {
        if (empty($user_id) || $this->getIsGuest()) {
            return false;
        }
        return (bool)($user_id == Yii::$app->user->id);
    }

    /**
     * Проверяет, совпадает ли $user_id с ID текущего пользователя
     *
     * Возвращает true, id если совпадают
     * ForbiddenHttpException - если id не совпадают
     *
     * @param int $user_id
     * @return bool
     * @throws \yii\web\ForbiddenHttpException
     */
    public function checkIsMy($user_id)
    {
        if (!$this->isMy($user_id)) {
            throw new ForbiddenHttpException(Yii::t('core', 'У вас нет прав на данное действие'));
        }
        return true;
    }

    /**
     * Пользователь является администратором сайта
     *
     * @return bool
     */
    public function getIsAdmin()
    {
        return Yii::$app->user->can('admin');
    }

    /**
     * Пользователь не залогинен
     *
     * @return bool
     */
    public function getIsGuest()
    {
        return Yii::$app->user->isGuest;
    }

    /**
     * AJAX запрос
     *
     * @return bool|mixed
     */
    public function getIsAjax()
    {
        return Yii::$app->request->isAjax;
    }

    /**
     * Устанавливает флеш сообщение и редиректит на главную
     *
     * @return \yii\web\Response
     */
    public function onlyAjax()
    {
        Yii::$app->session->setFlash('error', Yii::t('user', 'Некорректный запрос'));
        return $this->isAjax ? ['url' => Yii::$app->homeUrl] : $this->goHome();
    }

    /**
     * Редиректит на главную
     *
     * @return \yii\web\Response
     */
    public function onlyGuest()
    {
        return $this->isAjax ? ['url' => Yii::$app->homeUrl] : Yii::$app->response->redirect(Yii::$app->homeUrl);
    }

    /**
     * Устанавливает флеш сообщение и редиректит на главную
     *
     * @return \yii\web\Response
     */
    public function onlyUser()
    {
        Yii::$app->session->setFlash('error', Yii::t('user', 'Вы не авторизованы'));
        $url = Yii::$app->user->loginUrl;
        return $this->isAjax ? ['url' => $url] : Yii::$app->response->redirect($url);
    }
}