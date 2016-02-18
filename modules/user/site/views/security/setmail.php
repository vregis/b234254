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
    .desc{
        padding: 0px 35px 40px;
        font-size:12px;
    }
    .logo{
        padding-top:20px !important;
    }
</style>
<div id="setmail" class="window">
    <a class="logo" href="<?= Url::toRoute(['/']) ?>">
        <img src="/images/logo_new.png" alt=""/>
    </a>
    <form method="post" action="/user/security/sendforgotpass">
        <h3 c>Forgot your password?</h3>
        <div class="desc">
            To recieve your password reset instructions, please enter the address you provided during the registration process
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group field-loginform-email">
<div class="input-icon"><i class="fa fa-envelope-o"></i><input id="loginform-email" class="form-control placeholder-no-fix" name="email" placeholder="E-mail" type="text">
    <div class="help-block"></div>
</div>
</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-wrap lg" style="margin-bottom:0;">
                    <button type="submit" class="btn btn-block btn-cust reset-password">Reset password <i class="m-icon-swapright m-icon-white"></i></button>
                </div>
            </div>
        </div>

    </form>

        <div class="copyright">
            2016 &copy; BSB
        </div>
</div>

<script>
    $('.reset-password').on('click', function(e){
        e.preventDefault();
        var email = $('input[name=email]').val();
        $.ajax({
            url: '/user/security/sendforgotpass',
            data: {email:email},
            type: 'post',
            dataType: 'json',
            success: function(response){
                if(response.error == false){
                    $('.help-block').css('color', 'green');
                }else{
                    $('.help-block').css('color', 'red');
                }
                $('.help-block').text(response.msg);
            }
        })
    })
</script>
