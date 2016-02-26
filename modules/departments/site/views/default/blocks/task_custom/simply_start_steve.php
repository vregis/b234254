<?
use yii\helpers\Url;
use modules\tasks\models\Task;
?>
<div class="container-fluid">
 <div class="row task-title" style="margin-bottom: 8px;">
    <div class="row task-body" style="margin-top:40px;">
        <div class="desc" style="padding:0 15px;">
            <div class="step">
                <div class="form-md-radios md-radio-inline b-page-checkbox-wrap">
                    <? $name[0] = 'Start'; ?>
                    <? $name[1] = 'Discover'; ?>
                    <? $name[2] = 'Go'; ?>
                    <? for($i = 0; $i < 3; $i++) : ?>
                        <div class="md-radio even has-test b-page-checkbox">
                            <div class="task-name">
                                <?= $name[$i] ?>
                            </div>
                            <input type="radio" id="Roadmap[<?= $i ?>]" name="Roadmap" class="md-radiobtn" value="<?= $i ?>">
                            <label for="Roadmap[<?= $i ?>]">
                                <span></span>
                                <span class="check"></span>
                                <span class="box" style="cursor: default" onclick="return false;">1</span>
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
    <div class="name text-center">
        <span id="title-task"><?=$task->description?></span>
    </div>
</div>
    <div class="task-body">
        <? //if($task->id == Task::$task_roadmap_personal_id) : ?>
            <a href="<?= Url::toRoute(['/departments/task','id' => Task::$task_steve_bussiness_role_id]) ?>" class="btn btn-primary btn-lg">Continue</a><!-- person goal -->
        <? //else : ?>
            <!--<div class="pull-right inline">
                <a href="#" data-dismiss="modal" class="href-black task-close"></a>
            </div>-->
        <? //endif; ?>
    </div>
</div>   
</div>
<style>
    .well{
        width:675px !important;
    }
    .b-page-checkbox-wrap .md-radio:nth-child(1) label > .box{
        border-color: #26C281 !important;
    }
</style>