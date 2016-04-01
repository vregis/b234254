/**
 * Created by toozzapc2 on 13.01.2016.
 */

function DynamicData(main_class) {

    this.handlerUpdate = function(parent,response) {
    };
    this.handlerAdd = function(elem,response) {
    };

    var g_main_class = main_class;
    var g_point_class = '.' + main_class;
    $(document).on('click', g_point_class + ' .plus', function(){
        $(this).hide();
        var row = $(this).closest('.dynamic-block');
        var class_delete = 'delete';
        if(row.attr('data-id') > 0) {
            class_delete = 'delete-ajax';
        }
        var dep = $(this).closest('.panel-group').attr('data-department');
        $(this).closest('.action_btn').after('<div class="action_btn btn btn-danger circle remove ' + class_delete + '"><i class="ico-delete"></i></div>');
        var data = {
            command : 'add',
            dep: dep
        };
        $.ajax({
            url: '/core/' + g_main_class + '-ajax',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response){
                if(g_point_class == '.service'){
                    var div_experience = $('div' + g_point_class + '.serv-'+dep);
                }else{
                    var div_experience = $('div' + g_point_class);
                }
                div_experience.append(response.html);
                div_experience.find('.selectpicker').selectpicker();
                var elem = $('.dynamic-block').last();
                _this.handlerAdd.call(null,elem,response);
                                setTimeout(function(){
                        $('.services .service input.form-control[data-key="rate"]').inputmask({
                            "mask": "9",
                            "repeat": 3,
                            "greedy": false,
                        }); // 
                    },500);
                    console.log("hui");
            }
        });
    });
    $(document).on('click', g_point_class + ' .delete', function(){
        $(this).closest('div.dynamic-block').remove();
    });
    $(document).on('click', g_point_class + ' .delete-ajax', function(){
        var id = $(this).closest('div.dynamic-block').data('id');
        var parent = $(this);
        var data = {
            command : 'delete',
            id:id
        };
        $.ajax({
            url: '/core/' + g_main_class + '-ajax',
            data: data,
            dataType: 'json',
            type: 'post',
            success: function(){
                parent.closest('div.dynamic-block').remove();
            }
        });
    });

    var parent = $(this);
    var _this = this;

    function beforeUpdate(row) {
        row.find('.disabled').each(function() {
            $(this).removeClass('disabled');
        });
        row.find('select.update').each(function() {
            $(this).attr('disabled', false);
        });
        row.find('input.update').each(function() {
            $(this).attr('disabled', false);
        });

        console.log(row.find('.col-md-6.level-sel'));
        row.find('.col-md-6.level-sel').find('select[data-key="language_skill_id"].selectpicker').selectpicker('val', '1');
    }

    $(document).on('change', g_point_class + ' select.update', function(){
        $(this).closest('div.update').find('.start').hide();
        var row = $(this).closest('div.dynamic-block');
        beforeUpdate(row);
        var parent = $(this);
        var id = row.attr('data-id');
        var update_key = $(this).attr('data-key');
        var update_data = $(this).val();

        var data = {
            command : 'update',
            id:id,
            update_key: update_key,
            update_data: update_data
        };
        $.ajax({
            url: '/core/' + g_main_class + '-ajax',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (response) {
                var row = parent.closest('div.dynamic-block');
                row.attr('data-id', response.id);
                var btn_del = row.find('.delete');
                if(btn_del.length > 0) {
                    btn_del.removeClass('delete');
                    btn_del.addClass('delete-ajax');
                }
                _this.handlerUpdate.call(null,parent,response);
            }
        });
    });
    $(document).on('change', g_point_class + ' input.update', function(){
        var row = $(this).closest('div.dynamic-block');
        beforeUpdate(row);
        var parent = $(this);
        var id = row.attr('data-id');
        var update_key = $(this).attr('data-key');
        var update_data = $(this).val();

        var data = {
            command : 'update',
            id:id,
            update_key: update_key,
            update_data: update_data
        };
        $.ajax({
            url: '/core/' + g_main_class + '-ajax',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (response) {
                var row = parent.closest('div.dynamic-block');
                row.attr('data-id', response.id);
                _this.handlerUpdate.call(null,parent,response);
            }
        });
    });

    $(g_point_class).find('.my-popover').popover({
        placement: "bottom",
        trigger: "click",
        html:true
    });
}

function renderMulti(el){
    $(".dropdown-content").hide();
    // $trigger.parents('.dropdown-toggle').next('.dropdown-content').hide();
    $('.caret .fa').removeClass('fa-angle-up').addClass('fa-angle-down');
    if(el.next('.dropdown-content').is(":visible")){
        if(el.hasClass('task')){
            renderNewTask(el);
        }else{
            renderNewField(el);
        }

        el.next('.dropdown-content').hide();
        el.find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
    }else{
        el.find('.fa').removeClass('fa-angle-down').addClass('fa-angle-up');
        el.next('.dropdown-content').show();
        $(".services .service .multiselect .btn.info").popover({
            placement:"top"
        });
    }


    // if($(this).parents('.dropdown-toggle').next('.dropdown-content').is(":visible")){
    //     renderNewField($(this));
    //     $(this).parents('.dropdown-toggle').next('.dropdown-content').hide();
    //     $(this).find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');

    // }else{
    //     $(this).find('.fa').removeClass('fa-angle-down').addClass('fa-angle-up');
    //     $(this).parents('.dropdown-toggle').next('.dropdown-content').show();
    //     $(".services .service .multiselect .btn.info").popover({
    //         placement:"top"
    //     });
    // }

}

function renderNewField(_this){
    var specialization = [];
    var i = 0;
    that = null;
    dep = null;
    _this.closest('.multiselect').find('input[type=checkbox]').each(function(){
        if($(this).prop('checked') == true && !$(this).closest('li').hasClass('spec-selected')){
            specialization[i] = $(this).attr('data-specid');
            that = $(this);
            i++;
            dep = $(this).closest('.panel-group').attr('data-department');
        }
    })

    $.ajax({
        url: '/core/add-multi-specialization',
        data: {spec:specialization, dep:dep},
        dataType: 'json',
        type: 'post',
        success: function(response){
            if(that != null && dep != null) {
                that.closest('.service').html(response.html);
            }
            $('.sel2').selectpicker({});
            $('input[type=checkbox]').uniform();
        }
    })
}

function renderNewTask(_this){
    var tasks = [];
    that2 = null;
    dep2 = null;
    sspec = null;
    _this.closest('.multiselect').find('input[type=checkbox]').each(function(){
        if($(this).prop('checked') == true && !$(this).closest('li').hasClass('task-selected')){
            tasks[i] = $(this).attr('data-task_id');
            that2 = $(this);
            i++;
            dep2 = $(this).closest('.panel-group').attr('data-department');
            sspec = $(this).closest('.dynamic-block').find('.selected-specialization-name').attr('data-id');
        }
    })

    $.ajax({
        url: '/core/add-multi-task',
        data: {tasks:tasks, dep:dep2, spec:sspec},
        dataType: 'json',
        type: 'post',
        success: function(response){
            if(that2 != null && dep2 != null && sspec != null) {
                that2.closest('.service').html(response.html);
            }
            $('.sel2').selectpicker({});
            $('input[type=checkbox]').uniform();
        }
    })

}
