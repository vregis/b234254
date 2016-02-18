<?php

use yii\web\View;
use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use modules\tests\site\controllers\DefaultController;

?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?php $this->beginPage() ?>
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>BSB | Login </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->

        <?
        $this->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->getRequest()->csrfParam], 'csrf-param');
        $this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->getRequest()->getCsrfToken()], 'csrf-token');


        $this->registerJsFile("/plugins/switchery/dist/switchery.js");
        $this->registerCssFile("/plugins/switchery/dist/switchery.css");

        $this->registerCssFile("/icomoon/style.css");
        $this->registerCssFile("/css/main.css");

        $this->registerCssFile("/css/grid/320.css");
        $this->registerCssFile("/css/grid/375.css");
        $this->registerCssFile("/css/grid/414.css");
        $this->registerCssFile("/css/grid/480.css");
        $this->registerCssFile("/css/grid/568.css");
        $this->registerCssFile("/css/grid/667.css");
        $this->registerCssFile("/css/grid/736.css");
        $this->registerCssFile("/css/grid/768.css");
        $this->registerCssFile("/css/grid/1024.css");
        $this->registerCssFile("/css/grid/1280.css");
        $this->registerCssFile("/css/grid/1366.css");
        $this->registerCssFile("/css/grid/1680.css");
        $this->registerCssFile("/css/grid/1920.css");
        $this->registerCssFile("/css/grid/grid.css");



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
        $this->registerCssFile("/metronic/theme/assets/global/css/components.css");
        $this->registerCssFile("/metronic/theme/assets/global/css/plugins.min.css");

        //BEGIN PAGE LEVEL STYLES
        $this->registerCssFile("/css/login-3.css");

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
        $('body').animate({'opacity':1},1000);
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
        <link rel="shortcut icon" href="/favicon.ico"/>

        <?= Html::csrfMetaTags() ?>

        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <!-- BEGIN BODY -->
    <body class="login registration">
        <div class="overlay"></div>
        <?= $content ?>
    </body>

<script>
    $( document ).ready(function() {
        $.uniform.restore("#typeSwitch");
        var elems = document.querySelectorAll('.js-switch');

        for (var i = 0; i < elems.length; i++) {
            var switchery = new Switchery(elems[i],{
                secondaryColor: "#6699cc"
            });
        }
        var changeCheckbox = document.querySelector('.js-check-change');
        if(changeCheckbox){
            changeCheckbox.onchange = function() {
                console.log(changeCheckbox.checked);
                if(changeCheckbox.checked == true){
                    $(".typeSwitch label").removeClass('off');
                    $(".typeSwitch label.live").addClass('off');
                }else{
                    $(".typeSwitch label").removeClass('off');
                    $(".typeSwitch label.bus").addClass('off');
                }
            };
        }
        $(".navbar-ico-nav-toggler").click(function(){
            $("#navbar-ico-nav").toggle('slow');
            //$("#header_notification_bar").toggle('slow');
            //$("#header_task_bar").toggle('slow');
        });
        $(document).click(function(event) {
            if ($(event.target).closest(".navbar-ico-nav-toggler").length) return;
            if ($("#navbar-ico-nav").length)
            {
                if(App.getViewPort().width < 561) {
                    $("#navbar-ico-nav").hide('slow');
                }
                //$("#header_notification_bar").hide('slow');
                //$("#header_task_bar").hide('slow');
                event.stopPropagation();
            }
        });
        $("#show-hor-menu").click(function(){
            $(".page-header-menu").slideToggle('slow');
        });
    });
</script>


<!-- END FOOTER -->

<div class="scroll-to-top">
    <i class="icon-arrow-up"></i>
</div>
    <?php $this->endBody() ?>

    <!-- END BODY -->
<?php $this->endPage() ?>


</html>
