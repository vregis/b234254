<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js");

$url = Url::toRoute(["/core/data-table"]);
$update = Url::toRoute(["/tasks/update"]) . '?id=';
$view = Url::toRoute(["/tasks/view"]) . '?id=';
$delete = Url::toRoute(["/tasks/delete"]) . '?id=';

$model = '\\\modules\\\tasks\\\models\\\Task';
$msgJs = <<<JS
    var grid = new Datatable();

        $('#filter_department_id').change(function(){
            var val = $("#filter_department_id option:selected").val();
            $('#filter_department_id').attr('value',val);
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
                            "where" : '{"milestone_id":$milestone->id}',
                            "keys" : '["id", "sort", "name", "department_id", "priority", "id"]'
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
            <a href="<?= Url::toRoute(['/']) ?>">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="<?= Url::toRoute(['/milestones']) ?>">Milestones</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <?= $milestone->name ?>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption tools pull-left">
                    <a href="javascript:;" class="collapse"><?=$this->title?></a>
                </div>
                <div class="actions">
                    <a href="<?= Url::toRoute(['/tasks/create','milestone_id' => $milestone->id]) ?>" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New task </span>
                    </a>
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
                            <th width="5%">
                                №
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Department
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
                            </td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" id="filter_name">
                            </td>
                            <td>
                                <?= Html::dropDownList('',null,ArrayHelper::merge (['' => ''], $departmentsArr), [
                                    'id' => 'filter_department_id',
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
        <!-- End: life time stats -->
    </div>
</div>
<!-- END PAGE CONTENT-->