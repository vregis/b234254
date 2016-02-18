<?php

use common\modules\core\models\Settings;
use common\modules\core\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\web\View;


$siteName = Settings::getCoreSettingsByOption('siteName');
$siteDescription = Settings::getCoreSettingsByOption('siteDescription');
$siteKeywords = Settings::getCoreSettingsByOption('siteKeywords');

$this->beginPage();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title><?= $this->encode($siteName) ?></title>
    <link rel="icon" type="image/x-icon" href="<?= Yii::$app->params['frontendDomain'] ?>images/favicon.ico">

    <?php
    $this->registerMetaTag(['keywords' => $siteKeywords]);
    $this->registerMetaTag(['description' => $siteDescription]);
    $this->registerMetaTag(['charset' => Yii::$app->charset]);

    //chat
    $this->registerCssFile('/style/jquery/tooltipster.css');
    //$this->registerCssFile('/style/chat/style.css');
    //js
    $pos = View::POS_HEAD;
    $jsOptions = ['position' => $pos /*, 'depends' => [JqueryAsset::className()]*/];
    // JqueryAsset::register($this);
    $this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js', ['position' => $pos]);
    $this->registerJsFile('/js/lib/jquery-migrate-1.1.1.min.js', $jsOptions);
    //chat
    //$this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js',$jsOptions
    $this->registerJsFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js',$jsOptions);
    $this->registerJsFile('/js/chat/dialog.js', $jsOptions);
    $this->registerJsFile('/js/chat/chat.js', $jsOptions);
    $this->registerJsFile('/js/lib/jquery.tooltipster.min.js', $jsOptions);

    //rebuild
    //<!-- Mobile Specific Metas  -->
    $this->registerMetaTag(["width" => "device-width", "initial-scale" => "1", "maximum-scale" => "1"], "viewport");
    //<!-- Web Fonts  -->
    $this->registerCssFile('http://fonts.googleapis.com/css?family=Raleway:400,700,600,500,300');
    $this->registerCssFile('http://fonts.googleapis.com/css?family=Oswald:400,700,300');
    $this->registerCssFile('http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,500,300');

    //<!-- Theme Style -->
    $this->registerCssFile("/rebuild/css/theme.css");
    $this->registerCssFile("/rebuild/css/theme-animate.css");
    $this->registerCssFile("/rebuild/css/theme-elements.css");
    $this->registerCssFile("/rebuild/css/plugins.css");

    //<!-- Skin CSS -->
    $this->registerCssFile("/rebuild/css/skins/blue.css");
    //<!-- Icon Fonts -->
    $this->registerCssFile('/rebuild/fonts/font-awesome.min.css');

    //<!-- Library Css -->
    $this->registerCssFile("/rebuild/css/skeleton.css");
    $this->registerCssFile("/rebuild/vendor/flexslider/flexslider.css");

    $this->registerCssFile("/rebuild/vendor/isotope/isotope.css");
    $this->registerCssFile("/rebuild/vendor/owl/owl.carousel.css");
    $this->registerCssFile("/rebuild/vendor/prettyPhoto/prettyPhoto.css");
    $this->registerCssFile("/rebuild/vendor/rs-plugin/css/settings.css");

    //<!-- Responsive Theme -->
    $this->registerCssFile("/rebuild/css/theme-responsive.css");

    //<!-- Library Js -->
    $this->registerJsFile("/rebuild/vendor/modernizr.js");

    //<!-- Google Map -->
    $this->registerJsFile("http://maps.google.com/maps/api/js?sensor=false");

    $this->registerCssFile("/style/rebuild/main.css");

    $msgTimeout = $this->context->module->id == 'message' ? 25000 : 210000;
    $msgJs = <<<JS
        if (typeof disableTimeoutAjax == 'undefined') {
            setInterval(function () {
                loadMessages();
            }, {$msgTimeout});
        }
JS;
    $this->registerJs($msgJs);

    echo $this->renderHeadHtml();
    ?>

    <!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
    <!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
    <!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->

    <!--[if IE]>
    <link rel="stylesheet" href="/rebuild/css/ie.css">
    <![endif]-->
    <!--[if lte IE 8]>
    <script src="/rebuild/vendor/respond.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?php // отключаем отправку AJAX запросов по таймауту ?>
    <?php if (isset(Yii::$app->params['disableTimeoutAjax']) && Yii::$app->params['disableTimeoutAjax']): ?>
        <?php $this->registerJs('var disableTimeoutAjax = true;', $this::POS_END) ?>
    <?php endif ?>

    <?= Html::csrfMetaTags() ?>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- BOF Header -->

