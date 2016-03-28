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
                    if (height > 620 && !is_custom) {
                        height = 620;
                    }
                    $("#task .task").mCustomScrollbar({
                        theme: "dark",
                        axis: "y",
                        setHeight: height
                    });
                    $.each($(".b-page-checkbox-wrap .md-radio .task-name"), function () {
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
        setTimeout(function(){
            $("#counter").on('shown.bs.collapse',function(){
                console.log("show counter");
                $("#btn-delegate, #btn-delegate+button.btn-success").addClass('static disabled');
                $("#btn-delegate+button.btn-success").removeClass('active');
            }).on('hide.bs.collapse',function(){
                $("#btn-delegate, #btn-delegate+button.btn-success").removeClass('static disabled');
                $("#btn-delegate+button.btn-success").addClass('active');
                console.log("hide counter");
            });
            $("#task .gant_avatar").popover({
                container: $("#task"),
                placement: "bottom",
                html:true,
                trigger:"hover",
                template:'<div class="popover gant_av" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
            }); 
            $(".advanced-search-btn").on('show.bs.popover',function(){
                $(".advanced-search-btn").addClass('active');
            }).on('hide.bs.popover',function(){
               $(".advanced-search-btn").removeClass('active');
            });
            $(".invite-by-email").on('show.bs.popover',function(){
                $(".invite-by-email").addClass('active');
            }).on('hide.bs.popover',function(){
                $(".invite-by-email").removeClass('active');
            });
            $(".dropmenu1.status").popover({
                placement:"bottom",
                html:true,
                content:$("#status-menu"),
                container:$("body"),
                template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
            });
            $(".dropmenu1.status").on('shown.bs.popover',function(){
                $("#status-menu a[data-toggle='tab']").click(function(){
                    $("#status-menu li").removeClass('active');
                    $(this).tab('show').parents('li').addClass('active');
                    // $(".dropmenu1.status").popover('hide');
                    $("#status-menu a[data-toggle='tab']").on('show.bs.tab',function(){
                        $(".advanced-search-btn").popover('hide');
                        $(".invite-by-email").popover('hide');
                    });
                    $(".dropmenu1.status").popover('hide');

                });
            });
            $(".dropmenu1").on('show.bs.popover',function(){
                $("#status-menu").show();
                $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
            }).on('hide.bs.popover',function(){
                $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
            });
            $("#input-price").inputmask({
                "mask": "9",
                "repeat": 10,
                "greedy": false,
            }); // ~ mask "9" or mask "99" or ... mask "9999999999"
            
            $('.task-body .block.desc a[data-toggle="tab"]').on('shown.bs.tab',function(e){
                $(this).tab('show');
                $(".task-body .block.desc .tab-content > .tab-pane .item").popover({
                    placement: "top",
                    html: true,
                    trigger:"hover",
                    container:$("#task"),
                    template:'<div class="popover material" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                });
            });
        },500);
    });
    task.on('hide.bs.modal',function(){
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

$(document).on('click', '.series-content-guest', function(){


    var id = $(this).attr('data-id');
    var is_custom = $(this).attr('data-is-custom');
    if(is_custom == 1) {
        is_custom = true;
    }else {
        is_custom = false;
    }

    openTaskGuest(id, is_custom);
});



function openTaskGuest(id, is_custom){
    if(is_custom == undefined) {
        is_custom = false;
    }

    $.ajax({
        url: '/departments/getpopuptaskguest',
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
                // var offs = $(window).height()/2 - task.height()/2;
                // console.log($(window).height()/2 - task.height()/2);
                task.css('margin-top', '-310px');
                $('.collapse').collapse({
                    toggle: false
                });


               /* setTimeout(function () {
                    var height = $('.task').height() + 34;
                    if (height > 620 && !is_custom) {
                        height = 620;
                    }
                    $("#task .task").mCustomScrollbar({
                        theme: "dark",
                        axis: "y",
                        setHeight: height
                    });
                    $.each($(".b-page-checkbox-wrap .md-radio .task-name"), function () {
                        var offsetL = $(this).width() / 2 - 13;
                        $(this).css({"left": "-" + offsetL + "px"});
                    });
                }, 200);*/
             /*   $(".task-title .item.time input[type='text']").blur(function () {
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
                }*/
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

    });
    task.on('hide.bs.modal',function(){
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
