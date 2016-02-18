<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var frontend\modules\core\base\View $this
 * @var yii\widgets\ActiveForm $form
 * @var common\modules\user\models\User $model
 * @var common\modules\user\models\SocialAccount $account
 */

$this->title = Yii::t('user', 'Подключение социальной сети к учетной записи');
$this->params['breadcrumbs'][] = $this->title;
$msgJs = <<<JS
$("body").css({
     'padding-top': $(window).height() / 2 - $(".window").height() /2 +"px",
});
$(window).resize(function(){
    $("body").css({
        'padding-top': $(window).height() / 2 - $(".window").height() /2 +"px",
    });
});
JS;
$this->registerJs($msgJs);
?>
	<!--<p>
		<?=
		Yii::t(
			'user',
			'Пожалуйста, подключите аккаунт выбрав имя пользователя и E-mail. В следующий раз вы не увидите эту форму.'
		) ?>
	</p>

	<p class="text-center">
		<?=
		Html::a(
			Yii::t('user', 'Если вы уже зарегистрированы, войдите и подключите аккаунт в настройках'),
			['/user/security/login']
		) ?>.
	</p>-->
    <div class="window soc_form">
        <a class="logo" style="margin-bottom:40px;" href="<?= Url::toRoute(['/']) ?>">
            <img src="/images/logo_new.png" alt=""/>
        </a>
    	<?php $form = ActiveForm::begin(
    		[
    			'action' => Url::to(
    					[
    						'/user/social/connect',
    						'provider' => $account->provider,
    						'client_id' => $account->client_id
    					]
    				)
    		]) ?>
            <div class="row">
              <div class="col-sm-12">
    		<?=	$form->field($model, 'username', [
    			'template' => '<div class="input-icon"><i class="fa fa-user"></i>{input}</div>{error}',
    			'inputOptions' => [
    				'class' => 'form-control placeholder-no-fixform-control placeholder-no-fix',
    				'placeholder' => $model->getAttributeLabel('username'),
    			],
    		]);?>
                </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
    		<?=	$form->field($model, 'email', [
    			'template' => '<div class="input-icon"><i class="fa fa-envelope"></i>{input}</div>{error}',
    			'inputOptions' => [
    				'class' => 'form-control placeholder-no-fixform-control placeholder-no-fix',
    				'placeholder' => $model->getAttributeLabel('email'),
    			],
    		]);?>
        </div>
    </div>
    <div class="row">
      <div class="col-sm-12 text-center">
            <div style="margin: 35px 0 !important;">By clicking “Continue” you are indicating that you have read and agreed to the <a data-toggle="modal" href="#large">Terms of Use</a> and the <a data-toggle="modal" href="#large2">Advice Disclaimer</a>
            </div>
	      <div class="btn-wrap lg"><?= Html::submitButton(Yii::t('user', 'Continue' . ' <i class="m-icon-swapright m-icon-white"></i>'), ['class' => 'btn btn-block btn-cust']);?></div>
	    </div>
    	<?php ActiveForm::end() ?>
    </div>
        <div class="copyright">
            2016 &copy; BSB
        </div>
    </div>
</div>

<?php echo $document; ?>
