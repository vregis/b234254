<?php

namespace backend\modules\mail\controllers;

use backend\modules\core\base\Controller;
use common\modules\mail\models\MailSearch;
use common\modules\mail\models\Queue;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class QueueController
 *
 * @property \backend\modules\mail\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
class QueueController extends Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs']['actions'] = [
            'delete' => ['post'],
        ];
        return $behaviors;
    }

    /**
     * Lists all Queue models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MailSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $mailsInQueue = Queue::getMailsInQueue();

        return $this->render(
            'index',
            [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'mailsInQueue' => $mailsInQueue,
            ]
        );
    }

    /**
     * Displays a single Queue model.
     *
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id),]);
    }

    /**
     * Deletes an existing Queue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Queue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     * @return Queue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Queue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('mail', 'Письмо не найдено'));
        }
    }
}