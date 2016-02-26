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
        <div class="text-center" style="font-size:40px;font-weight: bold;color: rgba(90,90,90,0.50);">BENEFITS</div>
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