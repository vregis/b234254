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
    $this->registerCssFile("/metronic/theme/assets/global/css/components.min.css");
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
            $('.list-inline li > a').click(function () {
                var activeForm = $(this).attr('href') + ' > form';
                //console.log(activeForm);
                $(activeForm).addClass('animated fadeIn');
                //set timer to 1 seconds, after that, unload the animate animation
                setTimeout(function () {
                    $(activeForm).removeClass('animated fadeIn');
                }, 1000);
            });

            //$('div.login').css('height', $(window).height() - 100);
            //$('div.login-back').css('min-height', $(window).height() - 300);
            //$('div.login-back').css('overflow', 'hidden');
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
<body>

<div style="margin-top:0px; padding-bottom:0; margin-bottom:0; opacity:0.5" class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="page-container">

            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/"><img src="/images/logo-default.png" alt="logo" class="logo-default"></a>
            </div>
            <!-- END LOGO -->

            <!-- BEGIN TOP NAVIGATION MENU -->
            <!-- END TOP NAVIGATION MENU -->
        </div>
    </div>
    <!-- END HEADER TOP -->
</div>

<?php  $md = new DefaultController('default', Yii::$app);

$test = $md->actionStatictest();
/*$start = $md->actionStartpage();?>
*/

$test = $md->actionStatictest();
?>
<div class="login-back" style="position:fixed; width:100%;left:0;height:100%;">

<?php echo $test?>

</div>
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="container">
        <span>2015 © BSB</span> <span>All rights reserved</span>
        <a href="javascript:;" class="btn-support">Support</a>
    </div>
</div>
<!-- END FOOTER-->
<div style="position:absolute; width:100%; height:100%; top:0; left:0; background-color:white; opacity:0.7; z-index:555"></div>


<!-- END LOGO -->
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<!--<div class="menu-toggler sidebar-toggler">
</div>-->
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGIN -->
<!--<div class="content">-->
<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">

            <div style="position: fixed; z-index: 666; margin:auto; width:100%">
            <?= $content ?>
            </div>
        </div>
    </div>
</div>

<!--<div class="copyright">
    2015 &copy; BSB
                </div>
            </div>-->
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--</div>-->
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