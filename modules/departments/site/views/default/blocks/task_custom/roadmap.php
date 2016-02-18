<?
use yii\helpers\Url;
use modules\tasks\models\Task;
?>

<div class="name text-center">
    <span id="title-task"><?= $task->name ?></span>
    <? if($task->id == Task::$task_roadmap_personal_id) : ?>
        <a href="<?= Url::toRoute(['/departments/roadmap-end']) ?>" class="btn btn-success pull-right" style="line-height:32px !important;">Next</a><!-- person goal -->
    <? else : ?>
        <div class="pull-right inline">
            <a href="#" data-dismiss="modal" class="href-black task-close"></a>
        </div>
    <? endif; ?>
</div>
<div class="name pull-left"></div>

<div class="clearfix"></div>

<div class="row task-body" style="margin-top:20px;">
    <div class="desc" style="padding:0 15px;margin-bottom:15px;">
        <? $step = 4; ?>
        <? $j = 0; ?>
        <? for($i = 0; $i < count($tasks) && array_key_exists($i, $tasks); $i=$j ): ?>
            <div class="step">
                <div class="form-md-radios md-radio-inline b-page-checkbox-wrap">
                    <? for($j = $i; $j < $i + $step && array_key_exists($j, $tasks); $j++) : ?>
                        <? $cur_task = $tasks[$j]; ?>
                        <div class="md-radio <?= ($j%2 == 0 ? 'odd' : 'even'); ?> has-test b-page-checkbox">
                            <div class="task-name" style="display: none">
                                <?= $cur_task->name ?>
                            </div>
                            <input type="radio" id="Roadmap[<?= $j ?>]" name="Roadmap" class="md-radiobtn" value="<?= $j ?>">
                            <label for="Roadmap[<?= $j ?>]">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"><?=$j + 1?></span>
                            </label>
                            <div class="text-desc-task" style="display: none">
                                <?= $cur_task->description ?>
                            </div>
                        </div>
                    <? endfor; ?>
                    <div style="display:inline-block;width:100%;"></div>
                </div>
            </div>
            <? if(count($tasks) - ($i+$step) == 5) $step = 3; ?>
        <? endfor; ?>
    </div>
</div>