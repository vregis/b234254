<?
use modules\tasks\models\DelegateTask;

?>
<? foreach($delegate_tasks as $d_task) : ?>
    <a class="select-delegate" data-delegate_task_id="<?= $d_task->id ?>">
        <img class="<? if($delegate_task && $d_task->id == $delegate_task->id) echo 'active'; ?> gant_avatar" src="<?php echo $d_task->delegate_avatar ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$d_task->delegate_avatar:'/images/avatar/nophoto.png'?>">
        <span class="badge badge-danger"><?= $d_task->new_message > 0 ? $d_task->new_message : '' ?></span>
    </a>
<? endforeach; ?>