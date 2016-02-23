<?php

namespace modules\user\admin\controllers;

use modules\core\admin\base\Controller;
use modules\tests\models\TestProgress;
use modules\tests\models\TestUser;
use modules\user\models\User;
use modules\user\models\UserTaskHelpful;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * DefaultController allows you to administrate users.
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DefaultController extends Controller
{
    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs']['actions'] = [
            //'delete' => ['post'],
            'confirm' => ['post'],
            'block' => ['post']
        ];
        return $behaviors;
    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = $this->module->manager->createUserSearch();
        $dataProvider = $searchModel->search($_GET);

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param  int $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('core', 'Изменения успешно сохранены'));
            return $this->redirect(['/user']);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Confirms the User.
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionConfirm($id)
    {
        $this->findModel($id)->confirm();
        Yii::$app->session->setFlash('success', Yii::t('user', 'Пользователь успешно активирован'));
        return $this->redirect(['update', 'id' => $id]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param  int $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $user = $this->findModel($id);
        $userId = $user->id;
        $curId = yii::$app->user->id;
        if($user->getIsSuperAdmin()) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Вы не можете удалить Супер-пользователя'));
        }
        else if($user->getIsSystem()) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Вы не можете удалить системного пользователя'));
        }
        else if($user->id == yii::$app->user->id) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Вы не можете удалить себя'));
        }
        else {
            $test_user = TestUser::find()->where(['user_id' => $id])->one();
            if($test_user){
                $test_prog = TestProgress::find()->where(['test_user_id' => $test_user->id])->all();
                if($test_prog){
                    foreach($test_prog as $tp){
                        $tp->delete();
                    }
                }
            }

            $help = UserTaskHelpful::find()->where(['user_id' => $id])->all();
            if($help){
                foreach($help as $hl){
                    $hl->delete();
                }

            }
            $user->delete();
            Yii::$app->session->setFlash('success', Yii::t('user', 'Пользователь удален'));
        }
        //
        return $this->redirect(['index']);
    }

    /**
     * Blocks the user.
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionBlock($id)
    {
        $user = $this->findModel($id);
        if ($user->getIsAdmin()) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Нельзя заблокировать администратора'));
            return $this->redirect(['index']);
        }
        if ($user->getIsBlocked()) {
            $user->unblock();
            Yii::$app->session->setFlash('success', Yii::t('user', 'Пользователь разблокирован'));
        } else {
            $user->block();
            Yii::$app->session->setFlash('success', Yii::t('user', 'Пользователь заблокирован'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param  int $id
     * @return User
     * @throws NotFoundHttpException      if the model cannot be found
     */
    protected function findModel($id)
    {
        $user = $this->module->manager->findUserById($id);
        if ($id !== null && $user !== null) {
            return $user;
        } else {
            throw new NotFoundHttpException(Yii::t('user', 'Пользователь не найден'));
        }
    }
}
