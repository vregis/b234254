<?php

namespace modules\user\site\modules\media\controllers;


use modules\user\modules\media\models\Photo;
use modules\user\modules\media\models\PhotoComment;
use modules\core\site\base\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class PhotoCommentController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class PhotoCommentController extends Controller
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
                        'actions' => ['get', 'add'],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * Возвращает HTML код со списком всех комментариев для текущей фотографии
     *
     * @param $id
     * @return string|Response
     */
    public function actionGet($id)
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = (int)$id;

        return $this->getComments($id);
    }

    /**
     * Генерирует список комментариев для фото
     *
     * @param $id
     * @return string
     */
    private function getComments($id)
    {
        $photo = $this->findPhoto($id);

        return $this->renderAjax(
            'list',
            [
                'photo' => $photo,
                'comments' => $photo->comments
            ]
        );
    }

    /**
     * Добавление комментария
     *
     * @param $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionAdd($id)
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = (int)$id;

        $this->findPhoto($id);

        $data = ['status' => 0, 'message' => '', 'comments' => [], 'id' => 0];

        // защита от флуда
        $lastCommentTime = Yii::$app->session->get('last_comment');
        if (!empty($lastCommentTime) && $lastCommentTime > time() - 5) {
            $data['message'] = Yii::t(
                'user-media',
                'Необходимо подождать некоторое время, прежде чем отправлять повторный комментарий'
            );
            return $data;
        }

        $model = new PhotoComment();

        if ($model->load(Yii::$app->request->post())) {

            $model->photo_id = $id;

            // сохраняем комментарий
            if ($model->save()) {
                $data['status'] = 1;
                $data['id'] = $model->id;
                $data['comments'] = $this->getComments($id);
                return $data;
            } else {
                return $model->getFirstErrors();
            }
        }
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