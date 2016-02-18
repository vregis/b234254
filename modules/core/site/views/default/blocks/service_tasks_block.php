
<? //if(!$is_add) echo 'disabled'; ?>
<? if($tasklist) :?>
    <?php //var_dump($service->specialization_id);?> <!-- this is specialization id-->
        <div class="multiselect">
            <div class="btn-group bootstrap-select update form-control open">
                <button type="button" class="btn dropdown-toggle btn-default" title="Native" aria-expanded="true">
                    <span class="filter-option pull-left">Select task</span>&nbsp;
                    <span class="bs-caret"><span class="caret task"><i class="fa fa-angle-down"></i></span></span>
                </button>
                <div class="dropdown-content">
                    <ul>
                        <?php foreach($tasklist as $task):?>
                            <li class="<?php echo (isset($service) && $service->task_id == $task->id)?'task-selected':'' ?>" data-id="<?php echo $task->id?>">
                                <div class="pull-left task-name"><?php echo $task->name?></div>
                                <div class="pull-right">
                                    <a href="#" class="btn btn-primary static circle info">i</a>
                                    <input data-task_id = '<?php echo $task->id ?>' type="checkbox" <?php echo (isset($service) && $service->task_id == $task->id)?'checked':'' ?> class="form-control">
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
<? else: ?>
    <div class="multiselect">
        <div class="btn-group bootstrap-select update form-control open">
            <button type="button" class="btn dropdown-toggle btn-default" title="Native" aria-expanded="true">
                <span class="filter-option pull-left">Select task</span>&nbsp;
                <span class="bs-caret"><span class="caret task"><i class="fa fa-angle-down"></i></span></span>
            </button>
            <div class="dropdown-content">
                <ul>
                    <li>
                        <div class="pull-left">No Tasks</div>
                        <div class="pull-right">
                            <a href="#" class="btn btn-primary static circle info">i</a>
                            <input type="checkbox" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<? endif; ?>

<script>
    $('li.task-selected').each(function(){
        var name = $(this).find('.task-name').text();
        $(this).closest('.multiselect').find('.filter-option').html(name);
    })
</script>
