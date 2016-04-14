<?php $new = 0;?>
<?php $offered = 0;?>
<?php $applyed = 0;?>
<?php $delegated = 0;?>
<?php $funded = 0;?>
<?php $submited = 0;?>
<?php $paid = 0;?>
<?php $completed = 0;?>
<?php foreach($tasks as $task):?>
    <?php if($task->delegate_task_status == null):?>
        <?php $new = 1;?>
    <?php endif;?>
    <?php if($task->delegate_task_status == 1 && $task->is_request == 1):?>
        <?php $applyed = 1;?>
    <?php endif;?>
    <?php if(($task->delegate_task_status == 0 && $task->delegate_task_status != null) || ($task->delegate_task_status == 1 && $task->is_request == 0)):?>
        <?php $offered = 1;?>
    <?php endif;?>
    <?php if($task->delegate_task_status == 2):?>
        <?php $delegated = 1;?>
    <?php endif;?>
    <?php if($task->delegate_task_status == 3):?>
        <?php $funded = 1;?>
    <?php endif;?>
    <?php if($task->delegate_task_status == 5):?>
        <?php $submited = 1;?>
    <?php endif;?>
    <?php if($task->delegate_task_status == 6):?>
        <?php $paid = 1;?>
    <?php endif;?>
    <?php if($task->task_user_status == 2):?>
        <?php $completed = 1;?>
    <?php endif;?>

<?php endforeach; ?>
<button class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
    <img src="/images/mil-fil.jpg" height="30" alt="">
</button>
<ul class="dropdown-menu spec_list task_type pull-right" role="menu">
    <?php if($user_tool->user_id == Yii::$app->user->id):?>
        <?php if($new == 1):?>
            <li <?php echo $task_type == 0?'selected':''?> id="type0" class="m_filters active" data-value="0">New</li>
        <?php endif;?>
        <?php if($offered == 1):?>
            <li <?php echo $task_type == 1?'selected':''?> id="type1" class="m_filters active" data-value="1">Offered</li>
        <?php endif;?>
        <?php if($applyed == 1):?>
            <li <?php echo $task_type == 2?'selected':''?> id="type2" class="m_filters active" data-value="2">Applyed</li>
        <?php endif;?>
        <?php if($delegated == 1):?>
            <li <?php echo $task_type == 3?'selected':''?> id="type3" class="m_filters active" data-value="3">Delegated</li>
        <?php endif;?>
        <?php if($funded == 1):?>
            <li <?php echo $task_type == 4?'selected':''?> id="type4" class="m_filters active" data-value="4">Funded</li>
        <?php endif;?>
        <?php if($submited == 1):?>
            <li <?php echo $task_type == 5?'selected':''?> id="type5" class="m_filters active" data-value="5">Submited</li>
        <?php endif;?>
        <?php if($completed == 1):?>
        <li <?php echo $task_type == 7?'selected':''?> id="type7" class="m_filters active" data-value="7">Completed</li>
        <?php endif;?>
    <?php else:?>
        <?php if($new == 1):?>
            <li <?php echo $task_type == 0?'selected':''?> id="type0" class="m_filters active" data-value="0">New</li>
        <?php endif; ?>
        <?php if($offered == 1):?>
            <li <?php echo $task_type == 1?'selected':''?> id="type1" class="m_filters active" data-value="1">Offered</li>
        <?php endif;?>
        <?php if($applyed == 1):?>
            <li <?php echo $task_type == 2?'selected':''?> id="type2" class="m_filters active" data-value="2">Applyed</li>
        <?php endif;?>
        <?php if($funded == 1):?>
            <li <?php echo $task_type == 4?'selected':''?> id="type4" class="m_filters active" data-value="4">Funded</li>
        <?php endif;?>
        <?php if($submited == 1):?>
            <li <?php echo $task_type == 5?'selected':''?> id="type5" class="m_filters active" data-value="5">Submited</li>
        <?php endif;?>
        <?php if($paid == 1):?>
            <li <?php echo $task_type == 6?'selected':''?> id="type5" class="m_filters active" data-value="6">Paid</li>
        <?php endif;?>
        <?php if($completed == 1):?>
            <li <?php echo $task_type == 7?'selected':''?> id="type7" class="m_filters active" data-value="7">Completed</li>
        <?php endif;?>
    <?php endif; ?>
</ul>