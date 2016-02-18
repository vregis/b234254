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

$this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-summernote/summernote.min.js");

$string_description_high = addslashes($test_result->description_high);
$string_description_medium = addslashes($test_result->description_medium);
$string_description_low = addslashes($test_result->description_low);
$initJs = <<<JS

    function init_summernote(category) {
        var summernote = $('#summernote_' + category);
        summernote.summernote({
                height: 200,
                minHeight: 170
            });
        return summernote;
    }
    function submit_summernote(category) {
        $('#testresult-description_' + category).val($('#summernote_' + category).code());
    }
    init_summernote('high').code('$string_description_high');
    init_summernote('medium').code('$string_description_medium');
    init_summernote('low').code('$string_description_low');

    $('#btn-submit').on( "click", function() {
        submit_summernote('high');
        submit_summernote('medium');
        submit_summernote('low');
    });

    $('.demo').each(function() {
            //
            // Dear reader, it's actually very easy to initialize MiniColors. For example:
            //
            //  $(selector).minicolors();
            //
            // The way I've done it below is just for the demo, so don't get confused
            // by it. Also, data- attributes aren't supported at this time...they're
            // only used for this demo.
            //
            $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                defaultValue: $(this).attr('data-defaultValue') || '',
                inline: $(this).attr('data-inline') === 'true',
                letterCase: $(this).attr('data-letterCase') || 'lowercase',
                opacity: $(this).attr('data-opacity'),
                position: $(this).attr('data-position') || 'bottom left',
                change: function(hex, opacity) {
                    if (!hex) return;
                    if (opacity) hex += ', ' + opacity;
                    if (typeof console === 'object') {
                        console.log(hex);
                    }
                },
                theme: 'bootstrap'
            });

        });
JS;
$this->registerJs($initJs);

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
    <h3 class="form-title"><? if($is_create): ?>Creating a result<? else: ?>Updating a result<? endif ?></h3>
    <?=
    $form->field($test_result, 'name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Name'
        ]
    ) ?>
    <?=
    $form->field($test_result, 'title_high')->textInput(
        [
            'class' => 'form-control placeholder-no-fix'
        ]
    ) ?>
    <?=
    $form->field($test_result, 'description_high', [
        'template' => '{label}{input}<div id="summernote_high"></div>{error}',
    ])->textInput(
        [
            'type' => 'hidden'
        ]
    ) ?>

    <?=
    $form->field($test_result, 'title_medium')->textInput(
        [
            'class' => 'form-control placeholder-no-fix'
        ]
    ) ?>
    <?=
    $form->field($test_result, 'description_medium', [
        'template' => '{label}{input}<div id="summernote_medium"></div>{error}',
    ])->textInput(
        [
            'type' => 'hidden'
        ]
    ) ?>
    <?=
    $form->field($test_result, 'title_low')->textInput(
        [
            'class' => 'form-control placeholder-no-fix'
        ]
    ) ?>
    <?=
    $form->field($test_result, 'description_low', [
        'template' => '{label}{input}<div id="summernote_low"></div>{error}',
    ])->textInput(
        [
            'type' => 'hidden'
        ]
    ) ?>



    <?=
    $form->field($test_result, 'color')->textInput(
        [
            'id' => 'color-hue',
            'class' => 'form-control demo',
            'data-control' => 'hue'
        ]
    ) ?>

    <?= Html::submitButton('Save <i class="fa fa-save"></i>', ['class' => 'btn green', 'id'=>'btn-submit']) ?>
    <?php ActiveForm::end() ?>

</div>