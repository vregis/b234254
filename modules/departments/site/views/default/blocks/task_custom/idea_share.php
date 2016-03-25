<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 09.02.2016
 * Time: 15:01
 */
use modules\tasks\models\Task;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
$idea_task = Task::find()->where(['id' => 37])->one();
$benefits_task = Task::find()->where(['id' => 38])->one();
$share_task = Task::find()->where(['id' => 39])->one();
?>
<div class="container-fluid">
<div class="row task-title" style="margin-bottom: 8px;">
    <?php $user = \modules\user\models\User::find()->where(['id' => Yii::$app->user->id])->one();?>
    <?php //if($user->is_new == 1 || $user->user_registration_type == 1):?>
        <div class="row task-body" style="margin-top:40px;">
        <div class="desc" style="padding:0 15px;">
            <div class="step">
                <div class="progress"></div>
                <div class="form-md-radios md-radio-inline b-page-checkbox-wrap">
                    <? $name[0] = $idea_task->roadmap_name==''?'Idea':$idea_task->roadmap_name; ?>
                    <? $name[1] = $benefits_task->roadmap_name==''?'Benefits':$benefits_task->roadmap_name; ?>
                    <? $name[2] = $share_task->roadmap_name==''?'Share':$share_task->roadmap_name; ?>
                    <? for($i = 0; $i < 3; $i++) : ?>
                        <div class="md-radio even has-test b-page-checkbox">
                            <div class="task-name">
                                <?= $name[$i] ?>
                            </div>
                            <input type="radio" id="Roadmap[<?= $i ?>]" name="Roadmap" class="md-radiobtn" value="<?= $i ?>">
                            <label for="Roadmap[<?= $i ?>]">
                                <span></span>
                                <span class="check"></span>
                                <span class="box" style="cursor: default;" onclick="return false;"><?=$i==0 || $i==1 ? '<i class="fa fa-check font-green-jungle"></i>' : $i + 1?></span>
                            </label>
                            <div class="text-desc-task" style="display: none">
                                <?= $task->description ?>
                            </div>
                        </div>
                    <? endfor; ?>
                    <div style="display:inline-block;width:100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php //else:?>
<!--         <div class="text-center" style="    margin-top: 10px;font-size:40px;font-weight: bold;color: rgba(90,90,90,0.50);">Share</div> -->
    <?php //endif;?>
        <div class="name text-center" style="margin-top: 20px;">
            <?php if($user->is_new == 1 || $user->user_registration_type == 1):?>
                <span id="title-task text-center"><?php echo $task->description_road?></span>
            <?php else:?>
                <span id="title-task text-center"><?= $task->name ?></span>
            <?php endif;?>
        </div>
</div>
    <div id="idea" class="col-md-12">
        <div class="row form-group" style="margin-bottom: 0;">
            <div class="col-sm-12">
                <? require __DIR__.'/idea/idea_block.php'; ?>
                <a target="_blank" style="margin:0px auto 0;margin-left: 200px;" href="<?= Url::toRoute(['/departments/business/shared-business','id' => $user_tool_id]) ?>" class="btn btn-primary btn-lg fix_is_new pull-left"><?php echo $task->second_button_name==''?'Preview':$task->second_button_name?></a>
                <a style="margin:0px auto 0;margin-right: 200px;" href="<?= Url::toRoute(['/departments/business/']) ?>" class="btn btn-primary btn-lg fix_is_new pull-right"><?php echo $task->button_name==''?'Continue':$task->button_name?></a>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function(){
        $(".b-page-checkbox-wrap .md-radio:nth-child(7)").addClass('active');
        $(".b-page-checkbox-wrap .md-radio.item-2,.b-page-checkbox-wrap .md-radio.item-3,.b-page-checkbox-wrap .md-radio.item-4,.b-page-checkbox-wrap .md-radio.item-5").addClass('done');
        $("#side_road .item-2").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover top-fix item-2" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(282)?><div class="text-center">Completed</div>'
        });
        $("#side_road .item-3").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover top-fix item-3" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(283);?><div class="text-center">Completed</div>'
        });
        $("#side_road .item-4").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-4 completed" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(37);?><div class="text-center">Completed</div>'
        });
        $("#side_road .item-5").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-5 completed" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(38);?><div class="text-center">Completed</div>'
        });
        $("#side_road .item-6").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-6" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(39);?>'
        });
    });
</script>
<style>
    #side_road .progress{
        height:100%;
    }
</style>
<style>
    .task-body .block.desc .content{
        border-radius: 10px 10px 0px 10px !important;
    }
    .b-page-checkbox-wrap .md-radio .task-name{
        left:-50% !important;
    }
    .b-page-checkbox-wrap .md-radio:nth-child(3) .task-name {
        right: auto !important; 
    }
    .well{
            padding: 30px 0px !important;
    }
    .progress{
        width:100%;
    }
    .b-page-checkbox-wrap .md-radio label > .box{
        border-color: #26C281 !important;
        color: #26C281 !important;
    }
</style>
<script>
    $( document ).ready(function() {
        $.each($(".b-page-checkbox-wrap .md-radio .task-name"),function(){
            $(this).css({'margin-left':"-"+$(this).width() / 8+"px"});
        });
        setTimeout(function(){$('.task-custom').find('.selectpicker').selectpicker();},300);
    });
</script>

<script>


    $('.fix_is_new').on('click', function(){
        $.ajax({
            'url': '/departments/fix-is-new',
            success: function(){

            }
        })
    })

</script>