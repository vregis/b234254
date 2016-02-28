<?php
use modules\tasks\models\Task;

$this->registerJsFile("/plugins/moment/moment.js");
$this->registerJsFile("/plugins/modernizr-custom.js");
$this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js");

$this->registerCssFile("/metronic/theme/assets/global/plugins/select2/css/select2.min.css");
$this->registerCssFile("/metronic/theme/assets/global/plugins/select2/css/select2-bootstrap.min.css");

$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/select2/js/select2.full.min.js");

$this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js");
$this->registerJsFile("/js/bootstrap-confirmation.js");
$this->registerJsFile("/js/tool/Task.js");

$this->registerCssFile("/css/department.css");

$this->registerCssFile("/plugins/gantt/assets/css/main.css");
// $this->registerCssFile("/plugins/uikit/css/uikit.almost-flat.min.css");
$this->registerJsFile("/plugins/uikit/js/uikit.js");
$this->registerJsFile("/plugins/uikit/js/components/tooltip.js");
$this->registerJsFile("/plugins/gantt/assets/js/custom/gantt_chart.js");
$this->registerJsFile("/plugins/gantt/assets/js/pages/plugins_gantt_chart.js");
//var_dump(Yii::$app->session['spec']);

$this->registerJsFile("/js/min/underscore-min.js");
$this->registerJsFile("/js/min/jquery.mask.min.js");

$this->registerJsFile("/js/tool/task_custom/TaskRoadmap.js");
$this->registerJsFile("/js/tool/task_custom/TaskPersonGoal.js");

use yii\helpers\Url;
use \modules\departments\models\Specialization;
use modules\user\models\Profile;

$is_task_roadmap_personal = $task_open_id == Task::$task_roadmap_personal_id;
$msgJs = <<<JS

$('.page-content').addClass('milestones');
    function fontSize() {
        if($('html').width() < 767) {
            var width = 520; // ширина, от которой идет отсчет
            var fontSize = 10; // минимальный размер шрифта
            var bodyWidth = $('html').width();
            var multiplier = bodyWidth / width;
            if ($('html').width() >= width) fontSize = Math.floor(fontSize * multiplier);
            $('.table-block').css({fontSize: fontSize+'px'});
        }
        else {
            $('.table-block').css({fontSize: '14px'});
        }
    }
        //     var offs;
        // if($('.well').height() > ($(window).height() - $('.page-header').height() - $(".page-footer").height())){
        //     offs = 30;
        // }else{
        //     offs = $(".page-content").height() / 2 - $('.well').height() / 2 - 32;
        // }
        // // var offs = 32;
        //  // if
        // $('.well').css({
        //     'margin-top': offs,
        //     'margin-bottom': offs
        // });
    $(function() { fontSize(); });
    $(window).resize(function() { fontSize(); });
JS;
$this->registerJs($msgJs);
?>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<style>
    .specon, .on {
        background-color: green;
    }

</style>
<div class="milestone-main well well-sm" data-task_open_id="<?= $task_open_id ?>" data-is-custom="<?php echo $task_open_id > 0 ? Task::find()->where(['id' => $task_open_id])->one()->is_custom : '0' ?>">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <?php echo $ml?>
            </div>
        </div>
    </div>
</div>
<script>

