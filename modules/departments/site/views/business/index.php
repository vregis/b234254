<?php

use modules\tasks\models\DelegateTask;
use yii\helpers\Url;
use modules\milestones\models\Milestone;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use modules\departments\models\Idea;
use modules\user\models\User;
use yii\helpers\ArrayHelper;

$this->registerCssFile("/css/business.css");
$this->registerCssFile("/css/task.css");

$msgJs = <<<JS
    $(document).ready(function(){
        var offs = 32;
        console.log(offs);
        $('.well').css({
            'margin-top': offs - 2,
            'margin-bottom': offs - 2
        });
    });
        function fontSize() {
            if($('html').width() < 767) {
                var width = 520; // ширина, от которой идет отсчет
                var fontSize = 10; // минимальный размер шрифта
                var bodyWidth = $('html').width();
                var multiplier = bodyWidth / width;
                if ($('html').width() >= width) fontSize = Math.floor(fontSize * multiplier);
                $('.tables-business').css({fontSize: fontSize+'px'});
            }
            else {
                $('.tables-business').css({fontSize: '14px'});
            }
        }
        $(function() { fontSize(); });
        $(window).resize(function() { fontSize(); });
JS;
$this->registerJs($msgJs);
?>
<div class="col-md-12 tables-business">
    <div class="well" style="margin: 0 auto; max-width: 1000px">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="<?= count($self_userTools) != 0 ? 'active' : '' ?>"><a href="#my" aria-controls="my" role="tab" data-toggle="tab">My business</a></li>
            <li role="presentation" class="<?= count($self_userTools) == 0 ? 'active' : '' ?>"><a id="btn-offered-block" href="#delegated" aria-controls="delegated" role="tab" data-toggle="tab">Delegated busineses <!--<span class="label label-danger circle"></span>--></a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in <?= count($self_userTools) != 0 ? 'in active' : '' ?>" id="my">
            <? if(count($self_userTools) == 0) : ?>
                <div class="text-center" style="padding:22px 0;color:#8eb6f8;">
                    You do not yet have own business. But you have an idea certainly.<br>
                    Realize it
                </div>
            <?php else: ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 52px;"><a href="#" class="btn btn-primary circle static" style="margin:0;border:none !important;font-size: 24px;line-height: 42px !important;"><i class="ico-history"></i></a></th>
                        <th> Name </th>
                        <th width="170"> Creation date </th>
                        <th width="130"> Tasks </th>
                        <th width="130"> New </th>
                        <th width="130"> In progress </th>
                        <th width="130"> Completed </th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach($self_userTools as $current_userTool) : ?>
                        <tr>
                            <?
                            $task_count = Task::find()
                                ->join('JOIN','milestone','milestone.id = task.milestone_id')
                                ->join('JOIN', 'department', 'department.id = task.department_id')
                                ->where(['is_hidden' => '0','department.is_additional' => 0])
                                ->count();
                            $count_progress = TaskUser::find()->where(['user_tool_id' => $current_userTool->id,'status' => TaskUser::$status_active])->count();
                            $count_completed = TaskUser::find()->where(['user_tool_id' => $current_userTool->id,'status' => TaskUser::$status_completed])->count();
                            ?>
                            <td>
                                <a href="javascript:;" class="dropmenu1 history btn btn-primary circle" data-toggle="popover" data-not_autoclose="1"><i class="ico-history"></i></a>
                            </td>
                            <td style="text-transform: uppercase">
                                <a target="_blank" href="<?= Url::toRoute(['/departments/business/select-tool', 'id' => $current_userTool->id]) ?>"><?= $current_userTool->name ? $current_userTool->name : 'No name' ?> <!--<span class="label label-danger circle"></span>--></a>
                            </td>
                            <td>
                                <?= (new DateTime($current_userTool->create_date))->format("m/d/Y") ?>
                            </td>
                            <td>
                                <?= $task_count ?>
                            </td>
                            <td>
                                <?= $task_count - $count_progress - $count_completed ?>
                            </td>
                            <td>
                                <?= $count_progress ?>
                            </td>
                            <td>
                                <?= $count_completed ?>
                            </td>
                        </tr>
                    <? endforeach; ?>
                    </tbody>
                </table>
                <div id="huistory" class="huistory" style="display:none;">
                    <a href="<?= Url::toRoute(['/departments/business/dashboard-editing','id' => $current_userTool->id]) ?>">Business Dashboard</a>
                    <a class="disabled">Team</a>
                    <a href="<?= Url::toRoute(['/departments/business/delete','id' => $current_userTool->id]) ?>">Delete Business</a>
                </div>
                <? endif; ?>
                <div class="text-center btn-div" style="padding-top:30px;">
                    <a href="<?= Url::toRoute(['/departments/business/create']) ?>" style="padding: 0px 75px;line-height: 45px !important;height: 45px;vertical-align: middle;" class="btn btn-lg btn-primary">Create new business</a>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade <?= count($self_userTools) == 0 ? 'in active' : '' ?>" id="delegated">
                <div id="delegated_businesses">
                    <?= $delegated_businesses ?>
                </div>
                
                <? require __DIR__.'/blocks/find_job.php' ?>
                <div class="text-center btn-div" style="padding-top:30px;">
                    <a href="#" style="padding: 0px 75px;line-height: 45px !important;height: 45px;vertical-align: middle;" class="btn btn-lg btn-primary toggle-findjod" data-toggle="collapse" data-target="#find_job" aria-expanded="false">Search <i style="font-size: 20px;position: absolute;top: 14px;margin-left: 10px;" class="fa fa-angle-down"></i></a>
                </div>
                
            </div>
        </div>

    </div>
