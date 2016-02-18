<?php

namespace modules\user\site\modules\media\controllers;

use modules\user\models\User;
use modules\user\modules\media\models\Photo;
use modules\user\modules\media\models\PhotoAlbum;
use modules\core\site\base\Controller;
use Yii;
use yii\base\Exception;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class AlbumController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class AlbumController extends Controller
{
    /** @inheritdoc */
    public $defaultAction = 'all';

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
                            'all',
                            'view',
                            'dialog',
                            'create',
                            'update',
                            'delete',
                            'set-cover',
                            'update-title',
                        ],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Просмотр всех фотографий альбома
     *
     * @param $id
     * @return array
     */
    public function actionView($id)
    {
        $id = (int)$id;

        $album = $this->findAlbum($id);

        $isMy = $this->isMy($album->user_id);

        // количество друзей
        $countFriends = Contact::getFriendsCount($album->user_id);

        // количество сообщений
        $countMessages = $isMy ? Message::getMessagesCount($album->user_id) : null;

        return $this->render(
            'view',
            [
                'isMy' => $isMy,
                'album' => $album,
                'user' => $album->user,
                'photos' => $album->photos,
                'countFriends' => $countFriends,
                'countMessages' => $countMessages,
            ]
        );
    }

    /**
     * Все альбомы пользователя
     *
     * Если не указан $id - отображаются альбомы текущего пользователя
     *
     * @param null $id ID пользователя
     * @return string
     */
    public function actionAll($id = null)
    {
        $user_id = (int)$id;

        $user_id = empty($user_id) ? Yii::$app->user->id : (int)$user_id;

        $user = $this->findUser($user_id);

        ///
        $isMy = $this->isMy($user_id);

        $albums = PhotoAlbum::find()
            ->where(['user_id' => $user->id])
            ->orderBy('id DESC')
            ->all();

        // количество друзей
        $countFriends = Contact::getFriendsCount($user->id);

        // количество сообщений
        $countMessages = $isMy ? Message::getMessagesCount($user->id) : null;

        return $this->render(
            'all',
            [
                'isMy' => $isMy,
                'albums' => $albums,
                'user' => $user,
                'countFriends' => $countFriends,
                'countMessages' => $countMessages,
            ]
        );
    }

    /**
     * Создание альбома с дефолтным названием
     */
    public function actionCreate()
    {
        /** @var \frontend\modules\user\modules\media\Module $userMediaMod */
        $userMediaMod = $this->module;

        $model = new PhotoAlbum();
        // дефолтное название
        $model->title = $userMediaMod->defaultAlbumTitle;

        if ($model->save()) {

            $model->refresh();

            // создаем директорию
            if ($userMediaMod->createPhotoAlbumDirectory($model->id, $model->unique_id)) {
                // все ок альбом и директория успешно созданы
                //Yii::$app->session->setFlash('success', Yii::t('user-media', 'Альбом успешно создан'));
                return $this->redirect(['/user/media/album/update', 'id' => $model->id]);
            } else {
                // не удалось создать директорию
                $model->delete();
                Yii::$app->session->setFlash('error', Yii::t('user-media', 'Не удалось создать альбом'));
            }
        } else {
            Yii::$app->session->setFlash('error', $model->getFirstError('title'));
            return $this->redirect(['/user/media/album/all']);
        }

        return $this->redirect(['/user/media/album/all']);
    }

    /**
     * Редактирование альбома
     *
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $id = (int)$id;

        /** @var PhotoAlbum $album */
        $album = PhotoAlbum::find()
            ->where('id=:id', [':id' => $id])
            ->with(
                [
                    'photos' => function ($query) {
                        /** @var Query $query */
                        $query->orderBy('id DESC');
                    },
                ]
            )
            ->one();

        if (empty($album)) {
            throw new NotFoundHttpException(Yii::t('user-media', 'Альбом не найден'));
        }

        // разрешаем редактировать только свои альбомы
        $this->checkIsMy($album->user_id);

        $data = Yii::$app->request->post();
        // update
        if ($album->load($data) && $album->save()) {

            // сохраняем описание к фото
            if (!empty($data['Photo']['description'])) {
                foreach ($data['Photo']['description'] as $id => $description) {
                    /** @var Photo $photo */
                    $photo = Photo::find()->where(
                        'id=:id AND album_id=:album_id',
                        [':id' => $id, ':album_id' => $album->id]
                    )->one();
                    if (!empty($photo)) {
                        $photo->description = $description;
                        $photo->save();
                    }
                }
            }

            Yii::$app->session->setFlash('success', Yii::t('user-media', 'Альбом успешно отредактирован'));
            return $this->redirect(['/user/media/album/view', 'id' => $album->id]);
        }

        // количество друзей
        $countFriends = Contact::getFriendsCount($album->user_id);

        // количество сообщений
        $countMessages = Message::getMessagesCount($album->user_id);

        return $this->render(
            'update',
            [
                'album' => $album,
                'user' => $album->user,
                'photos' => $album->photos,
                'countFriends' => $countFriends,
                'countMessages' => $countMessages,
            ]
        );
    }

    /**
     * Удаление альбома
     *
     * @param $id
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        $id = (int)$id;

        $model = $this->findAlbum($id);

        // разрешаем удалять только свои альбомы
        $this->checkIsMy($model->user_id);

        /** @var \frontend\modules\user\modules\media\Module $userMediaMod */
        $userMediaMod = $this->module;

        // транзакция
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // если удалили модель, удаляем фото
            if ($model->delete()) {
                $path = $userMediaMod->getPhotoAlbumPath($model->user_id, $model->id, $model->unique_id);
                FileHelper::removeDirectory($path);
            }

            Yii::$app->session->setFlash(
                'success',
                Yii::t('user-media', 'Альбом успешно удален')
            );

            $transaction->commit();

            $this->redirect(['/user/media/album/all', 'id' => $model->user_id]);

        } catch (Exception $e) {
            $transaction->rollBack();

            Yii::$app->session->setFlash(
                'error',
                Yii::t('user-media', 'Не удалось удалить альбом')
            );

            $this->redirect(['/user/media/album/update', 'id' => $model->id]);
        }
    }

    /**
     * Возвращает информацию об альбоме в JSON
     *
     * @param $id
     * @return string
     */
    public function actionDialog($id)
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = (int)$id;

        $album = $this->findAlbum($id);

        return $this->renderAjax('//user/media/views/photo/dialog', ['album' => $album]);
    }

    /**
     * Смена обложки альбома
     *
     * @param $id
     * @return array
     */
    public function actionSetCover($id)
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = ['status' => 0, 'message' => ''];

        $id = (int)$id;

        $photo_id = (int)Yii::$app->request->post('photo_id');

        // обрабатываем запрос
        if (!empty($id) && !empty($photo_id)) {

            /** @var PhotoAlbum $album */
            $album = $this->findAlbum($id);

            // альбом не принадлежит текущему пользователю
            if (!$this->isMy($album->user_id)) {
                $data['message'] = Yii::t('user-media', 'Альбом не принадлежит вам');
                return $data;
            }

            /** @var Photo $photo */
            $photo = $this->findPhoto($photo_id);

            // фотография не принадлежит текущему пользователю
            if (!$this->isMy($photo->album->user_id)) {
                $data['message'] = Yii::t('user-media', 'Фотография не принадлежит вам');
                return $data;
            }

            // если фото не из текущего альбома
            if ($photo->album_id !== $album->id) {
                $data['message'] = Yii::t('user-media', 'Фотография должна быть из текущего альбома');
                return $data;
            }

            $album->cover_id = $photo_id;
            // валидируем и сохраняем обложку в БД
            if ($album->save(true, ['cover_id'])) {
                $data['status'] = 1;
                $data['message'] = Yii::t('user-media', 'Обложка альбома успешно изменена');
                return $data;
            } else {
                $data['message'] = Yii::t('user-media', 'Не удалось сменить обложку альбома');
                return $data;
            }
        }

        $data['message'] = Yii::t('user-media', 'Не получены необходимые данные');
        return $data;
    }

    /**
     * Обновляет название альбома (AJAX)
     *
     * @param $album_id
     * @return array|Response
     */
    public function actionUpdateTitle($album_id)
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = [];

        $newTitle = Yii::$app->request->post('title');
        if (empty($newTitle)) {
            return $data;
        }

        $album_id = (int)$album_id;

        $album = PhotoAlbum::findOne($album_id);
        if ($album === null || $album->user_id !== Yii::$app->user->id) {
            $data['error'] = Yii::t('user-media', 'Альбом не найден');
            return $data;
        }

        $album->title = $newTitle;
        $album->save(true, ['title']);

        return $data;
    }

    /**
     * Поиск альбома по ID
     *
     * @param $id
     * @return PhotoAlbum
     * @throws \yii\web\NotFoundHttpException
     */
    protected function findAlbum($id)
    {
        if (($model = PhotoAlbum::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('user-media', 'Альбом не найден'));
        }
    }

    /**
     * Поиск фотографии по ID
     *
     * @param $id
     * @return Photo
     * @throws \yii\web\NotFoundHttpException
     */
    protected function findPhoto($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('user-media', 'Фотография не найдена'));
        }
    }

    /**
     * Поиск пользователя по ID
     *
     * @param $id
     * @return User
     * @throws \yii\web\NotFoundHttpException
     */
    protected function findUser($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('user-media', 'Пользователь не найден'));
        }
    }
}