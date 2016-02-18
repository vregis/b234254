
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
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\departments\models\Department;

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

    // BEGIN GLOBAL MANDATORY STYLES
    $this->registerCssFile("/fonts/Open Sans/OpenSans.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap/css/bootstrap.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/uniform/css/uniform.default.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css");

    //BEGIN PAGE LEVEL PLUGINS
    $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/datatables/datatables.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/morris/morris.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/fullcalendar/fullcalendar.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/jqvmap/jqvmap/jqvmap.css");

    //BEGIN THEME GLOBAL STYLES
    $this->registerCssFile("/metronic/theme/assets/global/css/components.min.css");
    $this->registerCssFile("/metronic/theme/assets/global/css/plugins.min.css");

    //BEGIN THEME LAYOUT STYLES
    // $this->registerCssFile("/metronic/theme/assets/layouts/layout/css/layout.min.css");
    $this->registerCssFile("/metronic/theme/assets/layouts/layout/css/themes/darkblue.min.css");
    $this->registerCssFile("/metronic/theme/assets/layouts/layout/css/custom.min.css");
    $this->registerCssFile("/icomoon/style.css");

    $this->registerCssFile("/css/main.css");

    $pos = ['position' => View::POS_HEAD];

    $this->registerJsFile("/metronic/theme/assets/global/plugins/respond.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/excanvas.min.js", $pos);
    //BEGIN CORE PLUGINS
    $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery.blockui.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/uniform/jquery.uniform.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js", $pos);

    //BEGIN PAGE LEVEL PLUGINS
    $this->registerJsFile("/metronic/theme/assets/global/scripts/datatable.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/datatables/datatables.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-daterangepicker/moment.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/morris/morris.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/morris/raphael-min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/counterup/jquery.waypoints.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/counterup/jquery.counterup.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/amcharts/amcharts/amcharts.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/amcharts/amcharts/serial.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/amcharts/amcharts/pie.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/amcharts/amcharts/radar.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/amcharts/amcharts/themes/light.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/amcharts/amcharts/themes/patterns.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/amcharts/amcharts/themes/chalk.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/amcharts/ammap/ammap.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/amcharts/amstockcharts/amstock.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/fullcalendar/fullcalendar.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/flot/jquery.flot.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/flot/jquery.flot.resize.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/flot/jquery.flot.categories.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery.sparkline.min.js", $pos);


    //BEGIN THEME GLOBAL SCRIPTS
    $this->registerJsFile("/metronic/theme/assets/global/scripts/app.min.js", $pos);

    //BEGIN PAGE LEVEL SCRIPTS
    $this->registerJsFile("/metronic/theme/assets/pages/scripts/dashboard.min.js", $pos);

    //BEGIN THEME LAYOUT SCRIPTS
    $this->registerJsFile("/metronic/theme/assets/layouts/layout/scripts/layout.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/layouts/layout/scripts/layout.js");
    $this->registerJsFile("/metronic/theme/assets/layouts/layout/scripts/demo.min.js", $pos);
    $this->registerJsFile("/metronic/theme/assets/layouts/global/scripts/quick-sidebar.min.js", $pos);

    $msgJs = <<<JS
    jQuery(document).ready(function() {
    });
JS;
    $this->registerJs($msgJs);
    ?>

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
<div class="b-page-wrap">
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

<!-- <a href="javascript:;" class="btn-navbar navbar-ico-nav-toggler" data-toggle="collapse" data-target=".mobile-small-nav">
</a>  -->
<a href="javascript:;" class="btn-navbar navbar-ico-nav-toggler" data-hover="collapse"  data-toggle="collapse" data-target=".mobile-small-nav">
</a>


<a id="show-hor-menu" href="javascript:;" class="menu-toggler menu_departments-toggler" data-toggle="dropdown">
    <div class="menu_departments">Departments</div>
</a>
<?
$departments = Department::find()->where(['is_additional' => false])->all();
$department_active = Yii::$app->controller->module->id == 'departments' && !is_null(Yii::$app->request->get('id')) ? Yii::$app->request->get('id') : 1;
?>
<? foreach($departments as $department) : ?>
    <? if($department->id == $department_active) : ?>
        <div class="menu-departments-name nav-<?= $department->icons ?>  visible-xs visible-sm">
            <span class="ico-strategy"></span>&nbsp;<?= $department->name ?>
        </div>
    <? endif; ?>
<? endforeach; ?>

<!-- END RESPONSIVE MENU TOGGLER -->


