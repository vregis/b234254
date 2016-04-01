<div class="mil-fil">
    <button class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        <img src="/images/mil-fil.jpg" height="30" alt="">
    </button>
    <ul class="dropdown-menu" role="menu">
        <li>All tasks</li>
        <li>Offered</li>
        <li>Offered</li>
        <li>Offered</li>
    </ul>
</div>

<?php if($user_tool->user_id == Yii::$app->user->id):?>
    <select name="task_type" class="task_type">
        <option <?php echo $task_type == 100?'selected':''?> id="type100" value="100">All tasks</option>
        <option <?php echo $task_type == 0?'selected':''?> id="type0" value="0">New</option>
        <option <?php echo $task_type == 1?'selected':''?> id="type1" value="1">Offered</option>
        <option <?php echo $task_type == 2?'selected':''?> id="type2" value="2">Applyed</option>
        <option <?php echo $task_type == 3?'selected':''?> id="type3" value="3">Delegated</option>
        <option <?php echo $task_type == 4?'selected':''?> id="type4" value="4">Funded</option>
        <option <?php echo $task_type == 5?'selected':''?> id="type5" value="5">Submited</option>
        <option <?php echo $task_type == 7?'selected':''?> id="type7" value="7">Completed</option>
    </select>
<?php else:?>
    <select name="task_type" class="task_type">
        <option <?php echo $task_type == 100?'selected':''?> id="type100" value="100">All tasks</option>
        <option <?php echo $task_type == 0?'selected':''?> id="type0" value="0">New</option>
        <option <?php echo $task_type == 1?'selected':''?> id="type1" value="1">Offered</option>
        <option <?php echo $task_type == 2?'selected':''?> id="type2" value="2">Applyed</option>
        <option <?php echo $task_type == 4?'selected':''?> id="type4" value="4">Funded</option>
        <option <?php echo $task_type == 5?'selected':''?> id="type5" value="5">Submited</option>
        <option <?php echo $task_type == 6?'selected':''?> id="type5" value="6">Paid</option>
        <option <?php echo $task_type == 7?'selected':''?> id="type7" value="7">Completed</option>
    </select>
<?php endif; ?>