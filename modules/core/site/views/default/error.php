<?php

use yii\helpers\Url;
use yii\web\View;

/**
 * @var string $error
 */

$this->title = 'Error';

$error['code'] = (int)$error['code'];
?>

<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.5
Version: 4.5
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
$this->beginPage();
?>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>BSB | 404 Error Page</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <?

    $this->registerCssFile("/fonts/Open Sans/OpenSans.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap/css/bootstrap.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/uniform/css/uniform.default.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css");

    //BEGIN THEME GLOBAL STYLES
    $this->registerCssFile("/metronic/theme/assets/global/css/components.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/css/plugins.min.css");

    //BEGIN PAGE LEVEL STYLES
    $this->registerCssFile("/metronic/theme/assets/pages/css/error.min.css");


    $pos = ['position' => View::POS_END];
    //BEGIN CORE PLUGINS
    $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery.blockui.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/uniform/jquery.uniform.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js", $pos);

    //BEGIN THEME GLOBAL SCRIPTS
    $this->registerJsFile("/metronic/theme/assets/global/scripts/app.min.js", $pos);
    ?>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="/favicon.ico" />

    <?php $this->head() ?>
</head>
<!-- END HEAD -->

<body class=" page-404-3">
<?php $this->beginBody() ?>
<div class="page-inner">
    <img src="/metronic/theme/assets/pages/media/pages/earth.jpg" class="img-responsive" alt=""> </div>
<div class="container error-404">
    <h1>404</h1>
    <h2>Houston, we have a problem.</h2>
    <p> Actually, the page you are looking for does not exist. </p>
    <p> Message: <?= $error['message'] ?> </p>
    <p>
        <a href="<?= Url::toRoute(['/']) ?>" class="btn red btn-outline"> Return home </a>
        <br> </p>
</div>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>