<div class="top-menu pull-left navbar-ico-nav mobile-small-nav" id="navbar-ico-nav">
    <ul class="nav navbar-nav">
        <li>
            <a>
                <span class="ico-self"></span>
                <span class="b-icon-name">Self</span>
            </a>
        </li>
        <li>
            <a>
                <span class="ico-buisness"></span>
                <span class="b-icon-name">Business</span>
            </a>
        </li>
        <!--<li>
            <a>
                <span class="ico-team"></span>
                 <span class="b-icon-name">Team</span>
            </a>
        </li>-->
    </ul>
</div>

<!-- BEGIN TOP NAVIGATION MENU -->
<div class="top-menu navbar-notification">
<ul class="nav navbar-nav pull-right">

<li class="button-chat">
    <a class="custom-quick-sidebar-toggler quick-sidebar-toggler" data-toggle="collapse">
        <span class="sr-only">Toggle Quick Sidebar</span>
        <span class="ico-chat"></span>
    </a>
</li>
<!-- END TODO DROPDOWN -->
<!-- BEGIN USER LOGIN DROPDOWN -->
<li class="dropdown dropdown-user dropdown-dark">
    <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
        <img src="/metronic/theme/assets/layouts/layout3/img/avatar10.jpg" class="img-circle" alt="">
        <span class="username username-hide-mobile"><?= Yii::$app->user->identity->username ?></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-default">
        <li>
            <a href="#">
                <i class="icon-user"></i> My Profile </a>
        </li>
        <li class="divider">
        </li>
        <li>
            <?php $form = ActiveForm::begin(['action'=>'/user/logout']);
            ActiveForm::end();
            echo Html::a(
                '<i class="icon-key"></i> Log Out',
                Url::toRoute(['/user/logout']),
                ['data-method' => 'post']
            );
            ?>
        </li>
    </ul>
</li>
<!-- END USER LOGIN DROPDOWN -->
</ul>
</div>
<!-- END TOP NAVIGATION MENU -->
</div>
</div>
<!-- END HEADER TOP -->
<!-- BEGIN HEADER MENU -->
<div class="page-header-menu">
    <div class="page-container">
        <!-- BEGIN MEGA MENU -->
        <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
        <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->

        <div class="hor-menu">
            <ul class="nav navbar-nav">
                <? foreach($departments as $department) : ?>
                    <li class="nav-<?= $department->icons ?> <? if($department->id==$department_active) : ?>active<? endif; ?>">
                        <a href="<?= Url::toRoute(['/departments','id' => $department->id]) ?>"><span class="ico-<?= $department->icons ?>"></span><?= $department->name ?></a>
                    </li>
                <? endforeach; ?>

            </ul>
        </div>
        <!-- END MEGA MENU -->
    </div>
</div>
<!-- END HEADER MENU -->
</div>
<!-- END HEADER -->

<div class="page-container">
    <div class="page-content-wrapper">
        <div class="page-content">
            <?= $content ?>
        </div>
    </div>
</div>
<!-- Center Wrap END -->

<!-- BEGIN QUICK SIDEBAR TOGGLER -->
<!-- <button type="button" class="quick-sidebar-toggler quick-sidebar-toggler-chat" data-toggle="collapse">
    <span class="sr-only">Toggle Quick Sidebar</span>
    <i class="icon-logout"></i>
</button> -->
<!-- END QUICK SIDEBAR TOGGLER -->

<!-- BEGIN QUICK SIDEBAR -->

<a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-login"></i></a>
<div class="page-quick-sidebar-wrapper">
<div class="page-quick-sidebar">
<div class="nav-justified">
<ul class="nav nav-tabs nav-justified">
    <li class="active">
        <a href="#quick_sidebar_tab_1" data-toggle="tab">
            Users <span class="badge badge-danger">2</span>
        </a>
    </li>
    <li>
        <a href="#quick_sidebar_tab_2" data-toggle="tab">
            Alerts <span class="badge badge-success">7</span>
        </a>
    </li>
    <li class="dropdown">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
            More<i class="fa fa-angle-down"></i>
        </a>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>
                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                    <i class="icon-bell"></i> Alerts </a>
            </li>
            <li>
                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                    <i class="icon-info"></i> Notifications </a>
            </li>
            <li>
                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                    <i class="icon-speech"></i> Activities </a>
            </li>
            <li class="divider">
            </li>
            <li>
                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                    <i class="icon-settings"></i> Settings </a>
            </li>
        </ul>
    </li>
