<?php

namespace modules\user\site\controllers;

use modules\core\helpers\ImageHelper;
use modules\core\site\base\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class AccountController
 *
 * @property \frontend\modules\user\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
class SettingsController extends Controller
{
    /** @inheritdoc */
    public $layout = "@modules/user/layouts/login";
    public $defaultAction = 'profile';

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                            'profile',
                            'profile-social',
                            'social',
                            'upload-avatar',
                            'delete-avatar',
                        ],
                        'roles' => ['@']
                    ],
                ]
            ],
        ];
    }

    /**
     * Главная страница настроек
     *
     * @return Response
     */
    public function actionIndex()
    {
        return $this->redirect(['/user/settings/profile']);
    }

    /**
     * Форма редактирования профиля текущего пользователя
     *
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        /**
         * @var \common\modules\user\models\Profile $model
         */
        $model = $this->module->manager->findProfileByUserId(Yii::$app->user->id);
        $model->scenario = 'profile';

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->session->removeAllFlashes();
            //vd($model->attributes);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Yii::t('user', 'Профиль успешно изменен'));
                return $this->redirect(['/user/settings/profile']);
            } else {
                $errors = array_values($model->getFirstErrors());
                $message = Yii::t('user', 'Не удалось сохранить профиль') . Html::tag('br') . array_shift($errors);
                Yii::$app->session->setFlash('error', $message);
            }
        }
        return $this->render('profile', ['model' => $model]);
    }

    /**
     * Список подключенных соц. сетей
     *
     * @return string
     */
    public function actionSocial()
    {
        if ($this->module->onlySteam) {
            return $this->goHome();
        }

        $model = $this->module->manager
            ->findUser(['id' => Yii::$app->user->id])
            ->with('socialAccounts')
            ->one();

        return $this->render('social', ['model' => $model]);
    }

    /**
     * Социальные сети пользователя (ссылки)
     *
     * @return string|Response
     */
    public function actionProfileSocial()
    {
        /** @var \common\modules\user\models\Profile $model */
        if (($model = $this->module->manager->findProfileByUserId(Yii::$app->user->id)) === null) {
            return $this->goHome();
        }

        $model->scenario = 'profile-social';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->removeAllFlashes();
                Yii::$app->session->setFlash('success', Yii::t('user', 'Профиль успешно изменен'));
                return $this->redirect(['/user/settings/profile-social']);
            } else {
                $errors = array_values($model->getFirstErrors());
                $message = Yii::t('user', 'Не удалось сохранить профиль') . Html::tag('br') . array_shift($errors);
                Yii::$app->session->setFlash('error', $message);
            }
        }
        return $this->render('profile-social', ['model' => $model]);
    }


    /**
     * Ajax загрузка аватара пользователя
     *
     * @return array|Response
     */
    public function actionUploadAvatar()
    {
        // разрешаем доступ только через ajax
        if (!$this->isAjax) {
            return $this->goHome();
        }

        $data = ['status' => 0, 'message' => '', 'avatar_url' => ''];

        Yii::$app->response->format = Response::FORMAT_JSON;

        // ID пользователя
        $user_id = (int)Yii::$app->user->id;
        if (empty($user_id)) {
            return $data;
        }

        /** @var \common\modules\user\models\Profile $model */
        if (($model = $this->module->manager->findProfileByUserId($user_id)) === null) {
            return $data;
        }

        $model->scenario = 'avatar';

        $model->avatar_file = UploadedFile::getInstance($model, 'avatar_file');

        if ($model->validate('avatar')) {

            // проверяем длину и ширину изображения
            $width = ImageHelper::getWidth($model->avatar_file->tempName);
            $height = ImageHelper::getHeight($model->avatar_file->tempName);
            if ($width < $this->module->minAvatarWidth || $height < $this->module->minAvatarHeight) {
                $data['message'] = Yii::t('user', 'Изображение слишком маленькое');
                return $data;
            }

            // создаем директорию пользователя, если ее еще нет
            $this->module->createUserDir($user_id);

            // удаляем старый аватар
            @unlink($this->module->getUserDir() . '/avatar.jpg');

            // миниатюра
            ImageHelper::thumbnail(
                $model->avatar_file->tempName,
                $this->module->maxAvatarWidth,
                $this->module->maxAvatarHeight
            )->save($this->module->getAvatarPath(), ['quality' => 90]);

            // убираем флаг загрузки аватара со стима
            $model->avatar_from_steam = 0;

            if ($model->save()) {
                $data['status'] = 1;
                $data['avatar_url'] = $this->module->getAvatarUrl() . '?' . time();
                $data['message'] = Yii::t('user', 'Аватар успешно загружен');
                return $data;
            }
        }

        $error = $model->getFirstError('avatar_file');
        $data['message'] = empty($error) ? Yii::t('user', 'Не удалось загрузить аватар') : $error;
        return $data;
    }

    /**
     * Удаление аватара пользователя
     *
     * @return array|Response
     */
    public function actionDeleteAvatar()
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        $data = ['status' => 0, 'message', 'avatar_url'];

        Yii::$app->response->format = Response::FORMAT_JSON;

        // ID пользователя
        $user_id = (int)Yii::$app->user->id;
        if (empty($user_id)) {
            return $data;
        }

        // Модель текущего пользователя
        if (($model = $this->module->manager->findProfileByUserId($user_id)) === null) {
            return $data;
        }

        $avatar_path = $this->module->getAvatarPath();
        if (@unlink($avatar_path) && $model->save()) {
            $data['status'] = 1;
            $data['avatar_url'] = $this->module->getAvatarUrl();
            $data['message'] = Yii::t('user', 'Аватар успешно удален');
        } else {
            $data['message'] = Yii::t('user', 'Не удалось удалить аватар');
        }
        return $data;
    }
}