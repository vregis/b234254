<?php use modules\tasks\models\Task; ?>

<?php $i=1;?>
<?php foreach($tasks as $t):?>
<tr role="row" id="task-<?php echo $t->id?>">
    <td><div class="series-content" data-id="<?php echo $t->id?>" data-is-custom="<?php echo $t->is_custom ?>"><?php echo $t->name?></div></td>
    <td class="odd color-<?php echo $t->department_id?>"><?php echo $t->task?></td>
    <td class="odd color-<?php echo $t->department_id?>"><?php echo $t->recommended_time?></td>
    <?php if($t->status == 0):?>
        <?php $status = 'New';?>
    <?php elseif($t->status == 1):?>
        <?php $status = 'Active';?>
    <?php else:?>
        <?php $status = 'Completed';?>
    <?php endif; ?>
    <td class="odd color-<?php echo $t->department_id?>"><?php echo $status?>  <span style="display:none" class="label label-danger circle">3</span></td>
</tr>
    <?php $i++;?>
<?php endforeach; ?>