<header>
<!-- BOF Top Bar -->
<div class="jx-header-1">

    <!-- BDF TOOLBAR -->
    <div class="jx-topbar">
        <div class="container">

            <!--     <div class="eight columns left">
                    <div class="jx-left-topbar">Welcome to REBUILD . Creative HTML Template</div>
                </div> -->
                <!-- Left Items -->

            <div class="eight columns right">
                <?php
                if ($this->getIsGuest()) {
                    echo $this->render('//layouts/_partial/menu_guest');
                } else {
                    echo $this->render('//layouts/_partial/menu_user');
                }
                ?>


            </div>
            <!-- Right Items -->
        </div>
    </div>
    <!-- EDF TOOLBAR -->

    <div class="jx-header header-line">
        <div class="container">

            <div class="four columns">
                <div class="header-logo">
                    <a href="/"><img src="/images/main-logo.png" alt="" /></a>
                </div>
                <!-- Logo -->
            </div>

            <div class="twelve columns">

                <div class="header-info">
                    <div class="toll-free"><i class="fa fa-phone"></i> TOLL FREE</div>
                    <ul>
                        <li class="top-space">
                            <div class="icon"><i class="fa fa-map-marker"></i></div>
                            <div class="position">
                                <div class="location">Location</div>
                                <div class="address">SOUTH REVEN, USA</div>
                            </div>
                        </li>

                        <li class="top-space">
                            <div class="icon"><i class="fa fa-clock-o"></i></div>
                            <div class="position">
                                <div class="time">Office Timing</div>
                                <div class="date">SUN - FRI 8:00 - 22:00</div>
                            </div>
                        </li>

                        <li>
                            <div class="toll-free-number">801 21 7600</div>
                        </li>
                    </ul>
                </div>
                <!-- Header Info -->
            </div>
        </div>
    </div>

</div>
<!-- EOF Top Bar -->
<!-- EDF Header -->

<div class="jx-menu-holder jx-sticky">
    <div class="container">

        <div class="header-menu-left">

            <div class="nav_container">
                <ul id="jx-main-menu" class="menu">
                    <li><a href="/games">Игры</a></li>
                    <li><a href="/tournament">Турниры</a></li>
                    <li><a href="/store">Магазин</a></li>
                    <li><a href="/news">Проект</a></li>

                    <li class="with-sub"><a href="#">Скин</a>

                        <ul class="submenu">
                            <li class="col">
                                <ul>
                                    <li><a href="projects.html">Классический</a></li>
                                    <li><a href="grid-projects.html">Лава</a></li>
                                    <li><a href="project-view.html">Шестеренки</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- EOF Menu -->
        </div>

        <!-- MENU -->

    </div>
</div>
<!-- BOF Main Menu -->

</header>


<div id="onlyUserMessage" style="display: none;">
    <?= Yii::t('user', 'Для выполнения данного действия необходимо авторизироваться') ?>
    <br>
    <?= Html::a(Yii::t('user', 'Войти через Steam'), ['/user/login']) ?>
</div>

<div id="preloadedImages"></div>


<!--
<header>



    <?php  echo $this->render('//layouts/_partial/menu_moderator'); ?>

    <div class="content-background">
        <div class="left"></div>
    </div>


    <table class="header">
        <tr>
            <td class="left">&nbsp;</td>
            <td class="center">
                <?php
                if ($this->getIsGuest()) {
                    echo $this->render('//layouts/_partial/menu_guest');
                } else {
                    echo $this->render('//layouts/_partial/menu_user');
                }
                ?>

            </td>
            <td class="right">&nbsp;</td>
        </tr>
    </table>
</header>

<div class="container-main-navigation">
    <?php if (!empty($this->params['breadcrumbs'])): ?>
        <div class="main-navigation">
            <?
       /*     Breadcrumbs::widget(
                [
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'homeLink' => [
                        'label' => Yii::t('core', 'Главная'),
                        'url' => Yii::$app->homeUrl,
                    ],
                    'tag' => 'ol',
                    'itemTemplate' => "<li>{link}</li><li>/</li>\n"
                ]
            )*/
            ?>
        </div>
    <?php endif ?>
</div>
