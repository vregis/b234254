<?php

//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use modules\departments\models\Industry;
use yii\helpers\ArrayHelper;

/**
 * @var modules\core\site\base\View $this
 */
$this->registerCssFile("/css/page_idea.css");

$this->registerJsFile("/js/global/idea-constructor.js");
$this->registerJsFile("/js/min/underscore-min.js");
$this->registerJsFile("/js/min/jquery.mask.min.js");

$msgJs = <<<JS
    $("#mask_currency").mask('000,000,000,000,000', {reverse: true});
    $("#goal-date").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0,
        changeMonth: true,
        changeYear: true,
        beforeShowDay: function(date) {
            if($("#goal-date").length > 0) {
                var date1 = $.datepicker.parseDate("yy-mm-dd", $("#goal-date").val());
                return [true, (date1 && date.getTime() == date1.getTime()) ? "dp-highlight" : ""];
            }
        }
    });
    $('#btn-date').click(function() {
        $("#goal-date").datepicker("show");
    });
    $('#task-form').submit(function() {
        var money = $("#mask_currency").val();
        money = money.replace(/,/g, '');
        $("#mask_currency").val(money);
    });
JS;
$this->registerJs($msgJs);
?>
<div id="idea" class="col-md-12">

    <div class="col-sm-6">
        <?=
        $form->field($goal, 'count_money',
        [
            'template' => '{label}<div class="input-group"><span class="input-group-addon"><i class="fa fa-dollar"></i></span>{input}</div>{error}{hint}'
        ])->textInput(
            [
                'id' => 'mask_currency',
                'class' => 'form-control placeholder-no-fix'
            ]

        ) ?>
    </div>
    <div class="col-sm-6">
        <?=
        $form->field($goal, 'date',
            [
                'template' => '{label}<div class="input-group"><span class="input-group-btn"><button id="btn-date" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button></span>{input}</div>{error}{hint}'
            ])->textInput(
            [
                'id' => 'goal-date',
                'class' => 'form-control placeholder-no-fix',
                'readonly' => '',
            ]

        ) ?>
    </div>

</div>
