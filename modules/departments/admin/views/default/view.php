<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Departments';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js");

$url = Url::toRoute(["/core/data-table"]);
$update = Url::toRoute(["/tasks/update"]) . '?id=';
$view = Url::toRoute(["/tasks/view"]) . '?id=';
$delete = Url::toRoute(["/tasks/delete"]) . '?id=';

$model = '\\\modules\\\tasks\\\models\\\Task';
$msgJs = <<<JS
        var grid = new Datatable();
        $('#filter_milestone_id').change(function(){
            var val = $("#filter_milestone_id option:selected").val();
            $('#filter_milestone_id').attr('value',val);
        });
        grid.init({
            src: $("#datatable_ajax"),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error
            },
            onDataLoad: function(grid) {
                // execute some code on ajax data load
            },
            loadingMessage: 'Loading...',
            dataTable: {
                "bStateSave": true,
                "pageLength": 10,
                "ajax": {
                    "url": "$url",
                    "data": function ( d ) {
                        var myData = {
                            "_csrf" : $("meta[name=csrf-token]").attr("content"),
                            "model" : "$model",
                            "where" : '{"department_id":$department->id}',
                            "keys" : '["id", "name", "milestone_id", "specialization_id", "priority", "id"]'
                        };
                        var keys = jQuery.parseJSON(myData.keys);
                        $.each(keys, function(key,value){
                            var filter_name = 'filter_' + value;
                            var filter = $('#' + filter_name);
                            if(filter.length > 0) {
                                myData[filter_name] = filter.val();
                            }
                        });
                        return  $.extend(d, myData);
                    }
                },
                "columnDefs": [
                    { "searchable": false, "targets": [5] },
                    { "targets": 4,
                        "render":  function (data, type, row, meta) {
                            if(data == '1') {
                                html = '<div class="bg-green-jungle text-center"><div class="bg-font-green-jungle font-lg">Low</div></div>';
                            }
                            if(data == '2') {
                                 html = '<div class="bg-yellow-lemon text-center"><div class="bg-font-yellow-lemon font-lg">Medium</div></div>';
                             }
                            if(data == '3') {
                                html = '<div class="bg-red text-center"><div class="bg-font-red font-lg">High</div></div>';
                            }
                            return html;
                        }
                    },
                    { "targets": 5,
                        "render":  function (data, type, row, meta) {
                            html = '<a href="$update' + data +'" class="btn default btn-xs purple"> <i class="fa fa-edit"></i> Edit </a>';
                            html += '<a href="$view' + data +'" class="btn default btn-xs green-stripe"> View </a>';
                            html += '<a href="$delete' + data +'" class="btn btn-danger btn-xs black"> <i class="fa fa-trash-o"></i> Delete </a>';
                            return html;
                        }
                    }
                ],
                "order": [
                    [1, "asc"]
                ]// set first column as a default sort by asc
            }
        });
JS;
$this->registerJs($msgJs);
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
            <?= $department->name ?>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <?=$department->name?>
                </div>
                <? if(!$department->is_additional) : ?>
                    <div class="actions">
                        <a href="<?= Url::toRoute(['/departments/specialization/create', 'id' => $department->id])?>" class="btn default yellow-stripe">
                            <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New specialization </span>
                        </a>
                    </div>
                <? endif; ?>
            </div>
            <? if(!$department->is_additional) : ?>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th>
                                    <i class="fa fa-tasks"></i> Specializations
                                </th>
                                <th>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <? foreach($specializations as $specialization) : ?>
                                <tr>
                                    <td class="highlight">
                                        <a href="<?= Url::toRoute(['/departments/specialization/view', 'id' => $specialization->id])?>"><?= $specialization->name ?></a>
                                    </td>
                                    <td width="25%">
                                        <a href="<?= Url::toRoute(['/departments/specialization/update', 'id' => $specialization->id])?>" class="btn default btn-xs purple">
                                            <i class="fa fa-edit"></i> Edit </a>
                                        <a href="<?= Url::toRoute(['/departments/specialization/view', 'id' => $specialization->id])?>" class="btn default btn-xs green-stripe">
                                            View </a>
                                        <a href="<?= Url::toRoute(['/departments/specialization/delete', 'id' => $specialization->id])?>" class="btn btn-danger btn-xs black">
                                            <i class="fa fa-trash-o"></i> Delete </a>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <? endif; ?>
            <? if($department->name == 'Idea') : ?>
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="actions">
                            <a href="<?= Url::toRoute(['/departments/industry/create'])?>" class="btn default yellow-stripe">
                                <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New industry </span>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table table-striped table-bordered table-advance table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        <i class="fa fa-tasks"></i> Industries
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <? foreach($industries as $industry) : ?>
                                    <tr>
                                        <td class="highlight">
                                            <a href="<?= Url::toRoute(['/departments/industry/update', 'id' => $industry->id])?>"><?= $industry->name ?></a>
                                        </td>
                                        <td width="25%">
                                            <a href="<?= Url::toRoute(['/departments/industry/update', 'id' => $industry->id])?>" class="btn default btn-xs purple">
                                                <i class="fa fa-edit"></i> Edit </a>
                                            <a href="<?= Url::toRoute(['/departments/industry/delete', 'id' => $industry->id])?>" class="btn btn-danger btn-xs black">
                                                <i class="fa fa-trash-o"></i> Delete </a>
                                        </td>
                                    </tr>
                                <? endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <? endif; ?>
        </div>
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption tools pull-left">
                    <a href="javascript:;" class="collapse">Tasks</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">
                                ID&nbsp;#
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Milestone
                            </th>
                            <th>
                                Specialization
                            </th>
                            <th>
                                Priority
                            </th>
                            <th width="15%">
                                Actions
                            </th>
                        </tr>
                        <tr role="row" class="filter">
                            <td>
                            </td>
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
                                <?= Html::dropDownList('',null,ArrayHelper::merge (['' => ''], $specializationsArr), [
                                    'id' => 'filter_specialization_id',
                                    'class' => 'form-control form-filter input-sm'
                                ]) ?>
                            </td>
                            <td>
                            </td>
                            <td>
                                <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                    <i class="fa fa-search"></i> Search</button>
                                <button class="btn btn-sm red btn-outline filter-cancel">
                                    <i class="fa fa-times"></i> Reset</button>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->