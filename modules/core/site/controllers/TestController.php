<?php

namespace modules\core\site\controllers;

use modules\core\helpers\DateHelper;
use modules\core\models\IndexChat;
use modules\user\models\Online;
use modules\tests\models\Test;
use modules\core\site\base\Controller as CommonController;
use Yii;
use yii\filters\AccessControl;


/**
 * Основной контроллер frontend-модуля [[core]]
 *
 * @author MrArthur
 * @since 1.0.0
 */
class TestController extends CommonController
{
    public $layout = 'main2';
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
                            'error',
                            'captcha',
                            'page',
                            'main',
                            'need_test',
                        ],
                        'roles' => ['@','?']
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'mrarthur-get-count-online',
                            'mrarthur-get-chat',
                        ],
                        'roles' => ['@']
                    ],
                ]
            ],
        ];
    }

    /** @inheritdoc */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'modules\core\actions\CaptchaAction',
                'minLength' => 4,
                'maxLength' => 5,
                'onlyNumbers' => true,
            ]
        ];
    }

    /**
     * Главная страница сайта.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!$this->isGuest) {
            return $this->redirect('/tests/start');
        }
        $this->layout = 'main2';
        $col = 0;
        return $this->render('index', ['col' => $col]);
    }
    public function actionMain()
    {
        $this->layout = 'main';
        $col = 0;
        return $this->render('main', ['col' => $col]);
    }

    public function actionNeed_test()
    {
        if (!Yii::$app->user->identity->is_need_test) {
            return $this->redirect('/core/main');
        }
        $this->layout = 'main2';
        $tests = Test::find()->all();
        return $this->render('need_test',
            [
                'tests' => $tests
            ]);
    }
    public function actionPage($id)
    {
        $this->layout = 'main';
        $col =0 ;
        if($id) {
            $col = $id;
        }
        return $this->render('main', ['col' => $col]);
    }
    /**
     * Страница с ошибкой
     */
    public function actionError()
    {
        $errorHandler = Yii::$app->errorHandler->exception;

        $error = [];
        $error['code'] = $errorHandler->getCode() ? $errorHandler->getCode() : 404;
        $error['message'] = $errorHandler->getMessage();

        echo $this->renderPartial('error', ['error' => $error]);
    }

    /**
     * Заглушка
     *
     * @return string|\yii\web\Response
     */
    public function actionBeta()
    {
        // заглушка
        $this->layout = false;
        return $this->render('beta');
    }

    /**
     * Количество пользователей онлайн
     */
    public function actionMrarthurGetCountOnline()
    {
        $total = Online::getTotalUsers();
        $online = Online::getTotalOnline();
        $gamesOnline = count(Game::find()->where(['status' => Game::STATUS_PLAY])->all());
        $gamesNotReady = count(Game::find()->where(['status' => Game::STATUS_RECRUITING])->all());
        /*$usersRegistredToday = count(User::find()->where('created_at = CURDATE()')->all());
        $usersRegistredYestarday= count(User::find()->where('created_at = CURDATE()-1')->all());*/

        echo <<<HTML
        <!DOCTYPE HTML><html><head><meta charset="utf-8"></head><body>
        Пользователей всего: {$total}<br>
        Пользователей онлайн: {$online}<br><br>
        Идет игр(а): {$gamesOnline}<br>
        Идет набор игроков: {$gamesNotReady}<br>
        </body></html>
HTML;
    }

    /**
     * Сообщения чата
     */
    public function actionMrarthurGetChat()
    {
        $messages = IndexChat::find()
            ->select(['message', 'username', 'created_at'])
            ->asArray()
            ->orderBy(['id' => SORT_ASC])
            ->all();
        echo '<style>body{background: #f8f8f8}table{border-collapse:collapse;}td{padding:10px;border: 1px solid #ccc;}</style>';
        echo '<table style="width: 100%;">';
        foreach ($messages as $message) {
            echo '<tr>';
            echo "<td width=\"200px\">" . DateHelper::formatDate($message['created_at']) . "</td>
            <td width=\"200px\">{$message['username']}:</td>
            <td>{$message['message']}</td>";
            echo '</tr>';
        }
        echo '</table>';
    }
	
	public function actionLogin(){
		echo 777;
	}
}