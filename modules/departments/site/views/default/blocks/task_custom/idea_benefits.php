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
                                <span class="box" style="cursor: default" onclick="return false;"><?=$i==0 || $i==1 ? '<i class="fa fa-check font-green-jungle"></i>' : $i + 1?></span>
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
                    'style' => 'margin:30px auto 0;'
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
</div>


<style>
.task-body .block.desc .content{
    border-radius:10px !important;
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
        width:50%;
    }
    .b-page-checkbox-wrap .md-radio:nth-child(1) label > .box,.b-page-checkbox-wrap .md-radio:nth-child(2) label > .box{
        border-color: #26C281 !important;
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