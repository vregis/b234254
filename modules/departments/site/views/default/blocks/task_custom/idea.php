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
    <div class="row task-body" style="margin-top:40px;">
        <div class="desc" style="padding:0 15px;">
            <div class="step">
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
                                <span class="box" style="cursor: default" onclick="return false;"><?=$i==0 ? '<i class="fa fa-check font-green-jungle"></i>' : $i + 1?></span>
                            </label>
                        </div>
                    <? endfor; ?>
                    <div style="display:inline-block;width:100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="name text-center">
        <span id="title-task"><?= $task->name ?></span>
    </div>
</div>
    <?php $form = ActiveForm::begin(
        [
            'id' => 'idea-form',
        ]
    ) ?>
    <div id="idea" class="col-md-12">

        <div class="row form-group">
            <div class="col-sm-10 <?= isset($idea->errors['name']) ? 'has-error' : '' ?>">
                <input type="text" maxlength="150" placeholder="Idea name (No more than 150 characters)" name="Idea[name]" value="<?= $idea->name ?>" class="form-control">
            </div>
            <div class="col-sm-2 <?= isset($idea->errors['industry_id']) ? 'has-error' : '' ?>" style="padding-left: 0;">
                <select class="form-control selectpicker" name="Idea[industry_id]">
                    <option value="">Select industry</option>
                    <?php foreach($industries as $industrie):?>
                        <option <?php echo $idea && $industrie->id==$idea->industry_id ? 'selected':''?> value="<?php echo $industrie->id?>"><?php echo $industrie->name?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="row form-group <?= isset($idea->errors['description_like']) ? 'has-error' : '' ?>">
            <div class="col-sm-12">
                <textarea style="height:75px;resize:none;" maxlength="300" name="Idea[description_like]" placeholder="Small description of your idea (No more than 300 characters)" class="form-control"><?= $idea->description_like ?></textarea>
            </div>
        </div>
        <div class="row form-group <?= isset($idea->errors['description_problem']) ? 'has-error' : '' ?>">
            <div class="col-sm-12">
                <textarea style="height:75px;resize:none;" maxlength="300" placeholder="What problem is solving? (No more than 300 characters)" name="Idea[description_problem]" class="form-control"><?= $idea->description_problem ?></textarea>
            </div>
        </div>
        <div class="row form-group" style="margin-bottom:0;">
            <div class="col-sm-12">
                <? require __DIR__.'/idea/idea_block.php'; ?>
                <?= Html::submitButton('Continue', [
                    'class' => 'btn btn-success btn-lg',
                    'style' => 'margin:30px auto 0;'
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

</div>

<style>
    .b-page-checkbox-wrap .md-radio:nth-child(1) label > .box{
        border-color: #26C281 !important;
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