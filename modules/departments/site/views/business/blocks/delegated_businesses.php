<?
use modules\tasks\models\DelegateTask;
use modules\tasks\models\Task;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<?php $ch = 0;?>


<?php if(count($userTools) != 0):?>
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

            <?php if(@$tasks_count_array[DelegateTask::$status_done] != count($tasks)):?>
                <?php $ch++;?>
            <?php endif;?>
    <?php endif ?>
        <?php endforeach;?>
<?php endif;?>




<? if(count($userTools) == 0): ?>
<div class="text-center none" style="padding:22px 0;">
    Not a single task was yet delegated to you. But you can find tasks independently
</div>
<div style="border-top:1px solid #d7d7d7;height:1px;"></div>
<? else: ?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 52px;"><a href="#" class="btn btn-primary circle static" style="margin:0;border:none !important;font-size: 24px;line-height: 42px !important;"><i class="ico-history"></i></a></th>
        <th> Business Name </th>
        <th width="130"> Tasks </th>
        <th width="130"> Pending </th>
        <th width="130"> New </th>
        <th width="130"> Active </th>
        <th width="130"> Completed </th>
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

        <?php //if(@$tasks_count_array[DelegateTask::$status_done] != count($tasks)):?>

        <tr id="toolid-<?php echo $userTool->id?>">
                <td>
                <a href="javascript:;" class="dropmenu-two history<?php echo $userTool->id?> btn btn-primary circle" data-toggle="popover" data-not_autoclose="1"><i class="ico-history"></i></a>
            </td>
            <td style="text-transform: uppercase">
                <a href="<?= Url::toRoute(['/departments/business/select-tool', 'id' => $userTool->id]) ?>"
                <?php if(strlen($userTool->name) >30):?>
                     data-toggle="popover" data-placement="bottom" data-content="<?= $userTool->name ?>"
                <?php endif;?>
                class="name" 
                 style="display: block;width: 220px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"
                ><?= $userTool->name ? $userTool->name : 'No name' ?> <!--<span class="label label-danger circle"></span>--></a>
            </td>
            <td>
                <?= count($tasks) ?>

            </td>
            <td>
                <?= isset($tasks_count_array[DelegateTask::$status_offer]) ? $tasks_count_array[DelegateTask::$status_offer] : '0' ?>
            </td>
            <td><?= isset($tasks_count_array[DelegateTask::$status_inactive]) ? $tasks_count_array[DelegateTask::$status_inactive] : '0' ?></td>
            <td>
                <? $task_progress = isset($tasks_count_array[DelegateTask::$status_active]) ? $tasks_count_array[DelegateTask::$status_active] : 0;
                $task_progress += isset($tasks_count_array[DelegateTask::$status_payment]) ? $tasks_count_array[DelegateTask::$status_payment] : 0;
                $task_progress += isset($tasks_count_array[DelegateTask::$status_complete]) ? $tasks_count_array[DelegateTask::$status_complete] : 0;
                $task_progress += isset($tasks_count_array[DelegateTask::$status_checked]) ? $tasks_count_array[DelegateTask::$status_checked] : 0;
                echo $task_progress;
                ?>
            </td>
            <td>
                <?= isset($tasks_count_array[DelegateTask::$status_done]) ? $tasks_count_array[DelegateTask::$status_done] : '0' ?>
            </td>

        </tr>
        <?php //endif; ?>

                <div id="huistory-<?php echo $userTool->id?>" class="huistory" style="display:none;">
                    <ul>
                        <li class="disabled"><a target="_blank" href="/departments/business/shared-business?id=<?php echo $userTool->id?>">Business Dashboard</a></li>
                        <li class="disabled"><a class="team" href="javascript:;" data-toggle="popover" >Team</a></li>
                    </ul>
                </div>

                <script>
                    $(document).ready(function () {

                        $(".dropmenu-two.history<?php echo $userTool->id?>").on('show.bs.popover',function(){
                            $("#huistory-<?php echo $userTool->id?>").show();
                            $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
                        }).on('hide.bs.popover',function(){
                            $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                        });
                        $(".well > .nav-tabs li a").on('shown.bs.tab',function(){
                            console.log("asdasd");
                            $(".dropmenu-two.history<?php echo $userTool->id?>").popover({
                                placement:"bottom",
                                html:true,
                                content:$("#huistory-<?php echo $userTool->id?>"),
                                container:$("body"),
                                template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
                            });
                            $(".dropmenu-two.history<?php echo $userTool->id?>").on('show.bs.popover',function(){
                                $("#huistory-<?php echo $userTool->id?>").show();
                                $(".huistory a.team").popover({
                                    container: 'body',
                                    placement: "right",
                                    html:true,
                                    template:'<div class="popover delegation" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                                    content : 'Will be available in the next version'
                                });
                                $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
                            }).on('hide.bs.popover',function(){
                                $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                            });
                        });
                    });
                </script>

    <? endif; ?>
<? endforeach; ?>
    </tbody>
</table>

<? endif; ?>