<button class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
    <img src="/images/mil-fil.jpg" height="30" alt="">
</button>
<ul class="dropdown-menu spec_list task_type pull-right" role="menu">
    <?php if($user_tool->user_id == Yii::$app->user->id):?>
        <li <?php echo $task_type == 100?'selected':''?> id="type100" class="m_filters" data-value="100">All tasks</li>
        <li <?php echo $task_type == 0?'selected':''?> id="type0" class="m_filters" data-value="0">New</li>
        <li <?php echo $task_type == 1?'selected':''?> id="type1" class="m_filters" data-value="1">Offered</li>
        <li <?php echo $task_type == 2?'selected':''?> id="type2" class="m_filters" data-value="2">Applyed</li>
        <li <?php echo $task_type == 3?'selected':''?> id="type3" class="m_filters" data-value="3">Delegated</li>
        <li <?php echo $task_type == 4?'selected':''?> id="type4" class="m_filters" data-value="4">Funded</li>
        <li <?php echo $task_type == 5?'selected':''?> id="type5" class="m_filters" data-value="5">Submited</li>
        <li <?php echo $task_type == 7?'selected':''?> id="type7" class="m_filters" data-value="7">Completed</li>
    <?php else:?>
        <li <?php echo $task_type == 100?'selected':''?> id="type100" class="m_filters" data-value="100">All tasks</li>
        <li <?php echo $task_type == 0?'selected':''?> id="type0" class="m_filters" data-value="0">New</li>
        <li <?php echo $task_type == 1?'selected':''?> id="type1" class="m_filters" data-value="1">Offered</li>
        <li <?php echo $task_type == 2?'selected':''?> id="type2" class="m_filters" data-value="2">Applyed</li>
        <li <?php echo $task_type == 4?'selected':''?> id="type4" class="m_filters" data-value="4">Funded</li>
        <li <?php echo $task_type == 5?'selected':''?> id="type5" class="m_filters" data-value="5">Submited</li>
        <li <?php echo $task_type == 6?'selected':''?> id="type5" class="m_filters" data-value="6">Paid</li>
        <li <?php echo $task_type == 7?'selected':''?> id="type7" class="m_filters" data-value="7">Completed</li>
    <?php endif; ?>
</ul>