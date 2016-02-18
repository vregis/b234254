<?php

namespace modules\user\site\modules\media\controllers;

use modules\user\modules\media\models\Photo;
use modules\user\modules\media\models\PhotoAlbum;
use modules\core\site\base\Controller;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\imagine\Image as Imagine;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class PhotoController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class PhotoController extends Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['upload', 'delete', 'get-rating'],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Загрузка изображения (JqueryFileUpload)
     *
     * @param $album_id
     * @return array|bool
     */
    public function actionUpload($album_id)
    {
        $album_id = (int)$album_id;

        $data = [];
        $data['files'][0] =
            [
                'name' => '',
                'size' => 0,
                'url' => '',
                'thumbnailUrl' => '',
                'deleteUrl' => '',
                'deleteType' => 'DELETE',
                'error' => '',
            ];

        Yii::$app->response->format = Response::FORMAT_JSON;

        $albumModel = PhotoAlbum::findOne($album_id);
        if ($albumModel === null) {
            $data['files'][0]['error'] = Yii::t('user-media', 'Альбом не найден');
            return $data;
        }

        // разрешаем загрузку только в свои альбомы
        $this->checkIsMy($albumModel->user_id);

        // сохраняем модель
        $photoModel = new Photo();
        $photoModel->scenario = 'image';
        $photoModel->album_id = $album_id;

        if (!$photoModel->save(false)) {
            $data['files'][0]['error'] = Yii::t('user-media', 'Не удалось сохранить изображение');
            return $data;
        }

        // загружаем файл
        $photoModel->image_file = UploadedFile::getInstance($photoModel, 'image_file');
        // если не удалось получить изображение, удаляем модель
        if (empty($photoModel->image_file)) {
            $photoModel->delete();
            Yii::$app->session->setFlash('error', Yii::t('user-media', 'Не удалось загрузить файл'));
            return false;
        }

        // проверяем изображение
        if (!$photoModel->validate()) {
            $photoModel->delete();
            $error = $photoModel->getFirstError('image_file');
            $msg = Yii::t('user-media', 'Не удалось загрузить файл');
            $msg .= ' (' . Html::encode($photoModel->image_file->name) . '). ';
            $msg .= empty($error) ? '' : $error;
            Yii::$app->session->setFlash('error', $msg);
            return false;
        }

        /** @var \frontend\modules\user\modules\media\Module $userMediaMod */
        $userMediaMod = $this->module;

        // путь к директории альбома
        $albumPath = $userMediaMod->getPhotoAlbumPath(
            Yii::$app->user->id,
            $albumModel->id,
            $albumModel->unique_id
        );

        // путь к оригиналу
        $originalPath = $userMediaMod->getPhotoPath($albumPath, $photoModel->id, $photoModel->unique_id);

        $imagine = new Imagine();

        // сохраняем оригинал
        if ($imagine->getImagine()->open($photoModel->image_file->tempName)->save($originalPath)) {

            // создаем миниатюры
            foreach ($userMediaMod->sizes as $size => $params) {

                $thumbPath = $userMediaMod::getPhotoPath(
                    $albumPath,
                    $photoModel->id,
                    $photoModel->unique_id,
                    $size
                );
                Imagine::thumbnail($originalPath, $params['width'], $params['height'])->save($thumbPath);
            }

            // URL к директории альбома
            $albumUrl = $userMediaMod->getPhotoAlbumUrl(Yii::$app->user->id, $albumModel->id, $albumModel->unique_id);

            // получаем URL к уменьшеной копии изображения
            $smallUrl = $userMediaMod::getPhotoUrl(
                $albumUrl,
                $photoModel->id,
                $photoModel->unique_id,
                'small'
            );

            // получаем и сохраняем размер изображения
            list($width, $height) = getimagesize($originalPath);
            $photoModel->img_width = (int)$width;
            $photoModel->img_height = (int)$height;
            $photoModel->updateAttributes(['img_width', 'img_height']);

            // если нет кавера, устанавливаем
            if (empty($albumModel->cover_id)) {
                $albumModel->cover_id = $photoModel->id;
                $albumModel->save(true, ['cover_id']);
            }

            // формируем ответ для JqueryFileUpload
            $data['files'][0] = [
                'name' => "{$photoModel->image_file->name}",
                'size' => (int)$photoModel->image_file->size,
                'url' => "{$smallUrl}",
                'thumbnailUrl' => "{$smallUrl}",
                'deleteUrl' => '#'
            ];
            return $data;
        } else {
            $photoModel->delete();
            $data['files'][0]['error'] = Yii::t('user-media', 'Не удалось сохранить изображение');
            return $data;
        }
    }

    /**
     * Удаление фото из альбома
     *
     * @param $id
     * @return array|Response
     */
    public function actionDelete($id)
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = (int)$id;

        /** @var \common\modules\user\modules\media\models\Photo $photo */
        $photo = $this->findPhoto($id);

        // разрешаем удалять только фотографии из своих альбомов
        $this->checkIsMy($photo->album->user_id);

        // обложка альбома?
        $isCover = $photo->id == $photo->album->cover_id ? true : false;

        /** @var \frontend\modules\user\modules\media\Module $userMediaMod */
        $userMediaMod = $this->module;

        // транзакция
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // если удалили модель, удаляем фото
            if ($photo->delete()) {

                $albumPath = $userMediaMod->getPhotoAlbumPath(
                    $photo->album->user_id,
                    $photo->album_id,
                    $photo->album->unique_id
                );
                // удаляем оригинал
                @unlink($userMediaMod->getPhotoPath($albumPath, $photo->id, $photo->unique_id));

                // удаляем уменьшенные копии
                foreach ($userMediaMod->sizes as $size => $params) {
                    @unlink($userMediaMod->getPhotoPath($albumPath, $photo->id, $photo->unique_id, $size));
                }

                // если фото было обложкой альбома, пытаемся установить другую
                if ($isCover) {
                    PhotoAlbum::setFirstPhotoAsCover($photo->album_id);
                }
            }
            $transaction->commit();

            return ['status' => 1, 'message' => Yii::t('user-media', 'Фотография успешно удалена')];

        } catch (Exception $e) {
            $transaction->rollBack();
            return ['status' => 0, 'message' => Yii::t('user-media', 'Не удалось удалить фотографию')];
        }
    }

    /**
     * Получение лайков/дислайков для текущего фото
     *
     * @param $id
     * @return array|Response
     */
    public function actionGetRating($id)
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = ['status' => 0, 'message' => '', 'likes' => 0, 'dislikes' => 0];

        $id = (int)$id;

        /** @var Photo $photo */
        $photo = $this->findPhoto($id);

        $data['status'] = 1;
        $data['likes'] = (int)$photo->rating_like;
        $data['dislikes'] = (int)$photo->rating_dislike;
        return $data;
    }

    /**
     * Поиск фото по ID
     *
     * @param $id
     * @return Photo
     * @throws NotFoundHttpException
     */
    protected function findPhoto($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('user-media', 'Фотография не найдена'));
        }
    }
}