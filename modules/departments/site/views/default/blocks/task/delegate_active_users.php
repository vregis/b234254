<?
use modules\tasks\models\DelegateTask;

?>
<? foreach($delegate_tasks as $d_task) : ?>
    <?php $uid = \modules\user\models\Profile::find()
        ->select('user_profile.*, user.email email')
        ->join('LEFT JOIN', 'user', 'user.id = user_profile.user_id')
        ->where(['user_profile.user_id' => $d_task->delegate_user_id])->one();
        
	    if($uid->first_name == null || $uid->last_name == null){
	    	$content = $uid->email;
	    }else{
	    	$content = $uid->first_name." ".$uid->last_name;
	    }
    ?>
    <a data-date="20 Mar - 1 May" data-rate="1h" data-location="Australia, London" data-name="<?= $content ?>" class="select-delegate" data-delegate_task_id="<?= $d_task->id ?>">
        <img data-content="<?=$content;?>" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" class="<? if($delegate_task && $d_task->id == $delegate_task->id) echo 'active'; ?> gant_avatar" src="<?php echo $d_task->delegate_avatar ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$d_task->delegate_avatar:'/images/avatar/nophoto.png'?>">
        <span class="badge badge-danger"><?= $d_task->new_message > 0 ? $d_task->new_message : '' ?></span>
    </a>
<? endforeach; ?>