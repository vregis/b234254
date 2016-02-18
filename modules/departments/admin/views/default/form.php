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

$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-summernote/summernote.min.js");
$string_description = addslashes($department->description);
$initJs = <<<JS
    var summernote = $('#summernote_1');
    summernote.summernote({
            height: 300
        });
    summernote.code('$string_description');
    $( "#department-form" ).submit(function( event ) {
        $('#department-description').val($('#summernote_1').code());
    });
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
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->

<div>
    <?php $form = ActiveForm::begin(
        [
            'id' => 'department-form',
        ]
    ) ?>
    <h3 class="form-title"><? if($is_create): ?>Creating a department<? endif ?><? if(!$is_create): ?>Updating a department<? endif ?></h3>
    <?=
    $form->field($department, 'name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Name'
        ]
    ) ?>
    <?=
    $form->field($department, 'description', [
            'template' => '{label}{input}<div name="summernote" id="summernote_1"></div>{error}',
        ])->textInput(
        [
            'type' => 'hidden'
        ]
    ) ?>

    <?=
    $form->field($department, 'icons')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Icons'
        ]
    ) ?>
    <?=
    $form->field($department, 'is_additional')->checkbox() ?>

    <?= Html::submitButton('Save <i class="fa fa-save"></i>', ['class' => 'btn green']) ?>
    <?php ActiveForm::end() ?>

</div>