<?php

use yii\web\View;
use yii\web\JqueryAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

// jquery.js + bootstrap.js + bootstrap.css

/**
 * @var string $content
 */

$identity = Yii::$app->user->identity;

$userMod = Yii::$app->getModule('user');

$this->beginPage();
?>

    <html lang="<?= Yii::$app->language ?>" style="background: #3a3a3a;">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>BSB | Dashboard</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <!-- <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'> -->

        <?

        $this->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->getRequest()->csrfParam], 'csrf-param');
        $this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->getRequest()->getCsrfToken()], 'csrf-token');

        // BEGIN GLOBAL MANDATORY STYLES
        $this->registerCssFile("/fonts/Open Sans/OpenSans.css");
        $this->registerCssFile("/fonts/Raleway/Raleway-Regular.css");
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
        $this->registerCssFile("/metronic/theme/assets/global/plugins/morris/morris.css");
        $this->registerCssFile("/metronic/theme/assets/global/plugins/fullcalendar/fullcalendar.min.css");
        $this->registerCssFile("/metronic/theme/assets/global/plugins/jqvmap/jqvmap/jqvmap.css");
        $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-summernote/summernote.css");
        $this->registerCssFile("/metronic/theme/assets/global/plugins/jquery-minicolors/jquery.minicolors.css");

        //BEGIN THEME GLOBAL STYLES
        $this->registerCssFile("/metronic/theme/assets/global/css/components.min.css");
        $this->registerCssFile("/metronic/theme/assets/global/css/plugins.min.css");

        //BEGIN THEME LAYOUT STYLES
        $this->registerCssFile("/metronic/theme/assets/layouts/layout/css/layout.min.css");
        $this->registerCssFile("/metronic/theme/assets/layouts/layout/css/themes/darkblue.min.css");
        $this->registerCssFile("/metronic/theme/assets/layouts/layout/css/custom.min.css");

        $this->registerCssFile("/icomoon/style.css");
        $this->registerCssFile("/css/custom.css");

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
        $this->registerJsFile("/metronic/theme/assets/layouts/layout/scripts/demo.min.js", $pos);
        $this->registerJsFile("/metronic/theme/assets/layouts/global/scripts/quick-sidebar.min.js", $pos);

        $msgJs = <<<JS
        jQuery(document).ready(function() {

             });
