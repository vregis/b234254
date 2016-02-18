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
            <a href="<?= Url::toRoute(['/'.$this->context->module->id.'/view', 'id' => $test->id])?>"><?= $test->name ?></a>
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
    <h3 class="form-title"><? if($is_create): ?>Creating a category<? else: ?>Updating a category<? endif ?></h3>
    <?=
    $form->field($test_category, 'name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Name'
        ]
    ) ?>

    <?= Html::submitButton('Save <i class="fa fa-save"></i>', ['class' => 'btn green']) ?>
    <?php ActiveForm::end() ?>

</div>