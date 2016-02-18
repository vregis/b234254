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

$this->title = 'Scenarios';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <?php $form = ActiveForm::begin(
        [
            'id' => 'login-form',
        ]
    ) ?>
    <h3 class="form-title"><? if($is_create): ?>Creating a scenario<? endif ?><? if(!$is_create): ?>Updating a scenario<? endif ?></h3>
    <?=
    $form->field($scenario, 'name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Name'
        ]
    ) ?>
    <?=
    $form->field($scenario, 'controller')->textInput(
        [
            'class' => 'form-control autosizeme',
            'placeholder' => 'Controller'
        ]
    ) ?>
    <?=
    $form->field($scenario, 'is_active')->checkbox() ?>

    <?= Html::submitButton('Save <i class="fa fa-save"></i>', ['class' => 'btn green']) ?>
    <?php ActiveForm::end() ?>

</div>