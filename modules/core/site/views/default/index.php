<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\core\widgets\Flash;
?>
<!DOCTYPE html>
<!--[if lt IE 9 ]><html class="ie ie-lt9 no-js" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9 no-js" lang="en"><![endif]-->
<!--[if gt IE 9 | !IE]><!-->
<? $this->beginPage(); ?>
<html class="no-js fixed" lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>Big S Business</title>
    <?php $this->registerCssFile("/plugins/bsb-icons/style.css"); ?>
    <link href="/fonts/Open Sans/OpenSans.css" rel="stylesheet">
    <link rel='stylesheet' href='/css/mainpage/bootstrap.min.css'>
    <link rel='stylesheet' href='/metronic/theme/assets/global/plugins/simple-line-icons/simple-line-icons.css'>





    <?php
    $this->registerJsFile("/js/global/index.js");
    $this->registerJsFile("/js/bootbox.min.js");
    $this->registerJsFile("/js/jquery.blockui.min.js");
    $this->registerJsFile("/js/app.js");
    $this->registerCssFile("/plugins/venobox/venobox.css");
    $this->registerJsFile("/plugins/venobox/venobox.min.js");
    ?>
    <link rel='stylesheet' href='/css/mainpage/style.css'>
    <link rel='stylesheet' href='/css/mainpage/color.css'>
    <link rel='stylesheet' href='/css/mainpage/title-size.css'>
    <link rel='stylesheet' href='/css/mainpage/custom.css'>
    <link rel="icon" href="/images/mainpage/favicon.ico">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= Flash::widget(['view' => '@modules/core/widgets/views/dialog']) ?>

<!-- loader -->
<div id="site-loader">
    <div class="loader"></div>
</div>
<!-- loader -->

<!-- backgeound -->
<div id="bg">
    <div id="img"></div>
    <div id="video"></div>
    <div id="overlay"></div>
    <div id="effect">
        <img src="/images/mainpage/bg/cloud-01.png" alt="" id="cloud1">
        <img src="/images/mainpage/bg/cloud-02.png" alt="" id="cloud2">
        <img src="/images/mainpage/bg/cloud-03.png" alt="" id="cloud3">
        <img src="/images/mainpage/bg/cloud-04.png" alt="" id="cloud4">
    </div>
    <canvas id="js-canvas"></canvas>
</div>
<!-- /background -->

<!-- site header -->
<header id="site-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">

                <!-- header brand -->
                <div class="header-brand">
                    <img class="header-logo logo-light" src="/images/mainpage/logo-light.png" alt="">
                    <img class="header-logo logo-dark" src="/images/mainpage/logo-dark.png" alt="">
                    <span class="alpha">Alpha version</span>
                </div>

                <!-- header brand -->
                <?php if(Yii::$app->user->isGuest): ?>
<!--                 <div class="small-login">
                    <form method="post" class="form-inline" action="/user/security/login-from-main-page" autocomplete="off">
                        <div class="form-group">
                            <div class="input-icon"><i class="ico-mail"></i><input type="text" id="loginform-email" class="form-control1 placeholder-no-fix" name="LoginForm[email]" placeholder="Email" autocomplete="off"></div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon"><i class="ico-pass"></i><input type="password" id="loginform-password" class="form-control1 placeholder-no-fix" name="LoginForm[password]" placeholder="Password"  autocomplete="off"></div>
                        </div>
                        <button type="submit" class="btn btn-default"><i class="ico-login"></i></button>
                    </form>
                </div> -->
                <?php endif; ?>
                <!-- header toggle-->


                <!-- /header toggle -->
            </div>
        </div>
    </div>
</header>
<!-- /site header -->

<!-- subscribe -->
<div id="form">
    <div id="subscribe">
        <div class="tb-cell">
            <p class="animation section-subtitle">Subscribe to get notified.</p>
            <h2 class="section-title">Newsletter</h2>
            <!-- subscribe form -->
            <form id="form-subscribe" class="form-lg container">
                <input type="text" name="email" class="form-control1" placeholder="Email address">
                <button type="submit">
                    <i class="ion-email"></i>
                </button>
            </form>
            <!-- /subscribe form -->
        </div>
    </div>
</div>
<!-- /subscribe -->

