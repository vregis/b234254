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
        <?php $user = \modules\user\models\User::find()->where(['id' => Yii::$app->user->id])->one();?>
        <?php if($user):?>
        <?php if(!isset($_GET['first']) || $user->user_registration_type == 1):?>
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
                                <span class="box" style="cursor: default;" onclick="return false;"><?=$i+1?></span>
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
        <div class="text-center" style="font-size:40px;font-weight: bold;color: rgba(90,90,90,0.50);">Idea</div>
        <?php endif;?>
        <?php endif;?>
        <div class="name text-center">
            <span id="title-task text-center"><?= $task->name ?></span>
        </div>
    </div>
</div>
    <?php $form = ActiveForm::begin(
        [
            'id' => 'idea-form',
        ]
    ) ?>
    <div id="idea" class="col-md-12">

        <div class="row form-group">
            <div class="col-sm-12 <?= isset($idea->errors['name']) ? 'has-error' : '' ?>">
                <input type="text" maxlength="150" placeholder="Idea name" name="Idea[name]" value="<?= $idea->name ?>" class="form-control">
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-4 col-sm-offset-4 <?= isset($idea->errors['industry_id']) ? 'has-error' : '' ?>" style="padding-left: 0;">
                <select class="form-control selectpicker" name="Idea[industry_id]">
                    <option value="">Industry</option>
                    <?php foreach($industries as $industrie):?>
                        <option <?php echo $idea && $industrie->id==$idea->industry_id ? 'selected':''?> value="<?php echo $industrie->id?>"><?php echo $industrie->name?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="row form-group <?= isset($idea->errors['description_like']) || isset($idea->errors['description_problem']) ? 'has-error' : '' ?>">
            <div class="col-sm-6">
                <textarea style="height:150px;resize:none;" maxlength="300" name="Idea[description_like]" placeholder="Small description of your idea (No more than 300 characters)" class="form-control"><?= $idea->description_like ?></textarea>
            </div>
            <div class="col-sm-6">
                <textarea style="height:150px;resize:none;" maxlength="300" placeholder="What problem is solving? (No more than 300 characters)" name="Idea[description_problem]" class="form-control"><?= $idea->description_problem ?></textarea>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom:0;">
            <div class="col-sm-12">
                <? //require __DIR__.'/idea/idea_block.php'; ?>
                <?= Html::submitButton('Continue', [
                    'class' => 'btn btn-success btn-lg',
                    'style' => 'margin:0px auto 0;'
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

</div>
<script>
    $(document).ready(function(){
        $(".b-page-checkbox-wrap .md-radio:nth-child(5)").addClass('active');
        $(".b-page-checkbox-wrap .md-radio:nth-child(3),.b-page-checkbox-wrap .md-radio:nth-child(4)").addClass('done');
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
            template:'<div class="popover bottom-fix item-4" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(37);?>'
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
        height:60%;
    }
    .form-group {
        margin-bottom: 30px;
    }
</style>
<style>
.task-body .block.desc .content{
        border-radius: 10px 10px 0px 10px !important;
    }
    .b-page-checkbox-wrap .md-radio:nth-child(1) label > .box{
        border-color: #26C281 !important;
        color: #26C281 !important;
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

    .task-custom textarea {
        height:75px;
        resize:none;
    }
    .task .mCSB_container{
        padding:0;
    }
     .task .mCSB_container a{
        color:#5a5a5a;
     }
</style>
<script>
    $( document ).ready(function() {
        $.each($(".b-page-checkbox-wrap .md-radio .task-name"),function(){
            $(this).css({'margin-left':"-"+$(this).width() / 8+"px"});
        });
        setTimeout(function(){
            $.each($('.dropdown-menu.inner'),function(){
                var els = $(this).find('li');
                console.log(els.length);
                if(els.length > 8){
                    $(this).mCustomScrollbar({
                        setHeight: 252,
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }else{
                    $(this).mCustomScrollbar({
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }
            });
        },400);
        $.each($('.dropdown-menu.inner'),function(){
            var els = $(this).find('li');
            console.log(els.length);
            if(els.length > 8){
                $(this).mCustomScrollbar({
                    setHeight: 252,
                    theme:"dark",
                    scrollbarPosition:"outside"
                });  
            }else{
                $(this).mCustomScrollbar({
                    theme:"dark",
                    scrollbarPosition:"outside"
                });  
            }
        });
    });
</script>
<script>
    $(function(){
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
        window.onhashchange=function(){window.location.hash="no-back-button";}
    })

</script>