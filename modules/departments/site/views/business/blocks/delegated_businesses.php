<?
use modules\tasks\models\DelegateTask;
use modules\tasks\models\Task;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>

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
                <a href="<?= Url::toRoute(['/departments/business/select-tool', 'id' => $userTool->id]) ?>"><?= isset($userTool->name) ? $userTool->name : 'No name' ?></a> <span style="right: 15px;top: 50%;margin-top: -6px; display:none" class="label label-danger circle">3</span>
            </td>
            <td>
                <?= (new DateTime($userTool->create_date))->format("m/d/Y") ?>
            </td>
            <td>
                <?
                $milestones = [];
                foreach($tasks as $task) {
                    $milestones[Task::find()->where(['id' => $task->task])->one()->milestone_id] = '';
                }
                ?>
                <?= count($milestones) ?>
            </td>
            <td>
                <?= count($tasks) ?>
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
                <?= isset($tasks_count_array[DelegateTask::$status_inactive]) ? $tasks_count_array[DelegateTask::$status_inactive] : '0' ?>
            </td>
            <td>
                <a href="#" class="btn btn-primary circle dropdown-toggle" data-toggle="dropdown"><i class="ico-history"></i></a>
                <ul class="dropdown-menu">
                    <li class="disabled"><a href="#">Business Dashboard</a></li>
                    <li class="disabled"><a>Team</a></li>
                </ul>
            </td>
        </tr>
    <? endif; ?>
<? endforeach; ?>
<? if(count($userTools) == 0) : ?>
    <tr>
        <td colspan="7">
            <div style="padding:22px 0;">
                Not a single task was yet delegated to you.<br>
                But you can find tasks independently
            </div>
        </td>
    </tr>
<? endif; ?>