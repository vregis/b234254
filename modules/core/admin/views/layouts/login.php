<?php

use yii\web\View;
use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;

?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?php $this->beginPage() ?>
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>Metronic | Login Form 3</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->

        <?

        $this->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->getRequest()->csrfParam], 'csrf-param');
        $this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->getRequest()->getCsrfToken()], 'csrf-token');

        // BEGIN GLOBAL MANDATORY STYLES
        $this->registerCssFile("/fonts/Open Sans/OpenSans.css");
        $this->registerCssFile("/metronic/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css");
        $this->registerCssFile("/metronic/theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css");
        $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap/css/bootstrap.min.css");
        $this->registerCssFile("/metronic/theme/assets/global/plugins/uniform/css/uniform.default.css");
        $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css");

        //BEGIN PAGE LEVEL PLUGINS
        $this->registerCssFile("/metronic/theme/assets/global/plugins/select2/css/select2.min.css");
        $this->registerCssFile("/metronic/theme/assets/global/plugins/select2/css/select2-bootstrap.min.css");

        //BEGIN THEME GLOBAL STYLES
        $this->registerCssFile("/metronic/theme/assets/global/css/components.min.css");
        $this->registerCssFile("/metronic/theme/assets/global/css/plugins.min.css");

        //BEGIN PAGE LEVEL STYLES
        $this->registerCssFile("/metronic/theme/assets/pages/css/login-3.min.css");

        $pos = ['position' => View::POS_HEAD];

        //BEGIN CORE PLUGINS
        $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery.min.js", $pos);
        $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js", $pos);
        $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js", $pos);
        $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js", $pos);
        $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery.blockui.min.js", $pos);
        $this->registerJsFile("/metronic/theme/assets/global/plugins/uniform/jquery.uniform.min.js", $pos);
        $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js", $pos);

        //BEGIN PAGE LEVEL PLUGINS
        $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-validation/js/jquery.validate.min.js", $pos);
        $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-validation/js/additional-methods.min.js", $pos);
        $this->registerJsFile("/metronic/theme/assets/global/plugins/select2/js/select2.full.min.js", $pos);

        //BEGIN THEME GLOBAL SCRIPTS
        $this->registerJsFile("/metronic/theme/assets/global/scripts/app.min.js", $pos);

        //BEGIN PAGE LEVEL SCRIPTS
        $this->registerJsFile("/metronic/theme/assets/pages/scripts/login.min.js", $pos);

        $msgJs = <<<JS
            $('.list-inline li > a').click(function () {
                var activeForm = $(this).attr('href') + ' > form';
                //console.log(activeForm);
                $(activeForm).addClass('animated fadeIn');
                //set timer to 1 seconds, after that, unload the animate animation
                setTimeout(function () {
                    $(activeForm).removeClass('animated fadeIn');
                }, 1000);
            });
JS;
        ?>
        <?php $this->registerJs($msgJs, $this::POS_END) ?>

        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="favicon.ico"/>

        <?= Html::csrfMetaTags() ?>

        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <!-- BEGIN BODY -->
    <body class="login">
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="index.html">
            <img src="/images/logo-default.png" alt=""/>
        </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <div class="menu-toggler sidebar-toggler">
    </div>
    <!-- END SIDEBAR TOGGLER BUTTON -->
    <!-- BEGIN LOGIN -->
    <div class="content">
        <?= $content ?>


    </div>
    <!-- END LOGIN -->
    <!-- BEGIN COPYRIGHT -->
    <div class="copyright">
        2015 &copy; BSB. Admin Dashboard.
    </div>
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    </body>
    <!-- END BODY -->
<?php $this->endPage() ?>
</html>