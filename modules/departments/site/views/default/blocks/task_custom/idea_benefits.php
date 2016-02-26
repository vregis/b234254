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
use yii\widgets\ActiveForm;
?>
<div class="container-fluid">
  <div class="row task-title" style="margin-bottom: 8px;">
      <?php $tool = \modules\tasks\models\UserTool::find()->where(['user_id' => Yii::$app->user->id])->all();?>
      <?php if(count($tool) > 2):?>
          <div class="row task-body" style="margin-top:40px;">
        <div class="desc" style="padding:0 15px;">
            <div class="step">
                <div class="progress"></div>
                <div class="form-md-radios md-radio-inline b-page-checkbox-wrap">
                    <? $name[0] = 'Idea'; ?>
                    <? $name[1] = 'Benefits'; ?>
                    <? $name[2] = 'Share'; ?>
                    <? for($i = 0; $i < 3; $i++) : ?>
                        <div class="md-radio even has-test b-page-checkbox">
                            <div class="task-name">
                                <?= $name[$i] ?>
                            </div>
                            <input type="radio" id="Roadmap[<?= $i ?>]" name="Roadmap" class="md-radiobtn" value="<?= $i ?>">
                            <label for="Roadmap[<?= $i ?>]">
                                <span></span>
                                <span class="check"></span>
                                <span class="box" style="cursor: default;" onclick="return false;"><?=$i==0 ? '<i class="fa fa-check font-green-jungle"></i>' : $i + 1?></span>
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
      <?php else:?>
        <div class="text-center" style="font-size:40px;font-weight: bold;color: rgba(90,90,90,0.50);">Benefits</div>
      <?php endif; ?>
        <div class="name text-center">
            <span id="title-task text-center"><?= $task->name ?></span>
        </div>
    </div>
    <?php $form = ActiveForm::begin() ?>
    <div id="idea" class="col-md-12">
        <div class="row form-group <?= isset($benefit->errors['first']) ? 'has-error' : '' ?>">
            <div class="col-sm-12">
                <input type="text" maxlength="200" class="form-control" placeholder="First benefit (No more than 200 characters)" value="<?= $benefit->first ?>" name="Benefit[first]">
            </div>
        </div>
        <div class="row form-group <?= isset($benefit->errors['second']) ? 'has-error' : '' ?>">
            <div class="col-sm-12">
                <input type="text" maxlength="200" class="form-control" placeholder="Second benefit (No more than 200 characters)" value="<?= $benefit->second ?>" name="Benefit[second]">
            </div>
        </div>
        <div class="row form-group <?= isset($benefit->errors['third']) ? 'has-error' : '' ?>">
            <div class="col-sm-12">
                <input type="text" maxlength="200" class="form-control" placeholder="Third benefit (No more than 200 characters)" value="<?= $benefit->third ?>" name="Benefit[third]">
            </div>
        </div>
        <div class="row form-group" style="margin-bottom:0;">
            <div class="col-sm-12">
                <? require __DIR__.'/idea/idea_block.php'; ?>
                <?= Html::submitButton('Continue', [
                    'class' => 'btn btn-success btn-lg',
                    'style' => 'margin:0px auto 0;'
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
</div>
<script>
    $(document).ready(function(){
        $(".b-page-checkbox-wrap .md-radio:nth-child(6)").addClass('active');
        $(".b-page-checkbox-wrap .md-radio:nth-child(3),.b-page-checkbox-wrap .md-radio:nth-child(4),.b-page-checkbox-wrap .md-radio:nth-child(5)").addClass('done');
        $("#side_road .item-2").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover top-fix item-2" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(282);?><div class="text-center">Completed</div>'
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
            template:'<div class="popover bottom-fix item-5" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(38);?>'
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
        height:75%;
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
        padding: 30px 20px !important;
    }
    .progress{
        width:50%;
    }
    .b-page-checkbox-wrap .md-radio:nth-child(1) label > .box,.b-page-checkbox-wrap .md-radio:nth-child(2) label > .box{
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