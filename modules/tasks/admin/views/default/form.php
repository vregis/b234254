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
use yii\helpers\ArrayHelper;

$this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js");

$this->registerJsFile("/js/global/components-dropdowns.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-summernote/summernote.min.js");

$string_description = addslashes($task->description);
$string_description_road = addslashes($task->description_road);
$initJs = <<<JS
    ComponentsDropdowns.init();
    $('#element').popover({
    html : true,
    content: function() {
      return $('#popover_content_wrapper').html();
    }
    });

    var summernote = $('#summernote_1');
    summernote.summernote({
            height: 200,
            minHeight: 170
        });
    summernote.code('$string_description');


    var summernote2 = $('#summernote_2');
    summernote2.summernote({
            height: 200,
            minHeight: 170
        });
    summernote2.code('$string_description_road');



    $('#btn-submit').on( "click", function() {
        var tasks = [];
        $( ".preceding_task_name" ).each(function( i ) {
            tasks.push(parseInt($(this).attr('id')));
        });
        $('#input-preceding-tasks').val(JSON.stringify(tasks));
        $('#task-description').val($('#summernote_1').code());
        $('#task-description_road').val($('#summernote_2').code());



        var date_timepicker_start = $('#date_timepicker_start');
        if(date_timepicker_start.val() != '') {
            date_timepicker_start.val(date_timepicker_start.val() + ':00')
        }
        var date_timepicker_end = $('#date_timepicker_end');
        if(date_timepicker_end.val() != '') {
            date_timepicker_end.val(date_timepicker_end.val() + ':00')
        }
        $('#task-form').submit();
    });
JS;
$this->registerJs($initJs);
?>


<div>
    <?php $form = ActiveForm::begin(
        [
            'id' => 'task-form',
        ]
    ) ?>
    <h3 class="form-title"><? if($is_create) : ?>Creating<? else: ?>Updating<? endif; ?> a task</h3>
    <? if(isset($temp_id)) : ?>
        <input type="text" name="temp_id" value="<?= $temp_id ?>" hidden>
    <? endif; ?>
    <input id="input-preceding-tasks" type="text" name="preceding-tasks" value="[]" hidden>
    <?=
    $form->field($task, 'name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Name'
        ]
    ) ?>
    <?=
    /*$form->field($task, 'description')->textarea(
        [
            'class' => 'form-control autosizeme',
            'placeholder' => 'Description',
            'style' => 'resize: vertical'
        ]
    )*/
    $form->field($task, 'description', [
        'template' => '{label}{input}<div name="summernote" id="summernote_1"></div>{error}',
    ])->textInput(
        [
            'type' => 'hidden'
        ]
    ) ?>

    <?php if($task->id == 37 || $task->id == 38 || $task->id == 39):?>
    <?php echo
        $form->field($task, 'description_road', [
            'template' => '{label}{input}<div name="summernote2" id="summernote_2"></div>{error}',
        ])->textInput(
            [
                'type' => 'hidden'
            ]
        ) ?>

    <?php endif; ?>


    <?=
    $form->field($task, 'director_name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'The director of the task'
        ]
    ) ?>

    <div class="form-group field-priority_name required">
        <select class="bs-select form-control input-small" name="Task[priority]">
            <option class="bs-select-low" value="1" <? if ($task->priority == "1") : ?>selected<? endif; ?>>Low Priority</option>
            <option class="bs-select-medium" value="2" <? if ($task->priority == "2") : ?>selected<? endif; ?>>Medium Priority</option>
            <option class="bs-select-high" value="3" <? if ($task->priority == "3") : ?>selected<? endif; ?>>High Priority</option>
        </select>
    </div>

    <? if($tasksInMilestoneArr) : ?>
        <?= $form->field($task, 'sort')
            ->dropDownList(
                $tasksInMilestoneArr,
                ['class'=>'form-control']    // options
            );
        ?>
    <? else: ?>
        <div class="form-group field-task-sort">
            <label class="control-label">Ordering</label>
            <div class="form-control">
                Ordering will be available after saving
            </div>
        </div>

    <? endif; ?>

    <?= $form->field($task, 'department_id')
        ->dropDownList(
            ArrayHelper::merge (['' => ''], $departmentsArr),
            ['class'=>'form-control']    // options
        );
    ?>
    <? foreach($departmentsArr as $id => $name) : ?>
        <?= $form->field($task, 'specialization_id',[
            'options' => [
                'id' => 'specialization-field-'.$id,
                'hidden' => $task->department_id != $id
            ]
        ])
            ->dropDownList(
                ArrayHelper::merge (['' => ''], $specializationsArr[$id]),           // Flat array ('id'=>'label')
                [
                    'class'=>'form-control',
                    'disabled' => $task->department_id != $id
                ]    // options
            );
        ?>
    <? endforeach; ?>

    <?php echo $form->field($task, 'market_rate')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
            'placeholder' => 'Market Rate'
        ]
    ) ?>
    <?=
    $form->field($task, 'is_roadmap')->checkbox() ?>

    <?php if($task->id == 287 || $task->id == 286 || $task->id == 285 || $task->id ==37 || $task->id == 38 || $task->id == 39):?>

        <?php echo $form->field($task, 'button_name')->textInput(
            [
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Button Label'
            ]
        ) ?>

    <?php endif;?>

    <?php if($task->id == 39):?>

        <?php echo $form->field($task, 'second_button_name')->textInput(
            [
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Second Button Label'
            ]
        ) ?>

    <?php endif;?>

    <?php if($task->id ==37 || $task->id == 38 || $task->id == 39):?>
        <?php echo $form->field($task, 'roadmap_name')->textInput(
            [
                'class' => 'form-control placeholder-no-fix',
                'placeholder' => 'Roadmap Name'
            ]
        ) ?>
    <?php endif;?>




    <div class="portlet">
        <div class="portlet-title">
            <div class="caption tools pull-left">
                <a href="javascript:;" class="expand">Deadlines</a>
            </div>
        </div>
        <div class="portlet-body display-hide">
            <? require_once __DIR__ . '/_partial/_deadlines.php'; ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
    <div class="portlet">
        <div class="portlet-title">
            <div class="caption tools pull-left">
                <a href="javascript:;" class="expand">Supporting materials</a>
            </div>
        </div>
        <div class="portlet-body display-hide">
            <? require_once __DIR__ . '/_partial/_sup_materials.php'; ?>
        </div>
    </div>

    <a id="btn-submit" class="btn green">Save <i class="fa fa-save"></i></a>
</div>