$(".hor-menu .btn-group-justified > .btn-group .btn .circle").popover({
    container: 'body',
    placement: "bottom",
    content : 'Will be available in the next version'
});
    $(document).on('click', '.on', function(e){
        var target = $(e.target);
        if (target.is("li"))
            return;
        i = 0;
        var count = $(this).closest('.milestones').find('.on').each(function(){
            i++;
        })
        if(i == 1){
            return false;
        }
        $(this).removeClass('on');
        $(this).addClass('off');
        disableallspec($(this));
        getattributes($(this).closest('.milestones'));


    })

    $(document).on('click', '.off', function(e){

        var target = $(e.target);
        if (target.is("li"))
            return;
        if($(this).hasClass('disabled')){
            return false;
        }

        $(this).removeClass('off');
        $(this).addClass('on');
        enableallspec($(this));
        getattributes($(this).closest('.milestones'));

    })



    $(document).on('click', '.specon', function(e){
        e.stopPropagation();
        i = 0;
        var count = $(this).closest('.spec_list').find('.specon').each(function(){
            i++;
        })
        if(i == 1){
            var j = 0; //its counter enabled department, if j = 1, we locked to disable last department
            $(this).closest('.milestones').find('.dep').each(function(){
                if($(this).hasClass('on')){
                    j++;
                }
            })
            if(j == 1){
                return false;
            }else{
                $(this).closest('.department').removeClass('on');
                $(this).closest('.department').addClass('off');
            }
        }
        $(this).removeClass('specon');
        $(this).addClass('specoff');
        getattributes($(this).closest('.milestones'));
    });

    $(document).on('click', '.specoff', function(e){
    e.stopPropagation();
        if($(this).closest('.department').hasClass('off')){
            $(this).closest('.department').removeClass('off');
            $(this).closest('.department').addClass('on');
        }
        $(this).removeClass('specoff');
        $(this).addClass('specon');

        getattributes($(this).closest('.milestones'));
    });

    function setHandlerMilestones() {
        var img = $('.milestones-users').find('img');
        img.off();
        img.on('click',function(){
            var milestones_users = $(this).closest('.milestones-users');
            var count = 0;
            milestones_users.find('img').each(function() {
                if($(this).hasClass('active')) {
                    count ++;
                }
            });
            if(count > 1 || !$(this).hasClass('active')) {
                $(this).toggleClass('active');
                getattributes($(this).closest('.milestones'));
            }
        });
    }
    setHandlerMilestones();

    function getattributes(milestones, status){

        if(status === undefined){
            status = 'all';
        }
        var dep = [];
        milestones.find('.on').each(function(){
            dep.push($(this).attr('data-id'));
        });

        var spec = [];
        milestones.find('.specon').each(function(){
            spec.push($(this).attr('data-id'));
        });
        console.log(dep);

        var milestone_id = milestones.attr('data-milestone_id');

        var users = [];
        var milestones_users = milestones.find('.milestones-users');
        milestones_users.find('img').each(function() {
            if($(this).hasClass('active')) {
                users.push($(this).attr('data-id'));
            }
        });

        sendajax(dep, spec, status, milestone_id, users);
    }

    function enableallspec(dep){
        dep.find('ul').children('li').each(function(){
            $(this).removeClass('specoff');
            $(this).addClass('specon');
        })
    }

    function disableallspec(dep){
        dep.find('ul').children('li').each(function(){
            $(this).removeClass('specon');
            $(this).addClass('specoff');
        })
    }

    function clsTask(id){
        $.ajax({
            url: '/departments/get-milestone-from-task-id',
            data: {id:id},
            type: 'post',
            dataType: 'json',
            success: function(response){
                var that = $('div#ml'+response.id);
                getattributes(that.closest('.milestones'));
                that = $('div#mlAll');
                getattributes(that.closest('.milestones'));
            }
        })
    }

    function sendajax(dep, spec, status, milestone_id, users){
        $.ajax({
            url: '/departments/sort',
            type: 'post',
            dataType: 'json',
            data: {
                dep:dep,
                spec:spec,
                status:status,
                milestone_id:milestone_id,
                users:users
            },
            success: function(response){
                $('.ganttable'+milestone_id+'').html(response.gant);
                $('.ajaxbody'+milestone_id+'').html(response.table);
                var that = $('div#ml'+response.id);
                var milestones_users = that.closest('.milestones').find('.milestones-users');
                milestones_users.after(response.milestones_users);
                milestones_users.remove();
                setHandlerMilestones();
                $(".panel-collapse.in div.ganttview-slide-container").mCustomScrollbar("update");
                $(".panel-collapse.in div.ganttview-slide-container").mCustomScrollbar({
                    theme:"dark",
                    axis:"x", // horizontal scrollbar
                    contentTouchScroll: 25,
                    documentTouchScroll: true,
                    setLeft:0
                });
            }
        })
    }

    $(document).on('click', '.sort_status', function(){
        var status = $(this).data('p');
        getattributes($(this).closest('.milestones'), status);
    });

 (function($){

        $(window).load(function(){
            $('.page-content-wrapper').mCustomScrollbar({
                setHeight: $('.page-content').css('minHeight'),
                theme:"dark",
                scrollbarPosition: "relative",
                scrollInertia: 500,
                mouseWheel:{ scrollAmount: 120 }
            });
        });
        $(window).resize(function(){
            $('.page-content-wrapper').mCustomScrollbar({
                setHeight: $('.page-content').css('minHeight'),
                theme:"dark",
                scrollbarPosition: "relative",
                scrollInertia: 500,
                mouseWheel:{ scrollAmount: 120 }
            });
        });
    })(jQuery);

</script>

<script>
    $(function() {

        $('.empty').each(function(){
            $(this).closest('.department').addClass('disabled');
            $(this).closest('.department').addClass('off');
            $(this).closest('.department').removeClass('on');
        })



        $(".exp-controller").remove();
        $.uniform.restore("#viewType");
        $("#viewType").bootstrapSwitch({
            onText: "List",
            offText: "Chart",
            size: "small",
            // handleWidth:"50px",
            // labelWidth: "50px"
        });
    });
</script>

<style>
    .gant_avatar {
        display: inline-block;
        vertical-align: middle;
        width: 30px;
        height: 30px;
        margin-left: 10px;
        border-radius: 50% !important;
        border: 2px solid #929291;
        cursor: pointer;
        -webkit-transition: 0.3s linear all;
        -moz-transition: 0.3s linear all;
        transition: 0.3s linear all;
    }

    .gant_avatar.active {
        border-color: #53D769;
    }
    .dep-color-1.on{
          background:#9187d0!important;
      }
    .dep-color-2.on{
        background:#b787d1!important;
    }
    .dep-color-3.on{
        background:#fd6d64!important;
    }
    .dep-color-4.on{
        background:#ffa25d!important;
    }
    .dep-color-5.on{
        background:#ffd147!important;
    }
    .dep-color-6.on{
        background:#aad772!important;
    }
    .dep-color-7.on{
        background:#70cac8!important;
    }
    .dep-color-8.on{
        background:#5dc9f0!important;
    }





    .dep-color-1.off:not(.disabled){
        border: 2px solid #9187d0!important;
    }
    .dep-color-2.off:not(.disabled){
        border: 2px solid #b787d1!important;
    }
    .dep-color-3.off:not(.disabled){
        border: 2px solid #fd6d64!important;
    }
    .dep-color-4.off:not(.disabled){
        border: 2px solid #ffa25d!important;
    }
    .dep-color-5.off:not(.disabled){
        border: 2px solid #ffd147!important;
    }
    .dep-color-6.off:not(.disabled){
        border: 2px solid #aad772!important;
    }
    .dep-color-7.off:not(.disabled){
        border: 2px solid #70cac8!important;
    }
    .dep-color-8.off:not(.disabled){
        border: 2px solid #5dc9f0!important;
    }

</style>
