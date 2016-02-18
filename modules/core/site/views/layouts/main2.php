
<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 4.0.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->

<?
use yii\web\View;


$this->beginPage();
?>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>BSB</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <!-- <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'> -->
    <?

    $this->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->getRequest()->csrfParam], 'csrf-param');
    $this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->getRequest()->getCsrfToken()], 'csrf-token');

    require_once __DIR__ . '/metronic_blank.php';

    $this->registerCssFile("/icomoon/style.css");

    $this->registerCssFile("/css/custom.css");
    $this->registerCssFile("/css/main.css");
    $this->registerCssFile("/css/departments_questionary.css");

    $msgJs = <<<JS
    jQuery(document).ready(function() {
    });
JS;
    $this->registerJs($msgJs);
    ?>

    <!-- ICOMOON -->
    <link href="" rel="stylesheet" type="text/css"/>

    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/favicon.ico"/>

    <?php $this->head() ?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body>
<?php $this->beginBody() ?>

<!-- BEGIN HEADER -->
<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="page-container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/"><img src="/images/logo-default.png" alt="logo" class="logo-default"></a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler"></a>
            <!-- END RESPONSIVE MENU TOGGLER -->
        </div>
    </div>
    <!-- END HEADER TOP -->
</div>
<!-- END HEADER -->
<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?= $content ?>
        </div>
    </div>
</div>
<!-- END QUICK SIDEBAR -->

<div class="page-footer">
    <div class="container">
        2015 &copy; BSB<br>All rights reserved
    </div>
</div>
<div class="scroll-to-top" style="display: block;">
    <i class="icon-arrow-up"></i>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php $this->endBody() ?>
</body>
<!-- END BODY -->
</html>
<?php $this->endPage() ?>