bsb<?php

/**
 * @var frontend\modules\core\base\View $this
 * @var common\modules\dota\models\Game $games
 */

use modules\core\base\View;

$this->title = Yii::t('core', 'Главная страница');

?>
<?php $this->beginPage() ?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <title>Бета тест</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/style/ui-jqwery/jquery-ui.css">
        <link rel="stylesheet" href="/style/main/style.css">

        <?php
        // js
        $pos = View::POS_HEAD;
        $jsOptions = ['position' => $pos /*, 'depends' => [JqueryAsset::className()]*/];
        // JqueryAsset::register($this);
        $this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js', ['position' => $pos]);
        $this->registerJsFile('/js/lib/jquery-migrate-1.1.1.min.js', $jsOptions);
        $this->registerJsFile(
            'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',
            $jsOptions
        );

        $this->registerJsFile('/js/beta.js', $jsOptions);

        // $this->registerJsFile('/js/lib/alertify/lib/alertify.min.js', $jsOptions);

        /*$this->registerJsFile('/js/main.js', $jsOptions);*/

        // JS для гостя (формы авторизации, регистрации и т.п.)
        /*if ($this->getIsGuest()) {
            $this->registerJsFile('/js/main_guest.js', $jsOptions);
        } else {
            $this->registerJsFile('/js/main_user.js', $jsOptions);
        }*/
        //echo $this->renderHeadHtml();
        ?>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <?php
    $error = Yii::$app->request->get('error');
    if (!empty($error)) {

        echo $this->render(
            '//core/dialog/message',
            [
                'id' => 'system-dialog',
                'title' => Yii::t('mirprost', 'Информация'),
                'message' => Yii::t('core', 'Вас нет в списке участников бета тестирования'),
                'open' => true
            ]
        );
    }
    ?>

    <div class="background-betatest">
        <table class="betatest-tbl">
            <tr>
                <td colspan="2">
                    <a class="logo-mirprost" href="/">
                        <i class="icon-logo-betatest">icon</i>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="name-bl">КАЖДОМУ УЧАСТНИКУ</div>
                    <div class="title-bl"> БЕТА-ТЕСТА БУДЕТ НАЧИСЛЕНО 50 MP</div>
                </td>
                <td>
                    <a href="<?= $this->url(['/user/steam/login']) ?>" class="button-steam">
                        <i class="steam-icon-r">icon</i>

                        <div class="name-bl">войти через</div>
                        <div class="title-bl">STEAM</div>
                    </a>
                </td>
            </tr>
        </table>
        <table class="betatest-info-tbl">
            <tr>
                <td>
                    <div class="title-bl">
                        Призовой фонд получит игрок, у которого на счету будет БОЛЬШЕ ВСЕГО МОНЕТ
                    </div>
                </td>
                <td>
                    <div class="title-bl">
                        Несколько слов о фидбеке можно<br>
                        написать в две небольшие строки
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>