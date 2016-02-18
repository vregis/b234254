<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 06.01.2016
 * Time: 9:36
 */

use yii\helpers\Url;

$this->registerCssFile("/metronic/theme/assets/global/plugins/datatables/datatables.min.css");
$this->registerCssFile("/metronic/theme/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css");

$this->registerJsFile("/metronic/theme/assets/global/scripts/datatable.min.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/datatables/datatables.min.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js");

$this->registerJsFile("/js/tool/Task.js");

$url = Url::toRoute(["/core/data-table"]);
$delegate = Url::toRoute(["/departments/business/delegate"]).'?task_id='.$task->id.'&delegate_user_id=';
$model = '\\\modules\\\user\\\models\\\User';
$user_id = Yii::$app->user->identity->id;
$exclude_ids[] = $user_id;
foreach($delegate_user_ids as $key => $value) {
    $exclude_ids[] = $key;
}
$exclude_ids = json_encode($exclude_ids);
$task_user_id = $task_user->id;
$msgJs = <<<JS
    var grid = new Datatable();

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
                "lengthMenu": [[10, 25, 100, -1], [10, 25, 100, "All"]],
                "pageLength": 100,
                "ajax": {
                    "url": "$url",
                    "data": function ( d ) {
                        var myData = {
                            "_csrf" : $("meta[name=csrf-token]").attr("content"),
                            "model" : "$model",
                            "keys" : '["username", "id"]',
                            "whereNo" : '$exclude_ids'
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
                    { "searchable": false, "targets": [0,1] },
                    { "targets": 0,
                        "render":  function (data, type, row, meta) {
                            html = '<a data-id="' + row[1] + '" class="btn delegate-task">' + data + '</a>';
                            return html;
                        }
                    },
                    { "targets": 1,
                        "render":  function (data, type, row, meta) {
                            html = '<a data-id="' + row[1] + '" class="btn blue delegate-task">Delegate</a>';
                            return html;
                        }
                    }
                ],
                "order": []// set first column as a default sort by asc
            }
        });

        new Task('$task_user_id');
JS;
$this->registerJs($msgJs);
?>

<table class="table table-striped table-bordered table-hover" id="datatable_ajax">
    <thead>
    <tr role="row" class="heading">
        <th>
            Nick-Name
        </th>
        <th width="70">
        </th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
