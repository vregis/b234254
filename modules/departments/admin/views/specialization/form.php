<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 11.11.2015
 * Time: 17:52
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Tests';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?= Url::toRoute('/')?>">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="<?= Url::toRoute('/'.$this->context->module->id)?>"><?= $this->title ?></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="<?= Url::toRoute(['/'.$this->context->module->id.'/view', 'id' => $department->id])?>"><?= $department->name ?></a>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->

<div>
    <?php $form = ActiveForm::begin(
        [
            'id' => 'login-form',
        ]
    ) ?>
    <h3 class="form-title"><? if($is_create): ?>Creating a specialization<? else: ?>Updating a specialization<? endif ?></h3>
    <?=
    $form->field($specialization, 'name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Name'
        ]
    ) ?>
    <?=
    $form->field($specialization, 'description')->textarea(
        [
            'class' => 'form-control autosizeme',
            'placeholder' => 'Description',
            'style' => 'resize: vertical'
        ]
    ) ?>
    <?=
    $form->field($specialization, 'icons')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Icons'
        ]
    ) ?>
    <?=
    $form->field($specialization, 'market_rate_min')->input('number',
        [
            'min' => '0',
            'step' => '0.01',
            'class' => 'form-control',
        ]
    ) ?>
    <?=
    $form->field($specialization, 'market_rate_max')->input('number',
        [
            'min' => '0',
            'step' => '0.01',
            'class' => 'form-control',
        ]
    ) ?>

    <h4>Recommend Payment</h4>
    <?=
    $form->field($specialization, 'recommend_payment_low')->input('number',
        [
            'min' => '0',
            'step' => '0.01',
            'class' => 'form-control',
        ]
    )->label('Low') ?>
    <?=
    $form->field($specialization, 'recommend_payment_medium')->input('number',
        [
            'min' => '0',
            'step' => '0.01',
            'class' => 'form-control',
        ]
    )->label('Medium') ?>
    <?=
    $form->field($specialization, 'recommend_payment_high')->input('number',
        [
            'min' => '0',
            'step' => '0.01',
            'class' => 'form-control',
        ]
    )->label('High') ?>

    <?= Html::submitButton('Save <i class="fa fa-save"></i>', ['class' => 'btn green']) ?>
    <?php ActiveForm::end() ?>

</div>