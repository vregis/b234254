<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 26.12.2015
 * Time: 12:51
 */

use yii\helpers\Url;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;

    $milestone_id = !is_null($milestone_active) ? $milestone_active->id : -1;

?>
    <div style="text-align:center;" class="btn all <? if($milestone_id == -1) : ?>active<? endif; ?>">
        <a href="<?= Url::toRoute(['/departments','id' => $department_active != 0 ? $department_active : 1,'milestone_id' => 0]) ?>" class="milestone-link">
            All milestones
        </a>
    </div>
    <? $number = 1; ?>
    <? foreach($milestones as $milestone) : ?>
    <? if($milestone->is_pay == 0) : ?>
        <div class="btn  <? if($milestone_id == $milestone->id) : ?>active<? endif; ?>">
                <a href="<?= Url::toRoute(['/departments','id' => $department_active != 0 ? $department_active : 1,'milestone_id' => $milestone->id]) ?>" class="milestone-link">
                    <?= $number ?>.
                    <?= $milestone->name ?>
                </a>          
            <div class="body-collapse-description">
                <?
                $tasks = Task::find()->where(['milestone_id' => $milestone->id])->all();
                $task_count = count($tasks);
                $user_id = Yii::$app->user->identity->id;
                $complete = true;
                foreach($tasks as $task) {
                    $task_user = TaskUser::find()->where(['task_id' => $task->id, 'user_id' => $user_id])->one();
                    if(is_null($task_user) || $task_user->status != 2) {
                        $complete = false;
                    }
                }
                ?>
                <span class="label label-sm label-default circle"><?= $task_count ?></span>
                <? if($complete) : ?>
                    <i class="fa fa-check"></i>
                <? else: ?>
                    <i class="fa fa-question-circle font-white no-decoretion" data-container="body" data-toggle="popover" data-placement="left" data-content="<?= $milestone->description ?>"></i>
                <? endif; ?>
            </div>
        </div>
        <? else : ?>
        <div class="btn <? if($milestone_id == $milestone->id) : ?>active<? endif; ?>" data-container="body" data-toggle="popover" data-placement="auto" data-content="Will be available in the next version">
                <a class="milestone-link">
                    <?= $number ?>.
                    <?= $milestone->name ?>
                </a>
            <div class="body-collapse-description">
                <i class="fa fa-question-circle font-white no-decoretion" data-container="body" data-toggle="popover" data-placement="auto" data-content="<?= $milestone->description ?>"></i>
            </div>
        </div>
        <? endif; ?>
        <? $number++; ?>
    <? endforeach; ?>


<?php $this->registerJsFile("/js/global/rotate.js");?>
<script>
    $(function(){
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {   // If Internet Explorer
            $('.icon-login').rotate(-90);

        }
    })
</script>