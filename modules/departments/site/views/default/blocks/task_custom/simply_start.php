<?
use yii\helpers\Url;
use modules\tasks\models\Task;
?>
<div class="container-fluid">
 <div class="row task-title" style="margin-bottom: 0px;">
    <div class="text-center" style="font-size:40px;font-weight: bold;color: rgba(90,90,90,0.50);">Start</div>
    <div class="name text-center" style="margin:15px auto 30px;"><?= $task->description ?></div>
</div>
    <div class="task-body">
        <? if($task->id == Task::$task_roadmap_personal_id) : ?>
            <a href="<?= Url::toRoute(['/departments/task','id' => Task::$task_bussiness_role_id]) ?>?first=1" class="btn btn-primary btn-lg">Continue</a><!-- person goal -->
        <? else : ?>
            <div class="pull-right inline">
                <a href="#" data-dismiss="modal" class="href-black task-close"></a>
            </div>
        <? endif; ?>
    </div>
</div>   
</div>
<script>
    $(document).ready(function(){
        $("#side_road .item-2").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover top-fix item-2" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(282);?>"
        });
        $("#side_road .item-3").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover top-fix item-3" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(283);?>"
        });
        $("#side_road .item-4").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-4" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(37);?>"
        });
        $("#side_road .item-5").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-5" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(38);?>"
        });
        $("#side_road .item-6").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-6" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(39);?>"
        });
    });
</script>
<style>
    .well{
        width:675px !important;
    }
/*    .b-page-checkbox-wrap .md-radio:nth-child(1) label > .box{
        border-color: #26C281 !important;
    }*/
</style>

<script>
    $(function(){
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
        window.onhashchange=function(){window.location.hash="no-back-button";}
    })

</script>