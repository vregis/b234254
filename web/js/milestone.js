function openTask(id, is_custom){
    if(is_custom == undefined) {
        is_custom = false;
    }
    $.ajax({
        url: '/departments/getpopuptask',
        type: 'post',
        dataType: 'json',
        data: {
            _csrf: $("meta[name=csrf-token]").attr("content"),
            id:id,
            is_custom: is_custom
        },
        success: function(response){
            if(!response.error) {
                var task = $('#task');
                task.html(response.html);
                task.modal();
                task.css('position', 'absolute');
                task.css('top', '50%');
                task.css('margin-top', '-310px');
                $('.collapse').collapse({
                    toggle: false
                });
                setTimeout(function () {
                    var height = $('.task').height() + 34;
                    if (height > 610 && !is_custom) {
                        height = 610;
                    }
                    $("#task .task").mCustomScrollbar({
                        theme: "dark",
                        axis: "y",
                        setHeight: height
                    });
                    $.each($(".b-page-checkbox-wrap .md-radio .task-name"), function () {
                        console.log($(this).width() / 2 - 13);
                        var offsetL = $(this).width() / 2 - 13;
                        $(this).css({"left": "-" + offsetL + "px"});
                    });
                }, 200);
                $(".task-title .item.time input[type='text']").blur(function () {
                    var text = $(this).val();
                    if (text.indexOf('h') == -1) {
                        $(this).val(text + "h");
                    }
                });

                task.attr('data-task_user_id', response.task_user_id);
                new Task(response.task_user_id, response.is_my, is_custom);
                if (is_custom) {
                    new TaskRoadmap();
                    new TaskPersonGoal();
                }
            }
            else {
                toastr.info("Will be available in the next version");
            }
            App.unblockUI('.container-fluid');
        }
    });

    var task = $('#task');
    task.off();
    task.on('show.bs.modal', function (e) {
        console.log('show.bs.modal');
        setTimeout(function(){
            $("#input-time, #input-price").inputmask({
                "mask": "9",
                "repeat": 10,
                "greedy": false,
                "onincomplete":function(){
                    var text = $("#input-time").val();
                    console.log("text "+text);
                    $("#input-time").attr('value',text + "h");
                }
            }); // ~ mask "9" or mask "99" or ... mask "9999999999"
            $("#input-time").blur(function(){
                console.log("asda");
                var text = $("#input-time").val();
                if(text.indexOf('h') == -1){
                    $("#input-time").inputmask({'setvalue': text + "h"});
                }
            });
        $('.task-body .block.desc .collapse').on('shown.bs.collapse',function(e){
            e.preventDefault();
            $('.task-body .block.desc .collapse').not($(this)).collapse('hide');
            $(this).collapse('show');
            $("#task").on('click',function(){
                $('.task-body .block.desc .collapse').collapse('hide');
            });
        });
        },500);
    });
    task.on('hide.bs.modal',function(){
        console.log("hide task");
        var id = $('.hidden-task-id').text();
        clsTask(id);
        window.history.pushState('', 'BSB', '/departments');
        $(".page-content-wrapper").mCustomScrollbar("destroy");
        $('.page-content-wrapper').mCustomScrollbar({
            setHeight: $('.page-content').css('minHeight'),
            theme:"dark"
        });
    });

    App.blockUI({
        target: '.container-fluid',
        animate: true
    });
}

$( document ).ready(function() {
    var task = $('#task');
    var milestone_main = $('.milestone-main');
    var task_open_id = parseInt(milestone_main.attr('data-task_open_id'));
    if(task_open_id > 0) {
        var is_custom = milestone_main.attr('data-is-custom');
        if(is_custom == 1) {
            is_custom = true;
        }else {
            is_custom = false;
        }
        if(is_custom) {
            task.attr('data-backdrop','static');
            task.attr('data-keyboard','false');
        }
        openTask(task_open_id, is_custom);
    }
});

$(document).on('click', '.series-content', function(){
    var id = $(this).attr('data-id');
    var is_custom = $(this).attr('data-is-custom');
    if(is_custom == 1) {
        is_custom = true;
    }else {
        is_custom = false;
    }
    openTask(id, is_custom);
});
