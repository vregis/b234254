<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/**
 * @var yii\widgets\ActiveForm $form
 */

$this->title = 'Авторизация';

$msgJs = <<<JS
    $('input').each(function( index, element ) {
        $(this).keypress(function(e) {
              if (e.which == '13') {
                 $('#login-form').submit();
               }
        });
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

<style>
    input{
        height: 33px !important;
    }
    .input-icon > i{
        margin-top:9px;
    }
    h3{
        text-align: center;
        font-size: 16px;
        margin:40px 0 20px;
    }
    .logo{
        padding-top:20px !important;
    }
</style>

<div id="login" class="window">
    <a class="logo" href="<?= Url::toRoute(['/']) ?>">
        <img src="/images/logo_new.png" alt=""/>
    </a>
    <?php $form = ActiveForm::begin(
        [
            'id' => 'login-form',
        ]
    ) ?>
        <h3>Enter your new password</h3>

      <div class="row">
          <div class="col-sm-12">
            <?=
            $form->field($model, 'password', [
        		'template' => '<div class="input-icon"><i class="fa fa-lock"></i>{input}</div>{error}',
        	])->passwordInput(
                [
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'New password'
                ]
            ) ?>
          </div>
        </div>
    <div class="row">
        <div class="col-sm-12">
            <?=
            $form->field($model, 'password_repeat', [
                'template' => '<div class="input-icon"><i class="icon-check"></i>{input}</div>{error}',
            ])->passwordInput(
                [
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'Reenter password'
                ]
            ) ?>
        </div>
    </div>
    <?php if(isset($_GET['token']) && !empty($_GET['token'])):?>
        <input type="hidden" name="token" value="<?php echo $_GET['token']?>">
    <?php endif;?>
    <div class="row">
        <div class="col-sm-12">
            <div class="btn-wrap lg" style="margin-bottom:0;">
                <button type="submit" class="btn btn-block btn-cust">Continue <i class="m-icon-swapright m-icon-white"></i></button>
            </div>
        </div>
    </div>

    <?php ActiveForm::end() ?>

        <div class="copyright">
            2016 &copy; BSB
        </div>
</div>
