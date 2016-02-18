/**
 * Created by toozzapc2 on 14.01.2016.
 */

function ServiceData(main_class) {
    var dynamicData = new DynamicData(main_class);

    var g_main_class = main_class;
    var g_point_class = '.' + main_class;

    dynamicData.handlerUpdate = function(parent,response) {
        if(response.hasOwnProperty('html')) {
            var select_task = parent.closest('.dynamic-block').find('.select_task');
            select_task.html(response.html);
            select_task.find('.selectpicker').selectpicker();
            select_task.find('.my-popover').popover({
                placement: "bottom",
                trigger: "click",
                html:true
            });
        }
    };


    $(document).on('click', g_point_class + ' .delete-ajax', function(){
      /*  var id = $(this).closest('div.dynamic-block').data('id');
        var __this__ = $(this);
        var dep = $(this).closest('.panel-group').attr('data-department');
        var data = {
            command : 'delete',
            id:id,
            dep: dep
        };
        $.ajax({
            url: '/core/' + g_main_class + '-ajax',
            data: data,
            dataType: 'json',
            type: 'post',
            async: 'false',
            success: function(response){
                __this__.closest('.panel-group').find('.service').hide();
                $('.sel2').selectpicker({});
            }
        });*/
    });



    $(document).on('change', g_point_class + ' select.departments', function(){
        $(this).closest('div.departments').find('.start').hide();
        var id = $(this).val();
        var parent = $(this);
        var data = {
            command : 'getspecfromdep',
            id:id
        };
        $.ajax({
            url: '/core/' + g_main_class + '-ajax',
            type: 'post',
            dataType: 'json',
            data:data,
            success: function(response){
                if(response.error == false){
                    var select_specialization = parent.closest('.dynamic-block').find('.select_specialization');
                    select_specialization.html(response.html);
                    select_specialization.find('.selectpicker').selectpicker();
                    parent.closest('.dynamic-block').find('div.spec_level').children('button').addClass('disabled');
                    setTimeout(function(){
                        $('.services .service input.form-control[data-key="rate"]').inputmask({
                            "mask": "9",
                            "repeat": 3,
                            "greedy": false,
                        }); // 
                    },500);
                    console.log("hui");
                }
            }
        })
    });
}
ServiceData.prototype = DynamicData;

