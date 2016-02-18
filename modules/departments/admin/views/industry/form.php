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

$initJs = <<<JS
JS;
$this->registerJs($initJs);

$this->title = 'Departments';
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
            <a href="<?= Url::toRoute(['/'.$this->context->module->id.'/view', 'id' => 8])?>">Idea</a>
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
    <h3 class="form-title"><? if($is_create): ?>Creating industry<? else: ?>Updating industry<? endif ?></h3>
    <?=
    $form->field($industry, 'name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Name'
        ]
    ) ?>
    <?=
    $form->field($industry, 'description')->textarea(
        [
            'class' => 'form-control autosizeme',
            'placeholder' => 'Description',
            'style' => 'resize: vertical'
        ]
    ) ?>
    <?=
    $form->field($industry, 'icons')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Icons'
        ]
    ) ?>

    <?= Html::submitButton('Save <i class="fa fa-save"></i>', ['class' => 'btn green']) ?>
    <?php ActiveForm::end() ?>

</div>