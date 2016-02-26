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
        <div class="text-center" style="font-size:40px;font-weight: bold;color: rgba(90,90,90,0.50);">IDEA</div>
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
                    'style' => 'margin:0px auto 0;'
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

</div>

<style>
.task-body .block.desc .content{
        border-radius: 10px 10px 0px 10px !important;
    }
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