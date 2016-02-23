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
                                <span class="box" style="cursor: default" onclick="return false;"><i class="fa fa-check font-green-jungle"></i></span>
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
    <div id="idea" class="col-md-12">
        <div class="row form-group" style="margin-bottom: 0;">
            <div class="col-sm-12">
<? require __DIR__.'/idea/idea_block.php'; ?>
<a style="margin:0px auto 0;" href="<?= Url::toRoute(['/departments/business/dashboard-editing','id' => $user_tool_id]) ?>" class="btn btn-primary btn-lg">Share preview</a>
            </div>
        </div>
    </div>
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
            padding: 30px 0px !important;
    }
    .progress{
        width:100%;
    }
    .b-page-checkbox-wrap .md-radio label > .box{
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