<!-- subscribe -->
<div id="login" style="display:none">
    <div id="subscribe">
        <div class="tb-cell">
            <h2 class="section-title">Login to your account</h2>
            <!-- subscribe form -->
            <?php $form = ActiveForm::begin(
                [
                    'id' => 'form-subscribe',
                    'class'=>'form-lg login-form',
                    'action'=>'/user/security/login',
                ]
            ) ?>
           <!-- <h3 class="form-title">Login to your account</h3>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <div class="has-error"><?//= $form->errorSummary($model, ['class' => 'help-block']) ?></div>
			<span>
			Enter any username and password. </span>
            </div>-->
            <?=
            $form->field($model, 'email', [
                'template' => '{label}<div class="input-icon"><i class="fa fa-envelope-o"></i>{input}</div>{error}',
            ])->textInput(
                [
                    'class' => 'form-control1 placeholder-no-fix',
                    'placeholder' => 'E-mail'
                ]
            )->label(false)  ?>
            <?=
            $form->field($model, 'password', [
                'template' => '{label}<div class="input-icon"><i class="fa fa-lock"></i>{input}</div>{error}',
            ])->passwordInput(
                [
                    'class' => 'form-control1 placeholder-no-fix',
                    'placeholder' => 'Password'
                ]
            )->label(false) ?>
            <div class="form-actions">
                <?= $form->field($model, 'rememberMe', ['template' => '{input}' . Html::submitButton('Login <i class="m-icon-swapright m-icon-white"></i>', ['class' => 'btn btn-primary login_btn', 'style'=>'position:relative; width:100%'])])->checkbox();?>
            </div>
            <?php ActiveForm::end() ?>
            <!-- /subscribe form -->
        </div>
    </div>
</div>
<!-- /subscribe -->
<div class="planet">
    <a href="<?= Url::toRoute(['/departments']) ?>" class="enter-btn"><div class="hover"></div></a>
</div>

<!-- site main -->
<main id="site-main">
    <!-- home -->
    <section id="home">
        <div class="section-wrap">
            <div class="section-cell">
                <div class="container">
                    <!-- section header -->
                    <div class="section-header row text-center">
                        <div style="margin-top:50px;" class="col-xs-12">

                            <h1 class="section-title">
                                <span class="section-title-span">Business without Bus<span style="color:#d05454;">Y</span>ness</span>
                                <!-- <span class="section-title-span">New Line Title</span> -->
                            </h1>
                            <div class="animation section-divider"></div>
                        </div>
                    </div>
                    <!-- /setion header -->

                    <!-- section main -->
                    <div class="section-main row">
                        <div class="col-xs-12">

                            <img class="steps" style="margin:auto;" src="/images/mainpage/startblock.png">

                            <!-- /countdown -->
                        </div>
                    </div>
                    <!-- /setion main -->
                </div>
            </div>
        </div>
    </section>
    <!-- /home -->

</main>
<!-- /site main -->

<!-- site footer -->
<footer id="site-footer" class="text-center">
    <a data-type="youtube" href="http://youtu.be/Xo5IrI7yfjA" class="venobox btn btn-primary btn-empty btn-icon play"><i class="ico-play1"></i></a>
    <a data-toggle="modal" href="#info-modal" class="btn btn-primary btn-empty btn-icon info"><i class="ico-info"></i></a>
    <a href="<?= Url::toRoute(['/departments?id=1']) ?>" class="btn btn-empty">Sell your skills</a>
    <a data-toggle="modal" href="#support" class="btn btn-empty">Support</a>

</footer>
<!-- /site footer -->

