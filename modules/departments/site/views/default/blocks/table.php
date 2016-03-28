<?php use modules\tasks\models\Task; ?>

<?php $i=1;?>
<?php foreach($tasks as $t):?>
<tr role="row" id="task-<?php echo $t->id?>">

    <?php $is_del = \modules\tasks\models\TaskUser::find()
        ->join('LEFT JOIN', 'delegate_task', 'delegate_task.task_user_id = task_user.id')
        ->where(['task_user.task_id' => $t->id, 'delegate_task.delegate_user_id' => Yii::$app->user->id, 'task_user.user_tool_id' => $userTool->id])
        ->andWhere(['!=', 'delegate_task.status','8'])
        ->all();?>
    <?php if($userTool->user_id == Yii::$app->user->id):?>
        <td><div class="series-content" data-id="<?php echo $t->id?>" data-is-custom="<?php echo $t->is_custom ?>"><?php echo $t->name?></div></td>
    <?php else:?>
        <?php if($is_del):?>
            <td><div class="series-content" data-id="<?php echo $t->id?>" data-is-custom="<?php echo $t->is_custom ?>"><?php echo $t->name?></div></td>
        <?php else:?>
            <td><div class="series-content" data-id="<?php echo $t->id?>" data-is-custom="<?php echo $t->is_custom ?>"><?php echo $t->name?></div></td>
        <?php endif;?>
    <?php endif;?>



    <td class="odd color-<?php echo $t->department_id?>"><?php echo $t->task?></td>
    <td class="odd color-<?php echo $t->department_id?>"><?php echo $t->recommended_time?></td>
    <?php if($t->status == 0):?>
        <?php $status = 'New';?>
    <?php elseif($t->status == 1):?>
        <?php $status = 'Active';?>
    <?php else:?>
        <?php $status = 'Completed';?>
    <?php endif; ?>
    <td class="odd color-<?php echo $t->department_id?>"><?php echo $status?>  <!--<span style="display:none" class="label label-danger circle">3</span>--></td>
</tr>
    <?php $i++;?>
<?php endforeach; ?>


