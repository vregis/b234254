<?php

namespace modules\user\site\modules\media\controllers;


use modules\contact\models\Contact;
use modules\core\components\Youtube;
use modules\core\helpers\TextHelper;
use modules\message\models\Message;
use modules\user\models\User;
use modules\user\modules\media\models\Video;
use modules\core\site\base\Controller;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class VideoController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class VideoController extends Controller
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
                            'create',
                            'update',
                            'delete',
                            'load-video-form',
                            'get-data',
                            'get-video'
                        ],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Все видео пользователя
     *
     * @param null $id
     * @return string
     */
    public function actionAll($id = null)
    {
        $user_id = (int)$id;

        $user_id = empty($user_id) ? Yii::$app->user->id : (int)$user_id;

        $user = $this->findUser($user_id);

        $isMy = $this->isMy($user_id);

        $query = Video::find()
            ->where(['user_id' => $user->id])
            ->orderBy('id DESC');

        // пейджер
        $countQuery = clone $query;
        /** @var \common\modules\user\modules\media\Module $userMediaMod */
        $userMediaMod = $this->module;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => $userMediaMod->videosPerPage
        ]);
        $videos = $query->offset($pages->offset)->limit($pages->limit)->all();

        // количество друзей
        $countFriends = Contact::getFriendsCount($user->id);

        // количество сообщений
        $countMessages = $isMy ? Message::getMessagesCount($user->id) : null;

        return $this->render(
            'all',
            [
                'isMy' => $isMy,
                'videos' => $videos,
                'pages' => $pages,
                'user' => $user,
                'countFriends' => $countFriends,
                'countMessages' => $countMessages,
            ]
        );
    }

    /**
     * Подгружает форму при добавлении видео
     *
     * Проверяет, является ли поле 'url' ссылкой на видео с ютуба
     * Получает информацию через API ютуба по ID видео
     * Если все ок - рендерит форму, с использованием информации, полученной через API ютуба
     *
     * @return array
     */
    public function actionGetData()
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = ['status' => 0, 'message' => '', 'html' => ''];

        $model = new Video();
        $model->scenario = 'checkUrl';

        $model->url = TextHelper::filterString(Yii::$app->request->post('url'));

        // проверяем URL
        if (!$model->validate()) {
            $data['message'] = $model->getFirstError('url');
            return $data;
        }

        // получаем ID видео из URL
        $videoId = Youtube::parseVIdFromURL($model->url);
        if (empty($videoId)) {
            $data['message'] = Yii::t('user-media', 'Неправильный ID видео');
            return $data;
        }
        // получаем информацию о видео через API ютуба
        $video = $this->getVideoInfo($videoId);
        if (empty($video->snippet)) {
            $data['message'] = Yii::t('user-media', 'Не удалось получить информацию о видео');
            return $data;
        }

        $v = $video->snippet;

        // очищаем описание
        $v->description = Video::cleanDescription($v->description);

        $data['status'] = 1;
        $data['html'] = $this->renderAjax(
            '_create_ajax',
            [
                'preview' => empty($v->thumbnails->medium->url) ? null : $v->thumbnails->medium->url,
                'title' => empty($v->title) ? null : $v->title,
                'description' => empty($v->description) ? null : $v->description,
                'videoId' => $videoId
            ]
        );

        return $data;
    }

    /**
     * Получает информацию о видео через API юутуба по ID видео
     *
     * Получает с ютуба название, описание и изображение видео
     *
     * @param $id
     * @return \StdClass
     * @throws \yii\base\InvalidParamException
     */
    private function getVideoInfo($id)
    {
        $id = TextHelper::filterString($id);

        if (empty($id)) {
            return false;
        }

        // получаем видео с youtube.com
        $youtube = new Youtube(['key' => 'AIzaSyAKd-hLD9Sr4EDxsr1_Zpb5aThL44lKzlc']);

        $video = $youtube->getVideoInfo($id);

        // не удалось получить информацию о видео
        if (empty($video) || empty($video->snippet)) {
            return false;
        }

        // возвращаем информацию о видео
        return $video;
    }

    /**
     * Добавление нового видео по ссылке или коду с youtube
     */
    public function actionCreate()
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = ['status' => 0, 'message' => '', 'url' => ''];

        $model = new Video();
        $model->scenario = 'saveVideo';

        $post = Yii::$app->request->post();

        if (!empty($post)) {

            // проверяем видео
            $videoInfo = $this->getVideoInfo($post['videoId']);
            if (empty($videoInfo)) {
                $data['message'] = Yii::t('user-media', 'Неправильный ID видео');
                return $data;
            }

            $model->code = $post['videoId'];
            $model->title = $post['title'];
            $model->description = $post['description'];

            // сохраняем
            if ($model->save()) {

                /** @var \frontend\modules\user\modules\media\Module $userMediaMod */
                $userMediaMod = $this->module;

                // создаем директорию, если ее еще нет
                $userMediaMod->createYoutubePreviewDir($model->id);

                // сохраняем изображения
                $thumbnails = ArrayHelper::toArray($videoInfo->snippet->thumbnails);
                foreach ($thumbnails as $size => $params) {

                    $path = $userMediaMod->getYoutubePreviewDir($model->id) . '/' . $size . '.jpg';
                    // копируем изображения
                    // если не получилось, удаляем модель и директорию с изображениями
                    if (!curl_init($params['url']) || !copy($params['url'], $path)) {
                        $model->delete();
                        $data['message'] = Yii::t('user-media', 'Не удалось сохранить видео');
                        return $data;
                    }
                }

                $data['status'] = 1;
                $data['message'] = Yii::t('user-media', 'Видео успешно добавлено');
                $data['url'] = Url::to(['/user/media/video/all']);
                return $data;
            } else {
                $data = $model->getFirstErrors();
                return $data;
            }
        }
        return true;
    }

    /**
     * Редактирование видео
     *
     * @param $id
     * @param $page
     * @return string|Response
     */
    public function actionUpdate($id, $page = 1)
    {
        $id = (int)$id;
        $page = (int)$page;

        /** @var Video $video */
        $video = $this->findVideo($id);
        $video->scenario = 'updateVideo';

        // разрешаем редактировать только свои альбомы
        $this->checkIsMy($video->user_id);

        if ($video->load(Yii::$app->request->post()) && $video->validate()) {

            if ($video->save(false)) {
                Yii::$app->session->setFlash('success', Yii::t('user-media', 'Видео успешно отредактировано'));
                return $this->redirect(
                    ['/user/media/video/all', 'id' => $video->user_id, 'page' => $page, '#' => 'v' . $video->id]
                );
            } else {
                Yii::$app->session->setFlash('error', Yii::t('user-media', 'Не удалось сохранить изменения'));
            }
        }

        // количество друзей
        $countFriends = Contact::getFriendsCount($video->user_id);

        // количество сообщений
        $countMessages = Message::getMessagesCount($video->user_id);

        return $this->render(
            'update',
            [
                'video' => $video,
                'user' => $video->user,
                'countFriends' => $countFriends,
                'countMessages' => $countMessages,
                'page' => $page
            ]
        );
    }

    /**
     * @param $id
     */
    public function actionDelete($id)
    {
        $id = (int)$id;

        /** @var Video $video */
        $video = $this->findVideo($id);

        // разрешаем удалять только свои альбомы
        $this->checkIsMy($video->user_id);

        /** @var \frontend\modules\user\modules\media\Module $userMediaMod */
        $userMediaMod = $this->module;

        // транзакция
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // если удалили модель, удаляем фото
            if ($video->delete()) {
                $userMediaMod->removeYoutubePreviewDir($video->id);
            }

            Yii::$app->session->setFlash(
                'success',
                Yii::t('user-media', 'Видео успешно удалено')
            );

            $transaction->commit();

            $this->redirect(['/user/media/video/all', 'id' => $video->user_id]);

        } catch (Exception $e) {
            $transaction->rollBack();

            Yii::$app->session->setFlash(
                'error',
                Yii::t('user-media', 'Не удалось удалить видео')
            );

            $this->redirect(['/user/media/video/update', 'id' => $video->id]);
        }
    }

    /**
     * Получение информации о видео из БД при просмотре в диалоговом окне
     *
     * @param $id
     * @return array
     */
    public function actionGetVideo($id)
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = (int)$id;

        $data = ['status' => 0, 'message' => '', 'html' => ''];

        // получаем информацию о видео через API ютуба
        $video = $this->findVideo($id);
        if (empty($video)) {
            $data['message'] = Yii::t('user-media', 'Не удалось получить информацию о видео');
            return $data;
        }

        $data['status'] = 1;
        $data['html'] = $this->renderAjax(
            '_dialog',
            [
                'video' => $video
            ]
        );
        return $data;
    }

    /**
     * Поиск видео по ID
     *
     * @param $id
     * @return Video
     * @throws NotFoundHttpException
     */
    protected function findVideo($id)
    {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('user-media', 'Видео не найдено'));
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