</div>
<style>
    .dropselect1{
        min-width:190px !important;
        width:190px !important;
    }
    .huistory ul{
        position: relative;
        top: 0;
        border:none;
        margin: 0;
            list-style-type: none;
    padding: 0;
    }
    .huistory a{
        border:none;
        display:block;
        width:100%;
        background:none !important;
        color: #7b7b7b !important;
        padding: 0 !important;
        line-height: 30px;
        text-decoration: none;
        text-align: center;
    }
    .huistory a:hover{
        background:#8eb6f8 !important;
        color:#fff !important;
        border-radius:3px;
    }
</style>
<script>
    $(document).on('change',function(){
        $('.page-content').mCustomScrollbar({
            setHeight: $('.page-content').css('minHeight'),
            theme:"dark"
        });
    });
    $(document).ready(function () {
        $(".dropmenu1.history").popover({
            placement:"bottom",
            html:true,
            content:$("#huistory"),
            container:$("body"),
            template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
        });
        $(".dropmenu1.history1").popover({
            placement:"bottom",
            html:true,
            content:$("#huistory1"),
            container:$("body"),
            template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
        });
        $(".dropmenu1.history").on('show.bs.popover',function(){
            $("#huistory").show();
            $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
        }).on('hide.bs.popover',function(){
            $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
        });
        $(".dropmenu1.history1").on('show.bs.popover',function(){
            $("#huistory1").show();
            $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
        }).on('hide.bs.popover',function(){
            $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
        });
        $(".page-content-wrapper").mCustomScrollbar("destroy");
        $('.page-content-wrapper').mCustomScrollbar({
            setHeight: $('.page-content').css('minHeight'),
            theme:"dark"
        });
        $(".tables-business > .well > .nav-tabs a[data-toggle='tab']").on('show.bs.tab',function(){
            $(".page-content-wrapper").mCustomScrollbar("destroy");
            $('.page-content-wrapper').mCustomScrollbar({
                setHeight: $('.page-content').css('minHeight'),
                theme:"dark"
            });
                $("#find_job").on('shown.bs.collapse',function(){
                    $(".toggle-findjod .fa").removeClass('fa-angle-down').addClass('fa-angle-up');
        $(".page-content-wrapper").mCustomScrollbar("destroy");
        $('.page-content-wrapper').mCustomScrollbar({
            setHeight: $('.page-content').css('minHeight'),
            theme:"dark"
        });
                });
                $("#find_job").on('hidden.bs.collapse',function(){
                    $(".toggle-findjod .fa").removeClass('fa-angle-up').addClass('fa-angle-down');
        $(".page-content-wrapper").mCustomScrollbar("destroy");
        $('.page-content-wrapper').mCustomScrollbar({
            setHeight: $('.page-content').css('minHeight'),
            theme:"dark"
        });
                });
        });
            // $(".tables-business > .well > .nav-tabs a[data-toggle='tab']").click(function(){
            //     console.log("asdasda");
            //     $(".huistory a[data-toggle='tab'] i").remove();
            //     $(this).append('<i class="ico-check1"></i>');
            //     $(this).tab('show');
            //     // $(".dropmenu1.status").popover('hide');
            // });
    });

</script>