<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/**
 * @var yii\widgets\ActiveForm $form
 */

$this->title = 'Авторизация';
?>

<div id="login" class="tab-pane active">
    <?php $form = ActiveForm::begin(
        [
            'id' => 'login-form',
        ]
    ) ?>
    <h3 class="form-title">Login to your account</h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <div class="has-error"><?= $form->errorSummary($model, ['class' => 'help-block']) ?></div>
			<span>
			Enter any username and password. </span>
    </div>
    <?=
    $form->field($model, 'email', [
            'template' => '{label}<div class="input-icon"><i class="fa fa-envelope-o"></i>{input}</div>{error}',
        ])->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'E-mail'
        ]
    ) ?>
    <?=
    $form->field($model, 'password', [
            'template' => '{label}<div class="input-icon"><i class="fa fa-lock"></i>{input}</div>{error}',
        ])->passwordInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Password'
        ]
    ) ?>
    <div class="form-actions">
        <?= $form->field($model, 'rememberMe', ['template' => '{input}' . Html::submitButton('Login <i class="m-icon-swapright m-icon-white"></i>', ['class' => 'btn btn-primary pull-right'])])->checkbox();?>
    </div>
    <div class="login-options">
        <h4>Or login with</h4>
        <ul class="social-icons">
            <li>
                <?=	Html::a('', Url::toRoute(['social/login', 'service' => 'fb']), ['class' => 'facebook', 'data-original-title' => 'facebook']);?>
            </li>
            <li>
                <?= Html::a('', Url::toRoute(['social/login', 'service' => 'tw']), ['class' => 'twitter', 'data-original-title' => 'Twitter']);?>
            </li>
        </ul>

    </div>
    <?php ActiveForm::end() ?>
</div>