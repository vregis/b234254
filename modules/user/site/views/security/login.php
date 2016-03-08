<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/**
 * @var yii\widgets\ActiveForm $form
 */

$this->title = 'Авторизация';

$msgJs = <<<JS
    $(document).ready(function(){
        $('.terms').readmore({
          collapsedHeight: 17,
          moreLink: '<a href="#">More...</a>',
          lessLink:'<a href="#">Less...</a>'
        });
    });
    $('input').each(function( index, element ) {
        $(this).keypress(function(e) {
              if (e.which == '13') {
                 $('#login-form').submit();
               }
        });
    });
    console.log($(window).outerHeight() / 2 - 250 +"px");
    $("body").css({
         'padding-top': $(window).outerHeight() / 2 - 250 +"px",
    });
    $(window).resize(function(){
        $("body").css({
            'padding-top': $(window).outerHeight() / 2 - 250 +"px",
        });
    });
JS;
$this->registerJs($msgJs);

?>



<div id="login" class="window">
    <?php $form = ActiveForm::begin(
        [
            'id' => 'login-form',
        ]
    ) ?>
    <div class="nav">
        <a href="/user/registration/register" class="signup-btn">
            <span class="icon"></span>Sign up
        </a>
                <div class="signin-btn active">
            <span class="icon"></span>Sign in
        </div>
        <div class="clearfix" style="height: 60px !important;"></div>
    </div>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <div class="has-error"><?= $form->errorSummary($model, ['class' => 'help-block']) ?></div>
	        <span>Enter any username and password.</span>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <?=
            $form->field($model, 'email', [
            'template' => '<div class="input-icon"><i class="fa fa-envelope-o"></i>{input}</div>{error}',
          ])->textInput(
                [
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'E-mail'
                ]
            ) ?>
          </div>
          </div>
          <div class="row">
          <div class="col-sm-12">
            <?=
            $form->field($model, 'password', [
        		'template' => '<div class="input-icon"><i class="fa fa-lock"></i>{input}</div>{error}',
        	])->passwordInput(
                [
                    'class' => 'form-control placeholder-no-fix',
                    'placeholder' => 'Password'
                ]
            ) ?>
          </div>
        </div>

        <div class="row" style="padding:0 50px;" class="rememberMe">
            <div class="col-sm-6 text-left" style="padding:0;">
                <?= $form->field($model, 'rememberMe')->checkbox();?>
            </div>
            <div class="col-sm-6 text-right" style="padding:0;">
                <a href = '/user/security/set-mail-from-pass'>Forgot your password?</a>
            </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="form-actions">
                <div class="btn-wrap lg">
                    <button type="submit" class="btn btn-block btn-cust">Sign in <i class="m-icon-swapright m-icon-white"></i></button>
                </div>
            </div>
          </div>
        </div>
    <?php ActiveForm::end() ?>
        <div class="row">
            <div class="col-sm-12">
                <div style="text-align:justify" class="terms">
                    * Using a public device? Uncheck to protect your account. <br>
                    With this box checked, we'll keep you signed in, making it easier to access the platform. You'll also be all set to pay and receive money if you save your payment info. You can always turn off this feature in Settings. We may ask you to sign in again for some activities, such as making changes to your account.
                </div>
            </div>
        </div>
        <div class="copyright">
            <?php echo date("Y"); ?> &copy; BSB
        </div>
        
</div>

<?php if(isset($_GET['email']) && !empty($_GET['email'])):?>
    <script>
        $(function(){
            $('#loginform-email').val("<?php echo $_GET['email']?>");
        })
    </script>
<?php endif;?>
