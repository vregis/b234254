<?php

use yii\widgets\ActiveForm;


$this->title = 'Создать новый аккаунт';
$this->params['breadcrumbs'][] = ['label' => 'user', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['control'] = [
    'brandLabel' => $this->title,
    'create' => false
];

$userMod = Yii::$app->getModule('user');

?>

<?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]) ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= $this->encode($this->title) ?>
    </div>
    <div class="panel-body">
        <div class="alert alert-info">
            <?= 'Пароль и имя пользователя будут высланы пользователю по email' ?>.
            <?= 'Если вы хотите, чтобы пароль был сгенерирован автоматически, оставьте поле пустым' ?>.
        </div>

        <?= $form->field($model, 'username')->textInput(['maxlength' => 25]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

    </div>
</div>

<?= $this->submitBlock() ?>

<?php ActiveForm::end() ?>
