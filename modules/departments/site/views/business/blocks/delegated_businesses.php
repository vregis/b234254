<?
use modules\tasks\models\DelegateTask;
use modules\tasks\models\Task;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<? if(count($userTools) == 0): ?>
<div class="text-center none" style="padding:22px 0;color:#8eb6f8;">
    Not a single task was yet delegated to you. But you can find tasks independently
</div>
<div style="border-top:1px solid #d7d7d7;height:1px;"></div>
<? else: ?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th> Business Name </th>
        <th width="130"> Tasks </th>
        <th width="130"> Pending </th>
        <th width="130"> New </th>
        <th width="130"> Active </th>
        <th width="130"> Complited </th>
        <th style="width: 52px;"><a href="#" class="btn btn-primary circle static" style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;"><i class="ico-history"></i></a></th>
    </tr>
    </thead>
    <tbody>
        <? foreach($userTools as $userTool) : ?>
    <? if($userTool->user_id != Yii::$app->user->id) : ?>
        <? $tasks = DelegateTask::find()->select('delegate_task.*,task_user.task_id task')
            ->join('JOIN', 'task_user', 'task_user.id = delegate_task.task_user_id')
            ->where([
                'user_tool_id' => $userTool->id,
                'delegate_task.delegate_user_id' => Yii::$app->user->id
            ])
            ->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel])
            ->all();
        $tasks_count_array = array_count_values(ArrayHelper::map($tasks,'id','status'));
        ?>

        <tr id="toolid-<?php echo $userTool->id?>">
            <td style="text-transform: uppercase">
                <a target="_blank" href="<?= Url::toRoute(['/departments/business/select-tool', 'id' => $userTool->id]) ?>"><?= isset($userTool->name) ? $userTool->name : 'No name' ?></a> <span style="right: 15px;top: 50%;margin-top: -6px; display:none;" class="label label-danger circle">3</span>
            </td>
            <td>
                <?= (new DateTime($userTool->create_date))->format("m/d/Y") ?>
            </td>
            <td>
                <?= count($tasks) ?>
            </td>
            <td>1</td>
            <td>
                <?= isset($tasks_count_array[DelegateTask::$status_inactive]) ? $tasks_count_array[DelegateTask::$status_inactive] : '0' ?>
            </td>
            <td>
                <? $task_progress = isset($tasks_count_array[DelegateTask::$status_active]) ? $tasks_count_array[DelegateTask::$status_active] : 0;
                $task_progress += isset($tasks_count_array[DelegateTask::$status_payment]) ? $tasks_count_array[DelegateTask::$status_payment] : 0;
                $task_progress += isset($tasks_count_array[DelegateTask::$status_complete]) ? $tasks_count_array[DelegateTask::$status_complete] : 0;
                $task_progress += isset($tasks_count_array[DelegateTask::$status_checked]) ? $tasks_count_array[DelegateTask::$status_checked] : 0;
                echo $task_progress;
                ?>
            </td>
            <td>
                <a href="javascript:;" class="dropmenu1 history1 btn btn-primary circle" data-toggle="popover" data-not_autoclose="1"><i class="ico-history"></i></a>
                <ul class="dropdown-menu">
                    <li class="disabled"><a href="#">Business Dashboard</a></li>
                    <li class="disabled"><a>Team</a></li>
                </ul>
            </td>
        </tr>
    <? endif; ?>
<? endforeach; ?>
    </tbody>
</table>
<div id="huistory1" class="huistory" style="display:none;">
    <ul>
        <li class="disabled"><a href="#">Business Dashboard</a></li>
        <li class="disabled"><a>Team</a></li>   
    </ul>

</div>
<? endif; ?>