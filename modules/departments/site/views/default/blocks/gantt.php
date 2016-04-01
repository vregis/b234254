<?php use modules\tasks\models\Task; ?>
<?php use yii\helpers\Url; ?>
<?php use modules\user\models\Profile; ?>

<?php $this->registerJsFile("/plugins/gantt/assets/js/custom/gantt_chart.js");
 $this->registerJsFile("/plugins/gantt/assets/js/custom/gantt_chart.js");
$this->registerJsFile("/js/milestone.js");?>
<?php if(isset($id)):?>

    <? $key = $id!=-1 ? $id : 'All'?>

<div class="ganttview-vtheader">
    <div class="ganttview-vtheader-group">
        <div class="milestones-users-blank">
        </div>
        <div class="ganttview-vtheader-series">
            <?php foreach($tasks as $t):?>
                <?php $is_del = \modules\tasks\models\TaskUser::find()
                    ->select('delegate_task.status delegate_task, delegate_task.is_request is_request')
                    ->join('LEFT JOIN', 'delegate_task', 'delegate_task.task_user_id = task_user.id')
                    ->where(['task_user.task_id' => $t->id, 'delegate_task.delegate_user_id' => Yii::$app->user->id, 'task_user.user_tool_id' => $userTool->id])
                    ->andWhere(['!=', 'delegate_task.status','8'])
                    ->all();?>

                <?php $del_status = \modules\tasks\models\TaskUser::find()
                    ->select('delegate_task.status delegate_task')
                    ->join('LEFT JOIN', 'delegate_task', 'delegate_task.task_user_id = task_user.id')
                    ->where(['task_user.task_id' => $t->id, 'task_user.user_tool_id' => $userTool->id])
                    ->andWhere(['!=', 'delegate_task.status','8'])
                    ->one();?>

                <?php if($userTool->user_id == Yii::$app->user->id):?>
                    <?php $delegate_array[$t->id] = 1;?>
                <?php else:?>
                <?php $delegate_array[$t->id] = $is_del==null?0:1;?>
                <?php endif;?>
                <?php if($del_status):?>
                    <?php $del_st = $del_status->delegate_task;?>

                    <?php if($del_status->delegate_task == 1 /*&& $del_status->is_request == 1*/):?>
                        <?php $liter[$t->id] = 'a';?>
                    <?php elseif($del_status->delegate_task == 1 && $del_status->is_request == 0):?>
                        <?php $liter[$t->id] = 'o';?>
                    <?php elseif($del_status->delegate_task == 2):?>
                        <?php $liter[$t->id] = 'd';?>
                    <?php elseif($del_status->delegate_task == 3):?>
                        <?php $liter[$t->id] = 'f';?>
                    <?php elseif($del_status->delegate_task == 5):?>
                        <?php $liter[$t->id] = 'c';?>
                    <?php elseif($del_status->delegate_task == 6):?>
                        <?php $liter[$t->id] = 'p'?>
                    <?php else:?>
                        <?php $liter[$t->id] = $del_status->delegate_task;?>

                    <?php endif;?>



                <?php else:?>
                    <?php $liter[$t->id] = '';?>
                <?php endif; ?>
                <div class="ganttview-vtheader-series-row">
                    <?php if($userTool->user_id == Yii::$app->user->id):?>
                        <div class="series-content" data-delegate-status = '<?php var_dump($liter[$t->id])?>' data-id="<?php echo $t->id?>" data-status="<?php echo $t->status?>" data-is-custom="<?php echo $t->is_custom ?>"><?php echo $t->name?></div>
                    <?php else:?>
                        <?php if($is_del):?>
                            <div class="series-content" data-id="<?php echo $t->id?>" data-status="<?php echo $t->status?>" data-is-custom="<?php echo $t->is_custom ?>" data-guest="0"><?php echo $t->name?></div>
                        <?php else:?>
                            <div class="series-content-guest" data-id="<?php echo $t->id?>" data-status="<?php echo $t->status?>" data-is-custom="<?php echo $t->is_custom ?>" data-guest="1"><?php echo $t->name?></div>
                        <?php endif;?>
                    <?php endif;?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div id="view-box-<?php echo $key?>"></div>

<?php $colors = [];?>
<?php $colors[1] = '#9187d0';?>
<?php $colors[2] = '#b787d1';?>
<?php $colors[3] = '#fd6d64';?>
<?php $colors[4] = '#ffa25d';?>
<?php $colors[5] = '#ffd147';?>
<?php $colors[6] = '#aad772';?>
<?php $colors[7] = '#70cac8';?>
<?php $colors[8] = '#5dc9f0';?>

<script>
    ganttData<?= $key?> = [{
        id: 1,
        is_custom: 0,
        name: "Concept",
        color: '#006064',
        series: [
            <?php foreach($tasks as $t):?>
                {
                    name: "<?php echo $t->name?>",
                    is_del: '<?php echo $delegate_array[$t->id]?>',
                    liter: '<?php echo $liter[$t->id]?>',
                    <?php if($t->start != null):?>
                    start: '<?php echo date('m/d/Y', strtotime($t->start));?>',
                    <?php else:?>
                    start: '<?php echo date('m/d/Y', time());?>',
                    <?php endif;?>
                    <?php if($t->is_roadmap):?>
                    end: '<?php echo date('m/d/Y', null);?>',
                    <?php elseif($t->end != null):?>
                    end: '<?php echo date('m/d/Y', strtotime($t->end));?>',
                    <?php else:?>
                    end: '<?php echo date('m/d/Y', time());?>',
                    <?php endif;?>
                    color: "<?php if(isset($colors[$t->department_id])) echo $colors[$t->department_id]?>",
                    id: <?php echo $t->id?>,
                    is_custom: <?php echo $t->is_custom?>,
                    <?php if($t->status!=null):?>
                    status: <?php echo $t->status;?>
                    <?php endif ?>
                },
            <?php endforeach;?>
        ]
    }];

    altair_gantt<?php echo $key?> = {
        init: function() {
            var $gantt_chart = $('#view-box-<?php echo $key?>');
            if($gantt_chart.length) {
                $gantt_chart.ganttView({
                    data: ganttData<?php echo $key?>,

                    behavior: {
                        draggable:false,
                        onClick: function (data) {
                            /*var msg = "You clicked on an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
                            console.log('click');*/
                            if(data.is_del == 1) {
                                openTask(data.id, data.is_custom);
                            }else{
                                openTaskGuest(data.id, data.is_custom);
                            }
                        },
                        onResize: function (data) {
                            var msg = "You resized an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
                            console.log(msg);
                        },
                        onDrag: function (data) {
                            var msg = "You dragged an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
                            console.log(msg);
                        }
                    }
                });
            }
        }
    };

    $(function() {
        altair_gantt<?php echo $key?>.init();
    });
</script>

<?php endif;?>


