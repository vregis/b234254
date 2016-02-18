/**
 * Created by toozzapc2 on 02.12.2015.
 */
var SelectTasks = function () {

    var handleSelectTasks = function (id,url,view,model) {

        var actionRender = function (data, type, row, meta) {
            var id = data;
            html = '<a name="' + row[0] + '" id="' + id + '" class="btn-select btn default btn-xs blue"><i class="fa fa-check"></i> Select </a>';
            $( "#list-preceding-tasks a" ).each(function( i ) {
                if($(this).attr('id') == id) {
                    html = '<a name="' + row[0] + '" id="' + id + '" class="btn-remove btn btn-danger btn-xs black"><i class="fa fa-trash-o"></i> Remove </a>';
                }
            });
            return html;
        };

        var grid = new Datatable();

        function updateBtns () {
            $( ".btn-select" ).each(function( i ) {
                var btn = $(this);
                btn.unbind( "click" );
                btn.click(function() {
                    $("#list-preceding-tasks").append( '<div>' +
                    '<a id="' + $(this).attr('id') + '" class="preceding_task_name" href="' + view + $(this).attr('id') + '" onclick="return !window.open(this.href)">' + $(this).attr('name') + '</a>' +
                    '<a id="' + $(this).attr('id') + '" class="btn-remove-task text-danger"><i class="fa fa-trash-o"></i></a>' +
                    '</div>' );
                    $(this).removeClass("btn-select btn default btn-xs blue").addClass("btn-remove btn btn-danger btn-xs black");
                    $(this).html('<i class="fa fa-trash-o"></i> Remove ');
                    updateBtns();
                });
            });
            $( ".btn-remove" ).each(function( i ) {
                var btn = $(this);
                btn.unbind( "click" );
                btn.click(function() {
                    $( "#list-preceding-tasks a" ).each(function( i ) {
                        if($(this).attr('id') == btn.attr('id')) {
                            $(this).remove();
                        }
                    });
                    $(this).removeClass('btn-remove btn btn-danger btn-xs black').addClass('btn-select btn default btn-xs blue');
                    $(this).html('<i class="fa fa-check"></i> Select ');
                    updateBtns();
                });
            });
            $( ".btn-remove-task" ).each(function( i ) {
                var btn = $(this);
                btn.unbind( "click" );
                btn.click(function() {
                    $( "#list-preceding-tasks a" ).each(function( i ) {
                        if($(this).attr('id') == btn.attr('id')) {
                            $(this).remove();
                        }
                    });
                    updateBtns();
                    grid.resetFilter();
                });
            });
        }

        $('#filter_milestone_id').change(function(){
            var val = $("#filter_milestone_id option:selected").val();
            $('#filter_milestone_id').attr('value',val);
        });
        $('#filter_department_id').change(function(){
            var val = $("#filter_department_id option:selected").val();
            $('#filter_department_id').attr('value',val);
        });
        $('.filter-cancel').click(function(){
            $('#filter_milestone_id').removeAttr('value');
            $('#filter_department_id').removeAttr('value');
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
                updateBtns();
            },
            loadingMessage: 'Loading...',
            dataTable: {
                "bStateSave": true,
                "pageLength": 10,
                "ajax": {
                    "url": url,
                    "data": function ( d ) {
                        var myData = {
                            "_csrf" : $("meta[name=csrf-token]").attr("content"),
                            "model" : model,
                            "keys" : '["name", "milestone_id", "department_id", "id"]',
                            "where" : '["!=","id",' + id + ']'
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
                    { "searchable": false, "targets": [3] },
                    { "targets": 0,
                        "render": function nameRender(data, type, row, meta) {
                            html = '<a href="' + view + row[3] + '" onclick="return !window.open(this.href)">' + data + '</a>';
                            return html;
                        }
                    },
                    { "targets": 3,
                        "render": actionRender
                    }
                ],
                "bLengthChange": false,
                "order": [
                    [0, "asc"]
                ]// set first column as a default sort by asc
            }
        });

    };

    return {

        //main function to initiate the module
        init: function (id,url,view,model) {
            handleSelectTasks(id,url,view,model);
        }
    };

}();