JS;
        $this->registerJs($msgJs, View::POS_HEAD);
        ?>

        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="/favicon.ico"/>

        <?php $this->head() ?>
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <?php $this->beginBody() ?>


    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
    <!-- BEGIN LOGO -->
    <div class="page-logo">
        <a href="<?= Url::toRoute(['/']) ?>">
            <img src="/images/logo-default.png" alt="logo" class="logo-default" /> </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
    <!-- END RESPONSIVE MENU TOGGLER -->
    <!-- BEGIN TOP NAVIGATION MENU -->
    <div class="top-menu">
    <ul class="nav navbar-nav pull-right">
    <!-- BEGIN NOTIFICATION DROPDOWN -->
    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
    <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="icon-bell"></i>
            <span class="badge badge-default"> 7 </span>
        </a>
        <ul class="dropdown-menu">
            <li class="external">
                <h3>
                    <span class="bold">12 pending</span> notifications</h3>
                <a href="page_user_profile_1.html">view all</a>
            </li>
            <li>
                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                    <li>
                        <a href="javascript:;">
                            <span class="time">just now</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-plus"></i>
                                                    </span> New user registered. </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="time">3 mins</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> Server #12 overloaded. </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="time">10 mins</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </span> Server #2 not responding. </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="time">14 hrs</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </span> Application error. </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="time">2 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> Database overloaded 68%. </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="time">3 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> A user IP blocked. </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="time">4 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-warning">
                                                        <i class="fa fa-bell-o"></i>
                                                    </span> Storage Server #4 not responding dfdfdfd. </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="time">5 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-info">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </span> System Error. </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="time">9 days</span>
                                                <span class="details">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> Storage server failed. </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <!-- END NOTIFICATION DROPDOWN -->
    <!-- BEGIN INBOX DROPDOWN -->
    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
    <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="icon-envelope-open"></i>
            <span class="badge badge-default"> 4 </span>
        </a>
        <ul class="dropdown-menu">
            <li class="external">
                <h3>You have
                    <span class="bold">7 New</span> Messages</h3>
                <a href="app_inbox.html">view all</a>
            </li>
            <li>
                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                    <li>
                        <a href="#">
                                                <span class="photo">
                                                    <img src="/metronic/theme/assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Lisa Wong </span>
                                                    <span class="time">Just Now </span>
                                                </span>
                            <span class="message"> Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                                <span class="photo">
                                                    <img src="/metronic/theme/assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Richard Doe </span>
                                                    <span class="time">16 mins </span>
                                                </span>
                            <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                                <span class="photo">
                                                    <img src="/metronic/theme/assets/layouts/layout3/img/avatar1.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Bob Nilson </span>
                                                    <span class="time">2 hrs </span>
                                                </span>
                            <span class="message"> Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                                <span class="photo">
                                                    <img src="/metronic/theme/assets/layouts/layout3/img/avatar2.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Lisa Wong </span>
                                                    <span class="time">40 mins </span>
                                                </span>
                            <span class="message"> Vivamus sed auctor 40% nibh congue nibh... </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                                <span class="photo">
                                                    <img src="/metronic/theme/assets/layouts/layout3/img/avatar3.jpg" class="img-circle" alt=""> </span>
                                                <span class="subject">
                                                    <span class="from"> Richard Doe </span>
                                                    <span class="time">46 mins </span>
                                                </span>
                            <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <!-- END INBOX DROPDOWN -->
    <!-- BEGIN TODO DROPDOWN -->
    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
    <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="icon-calendar"></i>
            <span class="badge badge-default"> 3 </span>
        </a>
        <ul class="dropdown-menu extended tasks">
            <li class="external">
                <h3>You have
                    <span class="bold">12 pending</span> tasks</h3>
                <a href="app_todo.html">view all</a>
            </li>
            <li>
                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                    <li>
                        <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">New release v1.2 </span>
                                                    <span class="percent">30%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </span>
                                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Application deployment</span>
                                                    <span class="percent">65%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">65% Complete</span>
                                                    </span>
                                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Mobile app release</span>
                                                    <span class="percent">98%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 98%;" class="progress-bar progress-bar-success" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">98% Complete</span>
                                                    </span>
                                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Database migration</span>
                                                    <span class="percent">10%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">10% Complete</span>
                                                    </span>
                                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Web server upgrade</span>
                                                    <span class="percent">58%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 58%;" class="progress-bar progress-bar-info" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">58% Complete</span>
                                                    </span>
                                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">Mobile development</span>
                                                    <span class="percent">85%</span>
                                                </span>
                                                <span class="progress">
                                                    <span style="width: 85%;" class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">85% Complete</span>
                                                    </span>
                                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                                                <span class="task">
                                                    <span class="desc">New UI release</span>
                                                    <span class="percent">38%</span>
                                                </span>
                                                <span class="progress progress-striped">
                                                    <span style="width: 38%;" class="progress-bar progress-bar-important" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">38% Complete</span>
                                                    </span>
                                                </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
    <!-- END TODO DROPDOWN -->
    <!-- BEGIN USER LOGIN DROPDOWN -->
    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
    <li class="dropdown dropdown-user">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <img alt="" class="img-circle" src="/metronic/theme/assets/layouts/layout/img/avatar3_small.jpg" />
            <span class="username username-hide-on-mobile"> Nick </span>
            <i class="fa fa-angle-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-default">
            <li>
                <a href="page_user_profile_1.html">
                    <i class="icon-user"></i> My Profile </a>
            </li>
            <li>
                <a href="app_calendar.html">
                    <i class="icon-calendar"></i> My Calendar </a>
            </li>
            <li>
                <a href="app_inbox.html">
                    <i class="icon-envelope-open"></i> My Inbox
                    <span class="badge badge-danger"> 3 </span>
                </a>
            </li>
            <li>
                <a href="app_todo.html">
                    <i class="icon-rocket"></i> My Tasks
                    <span class="badge badge-success"> 7 </span>
                </a>
            </li>
            <li class="divider"> </li>
            <li>
                <a href="page_user_lock_1.html">
                    <i class="icon-lock"></i> Lock Screen </a>
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
    <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse in">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <? require_once __DIR__ . '/menu/_left.php'; ?>
    <!-- END SIDEBAR MENU -->
    <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <?= $content ?>

    </div>
    <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner"> 2014 &copy; Metronic by keenthemes.
            <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase Metronic!</a>
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->

    <?php $this->endBody() ?>
    </body>
    </html>

<?php $this->endPage() ?>