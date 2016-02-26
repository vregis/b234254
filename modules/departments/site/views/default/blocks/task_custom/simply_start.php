<?
use yii\helpers\Url;
use modules\tasks\models\Task;
?>
<div class="container-fluid">
 <div class="row task-title" style="margin-bottom: 0px;">
    <div class="text-center" style="font-size:40px;font-weight: bold;color: rgba(90,90,90,0.50);">START</div>
    <div class="name text-center" style="margin:15px auto 30px;"><?= $task->description ?></div>
</div>
    <div class="task-body">
        <? if($task->id == Task::$task_roadmap_personal_id) : ?>
            <a href="<?= Url::toRoute(['/departments/task','id' => Task::$task_bussiness_role_id]) ?>" class="btn btn-primary btn-lg">Continue</a><!-- person goal -->
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
            template:'<div class="popover top-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ullam, laboriosam non ea quos accusamus accusantium repellendus porro tempore quis esse in eius vero, mollitia nihil? Ipsa voluptates, dicta magnam."
        });
        $("#side_road .item-3").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            template:'<div class="popover top-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ullam, laboriosam non ea quos accusamus accusantium repellendus porro tempore quis esse in eius vero, mollitia nihil? Ipsa voluptates, dicta magnam."
        });
        $("#side_road .item-4").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            template:'<div class="popover bottom-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ullam, laboriosam non ea quos accusamus accusantium repellendus porro tempore quis esse in eius vero, mollitia nihil? Ipsa voluptates, dicta magnam."
        });
        $("#side_road .item-5").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            template:'<div class="popover bottom-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ullam, laboriosam non ea quos accusamus accusantium repellendus porro tempore quis esse in eius vero, mollitia nihil? Ipsa voluptates, dicta magnam."
        });
        $("#side_road .item-6").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            template:'<div class="popover bottom-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ullam, laboriosam non ea quos accusamus accusantium repellendus porro tempore quis esse in eius vero, mollitia nihil? Ipsa voluptates, dicta magnam."
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