<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * @var yii\web\View $this
 */
$msgJs = <<<JS

$(document).ready(function(){
    console.log($(window).outerHeight() / 2 - 250 +"px");
});
$("body").css({
     'padding-top': $(window).height() / 2 - 250 +"px",
});
$(window).resize(function(){
    $("body").css({
        'padding-top': $(window).height() / 2 - 250 +"px",
    });
});
JS;
$this->registerJs($msgJs);

?>
<!--
<div style="position:absolute; width:100%; overflow-y:hidden">
    <?php //echo $test; ?>
</div>
<div style="position:absolute; width:100%; height:100%; background-color:white; z-index:333; opacity:0.3 "></div>
<div style="position:absolute;width:100%; z-index:444; opacity: 0.8">
    <?php //echo $start?>
<?php //die();?>
</div>

-->
<style>
    input{
        height: 33px !important;
    }
    .input-icon > i{
        margin-top:9px;
    }
</style>

<script>
    $(document).ready(function(){
        $('.noselect').bind("cut copy paste",function(e) {
            e.preventDefault();
        });
    });

    function clickIE4(){
        if (event.button==2 || event.button==86){
            return false;
        }
    }
    function clickNS4(e){
        if (document.layers||document.getElementById&&!document.all){
            if (e.which==2||e.which==3||e.which==86){
                return false;
            }
        }
    }
    if (document.layers){
        document.captureEvents(Event.MOUSEDOWN);
        document.onmousedown=clickNS4;
    }
    else if (document.all&&!document.getElementById){
        document.onmousedown=clickIE4;
    }
    document.oncontextmenu=new Function("return false")
</script>
<div id="reg" class="window">
<!-- BEGIN REGISTRATION FORM -->
<?php $form = ActiveForm::begin();?>
<div class="nav">
    <div class="signup-btn active">
        <span class="icon"></span>Sign up
    </div>
    <a href="/user/security/login" class="signin-btn">
        <span class="icon"></span>Sign in
    </a>
    <div class="clearfix"></div>
</div>
	<?= Yii::$app->session->getFlash('error');?>
	<?= Yii::$app->session->getFlash('success');?>
<div class="row">
    <div class="col-sm-12">
        <?=	$form->field($model, 'email', [
            'template' => '<div class="input-icon"><i class="icon-envelope"></i>{input}</div>{error}',
            'inputOptions' => [
                'class' => 'form-control placeholder-no-fixform-control placeholder-no-fix noselect',
                'placeholder' => $model->getAttributeLabel('email'),
            ],
        ]);?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?=	$form->field($model, 'email_repeat', [
            'template' => '<div class="input-icon"><i class="icon-check"></i>{input}</div>{error}',
            'inputOptions' => [
                'class' => 'form-control placeholder-no-fixform-control placeholder-no-fix noselect',
                'placeholder' => $model->getAttributeLabel('email_repeat'),
            ],
        ]);?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($model, 'password', [
            'template' => '<div class="input-icon"><i class="icon-lock"></i>{input}</div>{error}',
            'inputOptions' => [
                'class' => 'form-control placeholder-no-fixform-control placeholder-no-fix noselect',
                'placeholder' => $model->getAttributeLabel('password'),
            ],
        ])->passwordInput();?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($model, 'password_repeat', [
    		'template' => '<div class="input-icon"><i class="icon-check"></i>{input}</div>{error}',
    		'inputOptions' => [
    			'class' => 'form-control placeholder-no-fixform-control placeholder-no-fix noselect',
    			'placeholder' => Yii::t('user', 'Re-type Your Password'),
    		],
    	])->passwordInput();?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div style="font-size:11px;">By clicking “Submit” you are indicating that you have read and agreed to the <a data-toggle="modal" href="#large">Terms of Use</a> and the <a data-toggle="modal" href="#large2">Advice Disclaimer</a></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="btn-wrap lg" style="margin-bottom:0;">
            <button type="submit" class="btn btn-block btn-cust">Submit <i class="m-icon-swapright m-icon-white"></i></button>
        </div>
    </div>
</div>

<?php $form->end();?>

    <div class="copyright">
        2016 &copy; BSB
    </div>
</div>


<!-- END REGISTRATION FORM -->

<?php echo $document?>
