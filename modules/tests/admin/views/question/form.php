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

$this->registerJsFile("/metronic/assets/admin/pages/scripts/components-dropdowns.js");

$initJs = <<<JS
    ComponentsDropdowns.init();
JS;
$this->registerJs($initJs);

$this->title = 'Tests';
$this->params['breadcrumbs'][] = $this->title;

$colum_size = intval(12/count($test_options));
if($colum_size < 1) {
    $colum_size = 1;
}
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
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="<?= Url::toRoute(['/'.$this->context->module->id.'/category/view', 'id' => $test_category->id])?>"><?= $test_category->name ?></a>
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
    <h3 class="form-title"><? if($is_create): ?>Creating a question<? else: ?>Updating a question<? endif ?></h3>
    <?=
    $form->field($test_question, 'name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Name'
        ]
    ) ?>

    <div class="form-group">
        <? $i = 0; ?>
        <? foreach($test_results as $test_result) : ?>
            <h4><?= $test_result->name ?></h4>
            <div class="row">
                <? foreach($test_options as $test_option) : ?>
                    <div class="col-md-<?= $colum_size ?>">
                        <? if($i == 0) echo '<h5>'.$test_option->name.'</h5>'; ?>
                        <input type="number" min="0" step="1" class="form-control placeholder-no-fix" name="TestCalculationResult[<?= $test_result->id ?>][<?= $test_option->id ?>][points]" placeholder="<?= $test_option->name ?>"
                               id="testcalculationresult-<?= $test_result->id ?>-<?= $test_option->id ?>-points"
                               value="<?= $calculation_results[$test_result->id][$test_option->id]->points ?>">
                    </div>
                <? endforeach; ?>
            </div>
            <? $i++; ?>
        <? endforeach; ?>
    </div>

    <?= Html::submitButton('Save <i class="fa fa-save"></i>', ['class' => 'btn green']) ?>
    <?php ActiveForm::end() ?>

</div>