</ul>
<div class="tab-content">
<div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
<div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
    <h3 class="list-heading">Staff</h3>
    <ul class="media-list list-items">
        <li class="media">
            <div class="media-status">
                <span class="badge badge-success">8</span>
            </div>
            <img class="media-object" src="/metronic/theme/assets/layouts/layout3/img/avatar3.jpg" alt="...">
            <div class="media-body">
                <h4 class="media-heading">Bob Nilson</h4>
                <div class="media-heading-sub">
                    Project Manager
                </div>
            </div>
        </li>
        <li class="media">
            <img class="media-object" src="/metronic/theme/assets/layouts/layout3/img/avatar1.jpg" alt="...">
            <div class="media-body">
                <h4 class="media-heading">Nick Larson</h4>
                <div class="media-heading-sub">
                    Art Director
                </div>
            </div>
        </li>
        <li class="media">
            <div class="media-status">
                <span class="badge badge-danger">3</span>
            </div>
            <img class="media-object" src="/metronic/theme/assets/layouts/layout3/img/avatar4.jpg" alt="...">
            <div class="media-body">
                <h4 class="media-heading">Deon Hubert</h4>
                <div class="media-heading-sub">
                    CTO
                </div>
            </div>
        </li>
        <li class="media">
            <img class="media-object" src="/metronic/theme/assets/layouts/layout3/img/avatar2.jpg" alt="...">
            <div class="media-body">
                <h4 class="media-heading">Ella Wong</h4>
                <div class="media-heading-sub">
                    CEO
                </div>
            </div>
        </li>
    </ul>
    <h3 class="list-heading">Customers</h3>
    <ul class="media-list list-items">
        <li class="media">
            <div class="media-status">
                <span class="badge badge-warning">2</span>
            </div>
            <img class="media-object" src="/metronic/theme/assets/layouts/layout3/img/avatar6.jpg" alt="...">
            <div class="media-body">
                <h4 class="media-heading">Lara Kunis</h4>
                <div class="media-heading-sub">
                    CEO, Loop Inc
                </div>
                <div class="media-heading-small">
                    Last seen 03:10 AM
                </div>
            </div>
        </li>
        <li class="media">
            <div class="media-status">
                <span class="label label-sm label-success">new</span>
            </div>
            <img class="media-object" src="/metronic/theme/assets/layouts/layout3/img/avatar7.jpg" alt="...">
            <div class="media-body">
                <h4 class="media-heading">Ernie Kyllonen</h4>
                <div class="media-heading-sub">
                    Project Manager,<br>
                    SmartBizz PTL
                </div>
            </div>
        </li>
        <li class="media">
            <img class="media-object" src="/metronic/theme/assets/layouts/layout3/img/avatar8.jpg" alt="...">
            <div class="media-body">
                <h4 class="media-heading">Lisa Stone</h4>
                <div class="media-heading-sub">
                    CTO, Keort Inc
                </div>
                <div class="media-heading-small">
                    Last seen 13:10 PM
                </div>
            </div>
        </li>
        <li class="media">
            <div class="media-status">
                <span class="badge badge-success">7</span>
            </div>
            <img class="media-object" src="/metronic/theme/assets/layouts/layout3/img/avatar9.jpg" alt="...">
            <div class="media-body">
                <h4 class="media-heading">Deon Portalatin</h4>
                <div class="media-heading-sub">
                    CFO, H&D LTD
                </div>
            </div>
        </li>
        <li class="media">
            <img class="media-object" src="/metronic/theme/assets/layouts/layout3/img/avatar10.jpg" alt="...">
            <div class="media-body">
                <h4 class="media-heading">Irina Savikova</h4>
                <div class="media-heading-sub">
                    CEO, Tizda Motors Inc
                </div>
            </div>
        </li>
        <li class="media">
            <div class="media-status">
                <span class="badge badge-danger">4</span>
            </div>
            <img class="media-object" src="/metronic/theme/assets/layouts/layout3/img/avatar11.jpg" alt="...">
            <div class="media-body">
                <h4 class="media-heading">Maria Gomez</h4>
                <div class="media-heading-sub">
                    Manager, Infomatic Inc
                </div>
                <div class="media-heading-small">
                    Last seen 03:10 AM
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="page-quick-sidebar-item">
    <div class="page-quick-sidebar-chat-user">
        <div class="page-quick-sidebar-nav">
            <a href="javascript:;" class="page-quick-sidebar-back-to-list"><i class="icon-arrow-left"></i>Back</a>
        </div>
        <div class="page-quick-sidebar-chat-user-messages">
            <div class="post out">
                <img class="avatar" alt="" src="/metronic/theme/assets/layouts/layout3/img/avatar3.jpg"/>
                <div class="message">
                    <span class="arrow"></span>
                    <a href="javascript:;" class="name">Bob Nilson</a>
                    <span class="datetime">20:15</span>
													<span class="body">
													When could you send me the report ? </span>
                </div>
            </div>
            <div class="post in">
                <img class="avatar" alt="" src="/metronic/theme/assets/layouts/layout3/img/avatar2.jpg"/>
                <div class="message">
                    <span class="arrow"></span>
                    <a href="javascript:;" class="name">Ella Wong</a>
                    <span class="datetime">20:15</span>
													<span class="body">
													Its almost done. I will be sending it shortly </span>
                </div>
            </div>
            <div class="post out">
                <img class="avatar" alt="" src="/metronic/theme/assets/layouts/layout3/img/avatar3.jpg"/>
                <div class="message">
                    <span class="arrow"></span>
                    <a href="javascript:;" class="name">Bob Nilson</a>
                    <span class="datetime">20:15</span>
													<span class="body">
													Alright. Thanks! :) </span>
                </div>
            </div>
            <div class="post in">
                <img class="avatar" alt="" src="/metronic/theme/assets/layouts/layout3/img/avatar2.jpg"/>
                <div class="message">
                    <span class="arrow"></span>
                    <a href="javascript:;" class="name">Ella Wong</a>
                    <span class="datetime">20:16</span>
													<span class="body">
													You are most welcome. Sorry for the delay. </span>
                </div>
            </div>
            <div class="post out">
                <img class="avatar" alt="" src="/metronic/theme/assets/layouts/layout3/img/avatar3.jpg"/>
                <div class="message">
                    <span class="arrow"></span>
                    <a href="javascript:;" class="name">Bob Nilson</a>
                    <span class="datetime">20:17</span>
													<span class="body">
													No probs. Just take your time :) </span>
                </div>
            </div>
            <div class="post in">
                <img class="avatar" alt="" src="/metronic/theme/assets/layouts/layout3/img/avatar2.jpg"/>
                <div class="message">
                    <span class="arrow"></span>
                    <a href="javascript:;" class="name">Ella Wong</a>
                    <span class="datetime">20:40</span>
													<span class="body">
													Alright. I just emailed it to you. </span>
                </div>
            </div>
            <div class="post out">
                <img class="avatar" alt="" src="/metronic/theme/assets/layouts/layout3/img/avatar3.jpg"/>
                <div class="message">
                    <span class="arrow"></span>
                    <a href="javascript:;" class="name">Bob Nilson</a>
                    <span class="datetime">20:17</span>
													<span class="body">
													Great! Thanks. Will check it right away. </span>
                </div>
            </div>
            <div class="post in">
                <img class="avatar" alt="" src="/metronic/theme/assets/layouts/layout3/img/avatar2.jpg"/>
                <div class="message">
                    <span class="arrow"></span>
                    <a href="javascript:;" class="name">Ella Wong</a>
                    <span class="datetime">20:40</span>
													<span class="body">
													Please let me know if you have any comment. </span>
                </div>
            </div>
            <div class="post out">
                <img class="avatar" alt="" src="/metronic/theme/assets/layouts/layout3/img/avatar3.jpg"/>
                <div class="message">
                    <span class="arrow"></span>
                    <a href="javascript:;" class="name">Bob Nilson</a>
                    <span class="datetime">20:17</span>
													<span class="body">
													Sure. I will check and buzz you if anything needs to be corrected. </span>
                </div>
            </div>
        </div>
        <div class="page-quick-sidebar-chat-user-form">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Type a message here...">
                <div class="input-group-btn">
                    <button type="button" class="btn blue"><i class="icon-paper-clip"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
    <div class="page-quick-sidebar-alerts-list">
        <h3 class="list-heading">General</h3>
        <ul class="feeds list-items">
            <li>
                <div class="col1">
                    <div class="cont">
                        <div class="cont-col1">
                            <div class="label label-sm label-info">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="cont-col2">
                            <div class="desc">
                                New order received with <span class="label label-sm label-danger">
															Reference Number: DR23923 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <div class="date">
                        30 mins
                    </div>
                </div>
            </li>
            <li>
                <div class="col1">
                    <div class="cont">
                        <div class="cont-col1">
                            <div class="label label-sm label-success">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <div class="cont-col2">
                            <div class="desc">
                                You have 5 pending membership that requires a quick review.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <div class="date">
                        24 mins
                    </div>
                </div>
            </li>
            <li>
                <div class="col1">
                    <div class="cont">
                        <div class="cont-col1">
                            <div class="label label-sm label-danger">
                                <i class="fa fa-bell-o"></i>
                            </div>
                        </div>
                        <div class="cont-col2">
                            <div class="desc">
                                Web server hardware needs to be upgraded. <span class="label label-sm label-warning">
															Overdue </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <div class="date">
                        2 hours
                    </div>
                </div>
            </li>
            <li>
                <a href="javascript:;">
                    <div class="col1">
                        <div class="cont">
                            <div class="cont-col1">
                                <div class="label label-sm label-default">
                                    <i class="fa fa-briefcase"></i>
                                </div>
                            </div>
                            <div class="cont-col2">
                                <div class="desc">
                                    IPO Report for year 2013 has been released.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col2">
                        <div class="date">
                            20 mins
                        </div>
                    </div>
                </a>
            </li>
        </ul>
        <h3 class="list-heading">System</h3>
        <ul class="feeds list-items">
            <li>
                <div class="col1">
                    <div class="cont">
                        <div class="cont-col1">
                            <div class="label label-sm label-info">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="cont-col2">
                            <div class="desc">
                                New order received with <span class="label label-sm label-success">
															Reference Number: DR23923 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <div class="date">
                        30 mins
                    </div>
                </div>
            </li>
            <li>
                <div class="col1">
                    <div class="cont">
                        <div class="cont-col1">
                            <div class="label label-sm label-success">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <div class="cont-col2">
                            <div class="desc">
                                You have 5 pending membership that requires a quick review.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <div class="date">
                        24 mins
                    </div>
                </div>
            </li>
            <li>
                <div class="col1">
                    <div class="cont">
                        <div class="cont-col1">
                            <div class="label label-sm label-warning">
                                <i class="fa fa-bell-o"></i>
                            </div>
                        </div>
                        <div class="cont-col2">
                            <div class="desc">
                                Web server hardware needs to be upgraded. <span class="label label-sm label-default ">
															Overdue </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <div class="date">
                        2 hours
                    </div>
                </div>
            </li>
            <li>
                <a href="javascript:;">
                    <div class="col1">
                        <div class="cont">
                            <div class="cont-col1">
                                <div class="label label-sm label-info">
                                    <i class="fa fa-briefcase"></i>
                                </div>
                            </div>
                            <div class="cont-col2">
                                <div class="desc">
                                    IPO Report for year 2013 has been released.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col2">
                        <div class="date">
                            20 mins
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
    <div class="page-quick-sidebar-settings-list">
        <h3 class="list-heading">General Settings</h3>
        <ul class="list-items borderless">
            <li>
                Enable Notifications <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF">
            </li>
            <li>
                Allow Tracking <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF">
            </li>
            <li>
                Log Errors <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF">
            </li>
            <li>
                Auto Sumbit Issues <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF">
            </li>
            <li>
                Enable SMS Alerts <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF">
            </li>
        </ul>
        <h3 class="list-heading">System Settings</h3>
        <ul class="list-items borderless">
            <li>
                Security Level
                <select class="form-control input-inline input-sm input-small">
                    <option value="1">Normal</option>
                    <option value="2" selected>Medium</option>
                    <option value="e">High</option>
                </select>
            </li>
            <li>
                Failed Email Attempts <input class="form-control input-inline input-sm input-small" value="5"/>
            </li>
            <li>
                Secondary SMTP Port <input class="form-control input-inline input-sm input-small" value="3560"/>
            </li>
            <li>
                Notify On System Error <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF">
            </li>
            <li>
                Notify On SMTP Error <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF">
            </li>
        </ul>
        <div class="inner-content">
            <button class="btn btn-success"><i class="icon-settings"></i> Save Changes</button>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<!-- END QUICK SIDEBAR -->


<!-- BEGIN PRE-FOOTER -->
<!-- END PRE-FOOTER -->


</div>


<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="container">
        2015 © BSB<br>All rights reserved
    </div>
</div>
<!-- END FOOTER-->

<div class="scroll-to-top">
    <i class="icon-arrow-up"></i>
</div>

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php $this->endBody() ?>

<script>
    $( document ).ready(function() {
        $(".navbar-ico-nav-toggler").click(function(){
            $("#navbar-ico-nav").toggle('slow');
            //$("#header_notification_bar").toggle('slow');
            //$("#header_task_bar").toggle('slow');
        });
        $(document).click(function(event) {
            if ($(event.target).closest(".navbar-ico-nav-toggler").length) return;
            if ($("#navbar-ico-nav").length)
            {
                if($( window ).width() < 992) {
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
</body>
<!-- END BODY -->
</html>
<?php $this->endPage() ?>