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

//$this->registerJsFile("/metronic/assets/global/scripts/datatable.js");

$id = $task->id;
if($task->temp_id) {
    $id = $task->temp_id;
}

$url = Url::toRoute('/core/data-table');
$view = Url::toRoute(["/tasks/view"]) . '?id=';
$model = '\\\modules\\\tasks\\\models\\\Task';

$this->registerJsFile("/js/global/select-tasks.js");
$initJs = <<<JS
    SelectTasks.init('$id','$url','$view','$model');
JS;

$this->registerJs($initJs);
?>
<style>
    .task-select {
        padding: 15px;
    }
    table.departments {
        table-layout: fixed; /* Фиксированная ширина ячеек */
        width: 1200px; /* Ширина таблицы */
    }
    table.departments td {
        padding-right: 5px;
        padding-bottom: 10px;
    }
    table.departments td:last-child {
        padding-right: 0;
    }
</style>

<div class="task-select">
    <table class="table table-striped table-bordered" id="datatable_ajax">
        <thead>
        <tr role="row" class="heading">
            <th width="25%">
                Tasks
            </th>
            <th width="25%">
                Milestone
            </th>
            <th width="25%">
                Department
            </th>
            <th width="25%">
                Actions
            </th>
        </tr>
        <tr role="row" class="filter">
            <td>
                <input type="text" class="form-control form-filter input-sm" id="filter_name">
            </td>
            <td>
                <?= Html::dropDownList('',null,ArrayHelper::merge (['' => ''], $milestonesArr), [
                    'id' => 'filter_milestone_id',
                    'class' => 'form-control form-filter input-sm'
                ]) ?>
            </td>
            <td>
                <?= Html::dropDownList('',null,ArrayHelper::merge (['' => ''], $departmentsArr), [
                    'id' => 'filter_department_id',
                    'class' => 'form-control form-filter input-sm'
                ]) ?>
            </td>
            <td>
                <button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button>
                <button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</button>
            </td>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>