<div style="color: rgb(169, 169, 169); font-size:14px" class="modal fade md-dial" id="support" tabindex="-1" role="status" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="padding-bottom: 5px;">
            <div class="modal-body" style="padding-bottom: 5px;">
                <div class="form-group">
                    <input required type="text" placeholder="First name" class="form-control1 first_name">
                    <div class="help-block hidden">First name cannot be blank.</div>
                </div>
                <div class="form-group">
                    <input required type="text" placeholder="Last name" class="form-control1 last_name">
                    <div class="help-block hidden">Last name cannot be blank.</div>
                </div>
                <div class="form-group">
                    <input required type="text" placeholder="Email" class="form-control1 email">
                    <div class="help-block hidden">Email name cannot be blank.</div>
                </div>
                <div class="form-group">
                    <input required type="text" placeholder="Phone (optional)" class="form-control1 phone">
                    <div class="help-block hidden">Phone cannot be blank.</div>
                </div>
                <div class="form-group">
                    <input required type="text" placeholder="Subject" class="form-control1 support_theme">
                    <div class="help-block hidden">Subject cannot be blank.</div>
                </div>
                <div class="form-group">
                    <textarea placeholder="Message" rows="10" class="form-control1 support_description"></textarea>
                    <div class="help-block hidden">Message cannot be blank.</div>
                </div>
            </div>
            <div class="modal-footer" style="border: 0;padding-top: 0;">
                <button type="button" class="btn btn-danger" style="width:85px;" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary support_send" style="width:85px;">Send</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade bs-modal-md" id="info-modal" tabindex="-1" role="dialog" aria-hidden="true" style="color: #34495e;display: none; padding-right: 17px;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body text-center" style="padding-left:50px; padding-right:50px;">
                <p>We are taught to believe that business ownership is time-consuming and quite stressful. Big S Business is set to change that so you can enjoy your business and attain a perfect work/life balance. </p>

                <p>The platform has the answers to all of the typical questions: </p>

                <p>What is my next step? <br>
                When and what do I need to do? <br>
                Who can help me if I get stuck?</p>

                <p>Simply start or restart your business!</p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<style>
    #support .form-group{
        margin-bottom: 10px;
    }
    #support .modal-dialog{
        width:800px;
    }
    #support .modal-content {
        border-radius: 10px !important;
    }
    #support .form-control1{
    display: block;
    font-family: "Roboto Light", sans-serif;
    border-radius:0 !important;
    box-shadow:none !important;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    background-color: #fff;
    background-image: none;
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    border:1px solid rgb(215, 215, 215);
    }
.btn-primary,.btn-success,.btn-danger,.btn-danger:focus{
    border-radius: 20px;
    background: #fff;
    border-width: 1px;
    border-color: #818588;
    border-style: solid;
    color: #818588;
    font-family: "Roboto Light", sans-serif;
}
.btn:hover,.open > .btn-primary.dropdown-toggle{
    border-color:#fff !important;
    /*box-shadow: inset 0 0 10px 5px #fff !important;*/
    color:#fff !important;
}
.btn-primary,.btn-success, .btn-danger{
    position: relative;
}
.btn-danger:hover{
    background-color: #FF5252 !important;
}

.btn-primary:hover:before,.btn-success:hover:before,.btn-danger:hover:before,.open > .btn-primary.dropdown-toggle:before{
    opacity: 1;
}
.btn-primary.active:before,.btn-success.active:before,.btn-danger.active:hover:before{
    opacity: 1;
}
.btn-success:focus, .btn-success.focus,.btn-primary:focus, .btn-primary.focus{
    background: none !important;
    border: 1px solid #818588 !important;
    color: #818588 !important;
}
.btn-success.active, .btn-success:hover{
    border-color: #0f9d58 !important;
    background-color: #0f9d58 !important;
    color: #ffffff !important;
}
.btn-primary.active, .btn-primary:hover, .open > .btn-primary.dropdown-toggle {
    border-color: #5184f3 !important;
    background-color: #5184f3 !important;
    color: #ffffff !important;
}
.btn-danger.active, .btn-danger:hover {
    border-color: #FF5252 !important;
    background-color: #FF5252 !important;
    color: #ffffff !important;
}
.btn.active:hover,*.active > .btn:hover{
    box-shadow: none !important;
}
.btn.static:hover, .btn.static:focus{
    box-shadow: none !important;
    background: #fff !important;
    border-width: 1px !important;
    border-color: #818588 !important;
    border-style: solid !important;
    color: #818588 !important;
}
.btn.static:hover:before{
    opacity: 0;
}
.btn.circle{
    width:32px !important;
    height: 32px;
    line-height:32px !important;
    text-align: center;
    padding: 0;
    border-radius: 100% !important;
}
    #support input, #support textarea{
        padding:0 10px;
        border-color: rgb(215, 215, 215);
        color:rgba(90,90,90,0.5);
        text-align:left; 
        font-size:14px;
    }
    #support textarea{
        width:100%; 
        padding:10px;
        resize:none;
        height: 290px !important;
    }
    .has-error .form-control1{
        border-color: #e73d4a !important;
    }
</style>
<!-- script -->
<script src='/js/mainpage/vendor/jquery-2.1.4.min.js'></script>
<!--[if lte IE 9]><!-->
<script src='/js/mainpage/vendor/html5shiv.min.js'></script>
<!--<![endif]-->
<script src='/js/mainpage/vendor/bootstrap.min.js'></script>
<script src='/js/mainpage/vendor/vendor.js'></script>
<script src='/js/mainpage/variable.js'></script>
<script src='/js/mainpage/main.js'></script>
<!-- /script -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
