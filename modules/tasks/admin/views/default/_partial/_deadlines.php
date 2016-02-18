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


$this->registerCssFile("/plugins/datetimepicker/jquery.datetimepicker.css");

$this->registerJsFile("/plugins/datetimepicker/build/jquery.datetimepicker.full.min.js");

//$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js");
//$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js");

//$this->registerJsFile("/metronic/theme/assets/pages/scripts/components-date-time-pickers.min.js");

$id = $task->id;
if($task->temp_id) {
    $id = $task->temp_id;
}
$initJs = <<<JS

    $('#select_tasks-dropdown').click(function(e) {
          e.stopPropagation();
    });

    var date_timepicker_start = $('#date_timepicker_start');
    if(date_timepicker_start.length > 0) {
        date_timepicker_start.datetimepicker({
        format:'Y-m-d H:i',
        allowTimes:[
            '8:00','8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30',
            '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00'
        ],
        onShow:function( ct ){
           this.setOptions({
            maxDate:$('#date_timepicker_end').val()?$('#date_timepicker_end').val():false
           })
          }
         });
        if(date_timepicker_start.val() != '') {
            date_timepicker_start.val((date_timepicker_start.val()).slice(0, date_timepicker_start.val().length - 3))
        }
    }
    var date_timepicker_end = $('#date_timepicker_end');
    if(date_timepicker_end.length > 0) {
        date_timepicker_end.datetimepicker({
          format:'Y-m-d H:i',
        allowTimes:[
            '8:00','8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30',
            '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00'
        ],
          onShow:function( ct ){
           this.setOptions({
            minDate:$('#date_timepicker_start').val()?$('#date_timepicker_start').val():false
           })
          }
        });
        if(date_timepicker_end.val() != '') {
            date_timepicker_end.val((date_timepicker_end.val()).slice(0, date_timepicker_end.val().length - 3))
        }
    }
JS;

$this->registerJs($initJs);
?>

<div class="form-group">
    <div class="dropup">
        <a class="no-decoretion" id="dLabel" data-target="#" data-toggle="dropdown" role="menu">
            Preceding tasks
        </a>

        <ul class="dropdown-menu" id="select_tasks-dropdown" aria-labelledby="dLabel">
            <? require_once __DIR__ . '/_select_tasks.php'; ?>
        </ul>
    </div>
    <div id="list-preceding-tasks">
        <? foreach($preceding_tasks as $preceding_task) : ?>
            <div>
                <a id="<?= $preceding_task->id ?>" class="preceding_task_name" href="<?= Url::toRoute(["/tasks/view", 'id' => $preceding_task->id])?>" onclick="return !window.open(this.href)"><?= $preceding_task->name ?></a>
                <a id="<?= $preceding_task->id ?>" class="btn-remove-task text-danger"><i class="fa fa-trash-o"></i></a>
            </div>
        <? endforeach; ?>
    </div>
</div>


<?=
$form->field($task, 'performed_immediately')->checkbox() ?>
<?
/*$form->field($task, 'performed_after')->checkbox()*/ ?>

<?
/*$form->field($task, 'start')->textInput(
    [
        'id' => 'date_timepicker_start',
        'class' => 'form-control'
    ]
)*/ ?>
<?
/*$form->field($task, 'end')->textInput(
    [
        'id' => 'date_timepicker_end',
        'class' => 'form-control'
    ]
)*/ ?>
<?
/*$form->field($task, 'time')->textInput(
    [
        'class' => 'form-control'
    ]
)*/ ?>
<?=
$form->field($task, 'recommended_time')->textInput(
    [
        'class' => 'form-control',
        'type' => 'number',
        'min' => 1
    ]
)->label("Recommended time (hours)") ?>