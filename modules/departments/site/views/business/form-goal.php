<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$this->registerCssFile("/plugins/datetimepicker/jquery.datetimepicker.css");
$this->registerCssFile("/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.min.css");

$this->registerCssFile("/fonts/Open Sans/OpenSans-Bold.css");
$this->registerCssFile("/css/task.css");

$this->registerJsFile("/plugins/datetimepicker/build/jquery.datetimepicker.full.min.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.min.js");
$this->registerJsFile("/js/readmore.min.js");
$msgJs = <<<JS
JS;
$this->registerJs($msgJs);
?>


<?php $form = ActiveForm::begin(
    [
        'id' => 'task-form',
    ]
) ?>
    <h3 class="form-title col-md-12 b-idea-title">Turn dream into a goal</h3>
<? require Yii::getAlias('@modules') . '/tasks/site/views/default/blocks/goal.php' ?>

<div class="col-md-12">
    <?= Html::a('Delete <i class="fa fa-trash-o"></i>',Url::toRoute(['/departments/business/delete-goal', 'id' => $goal->id]), ['class' => 'btn btn-lg btn-danger b-btn-delete pull-left']) ?>
    <?= Html::submitButton('Save <i class="fa fa-download"></i>', ['class' => 'btn btn-lg btn-primary pull-right']) ?>
</div>
<?php ActiveForm::end() ?>