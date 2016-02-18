<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var yii\widgets\ActiveForm $form
 */

$this->title = Yii::t('user', 'Recovery password');
?>

<div id="login" class="tab-pane active">
	<?php $form = ActiveForm::begin(
		[
			'action' => Url::to(['/user/recovery/request']),
			'id' => 'password-recovery-form',
		]
	) ?>
	<h3>Forget Password ?</h3>
	<p>
		Enter your e-mail address below to reset your password.
	</p>

	<?=
	$form->field($model, 'email', [
		'template' => '<div class="input-icon"><i class="fa fa-envelope"></i>{input}</div>{error}',
		'inputOptions' => [
			'class' => 'form-control placeholder-no-fixform-control placeholder-no-fix',
			'placeholder' => $model->getAttributeLabel('email'),
			'autofocus' => true,
		],
	])
	?>


	<div class="form-actions">
	<?= Html::a('<i class="m-icon-swapleft"></i> Back', Url::toRoute(['security/login']), ['class' => 'btn btn-default']);?>
	<?= Html::submitButton(Yii::t('user', 'Submit' . ' <i class="m-icon-swapright m-icon-white"></i>'), ['class' => 'btn green-haze pull-right']);?>
	</div>

	<?php ActiveForm::end() ?>
</div>