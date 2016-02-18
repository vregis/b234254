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

$this->title = $this->context->module->title;
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
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->

<div>
    <?php $form = ActiveForm::begin(
        [
            'id' => 'milestone-form',
        ]
    ) ?>
    <h3 class="form-title"><? if($is_create): ?>Creating a milestone<? else: ?>Updating a milestone<? endif ?></h3>
    <?=
    $form->field($milestone, 'name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Name'
        ]
    ) ?>
    <?=
    $form->field($milestone, 'description')->textarea(
        [
            'class' => 'form-control autosizeme',
            'placeholder' => 'Description',
            'style' => 'resize: vertical'
        ]
    ) ?>
    <?=
    $form->field($milestone, 'is_pay')->checkbox() ?>
    <?=
    $form->field($milestone, 'is_hidden')->checkbox() ?>

    <?= Html::submitButton($is_create ? 'Create' : 'Save <i class="fa fa-save"></i>', ['class' => 'btn green']) ?>
    <?php ActiveForm::end() ?>

</div>