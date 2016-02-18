<?php

namespace modules\core\site\controllers;

use modules\core\behaviors\PurifierBehavior;
use modules\core\models\IndexChat;
use modules\user\models\User;
use modules\core\site\base\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\HtmlPurifier;
use yii\web\Response;

/**
 * Контроллер для чата на главной
 *
 * @property \frontend\modules\core\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
class ChatController extends Controller
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
                        'actions' => ['send', 'get'],
                        'roles' => ['@', '?']
                    ],
                ]
            ],
        ];
    }

    /**
     * Отправка сообщения в чат
     *
     * @return array|bool|Response
     */
    public function actionSend()
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = ['status' => 0, 'message' => '', 'filteredMessage' => ''];

        if ($this->isGuest) {
            $data['message'] = Yii::t('core', 'Необходимо авторизоваться');
            return $data;
        }

        // защита от флуда
        $lastCommentTime = Yii::$app->session->get('last_comment');
        if (!empty($lastCommentTime) && $lastCommentTime > time() - 5) {
            $data['message'] = Yii::t(
                'core',
                'Необходимо подождать некоторое время, прежде чем отправлять повторный комментарий'
            );
            return $data;
        }

        /** @var User $user */
        $user = Yii::$app->user->identity;

        // сохраняем сообщение
        $message = new IndexChat();
        $message->username = $user->username;
        $message->message = Yii::$app->request->post('message');
        if ($message->save()) {
            $data['status'] = 1;
        } else {
            $data['message'] = $message->getFirstError('message');
            $data['filteredMessage'] = HtmlPurifier::process(($message->message),
                PurifierBehavior::purifierOptionsText());
            $data['filteredMessage'] = trim($data['filteredMessage']);
        }
        return $data;
    }

    /**
     * Получение cсписка комментариев
     *
     * @param $id
     * @return array|string|Response
     */
    public function actionGet($id)
    {
        if (!$this->isAjax) {
            return $this->onlyAjax();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = (int)$id;

        if (($lastMessageId = IndexChat::hasNewMessages($id)) === false) {
            return ['noUpdate' => 1];
        }

        $messages = IndexChat::getMessages();

        return [
            'html' => $this->renderAjax('_messages', ['messages' => $messages]),
            'lastMessageId' => $lastMessageId,
        ];
    }
}