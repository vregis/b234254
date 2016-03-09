<? use modules\user\models\Profile;
use yii\helpers\Url; ?>
<div class="milestones-users">
    <?
    $is_find = true;
    if (isset($_POST['users'])) {
        $is_find = false;
        foreach ($_POST['users'] as $user) {
            if($user == 0) {
                $is_find = true;
            }
        }
    }
    ?>
    <img data-content="<?=$avatar->first_name." ".$avatar->last_name; ?>" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" data-toggle="popover" class="gant_avatar <?= $is_find? 'active' : '' ?>" data-id="0" src="<?php echo $avatar->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$avatar->avatar:'/images/avatar/nophoto.png'?>">
    <?php if($delegate_tasks):?>
        <? foreach($delegate_tasks as $d_task) : ?>
            <?
            $is_find = true;
            if (isset($_POST['users'])) {
                $is_find = false;
                foreach ($_POST['users'] as $user) {
                    if($user == $d_task->id) {
                        $is_find = true;
                    }
                }
            }
            ?>
             <img data-toggle="popover" data-content="<?=$d_task->fname." ".$d_task->lname; ?>" class="gant_avatar <?= $is_find? 'active' : '' ?>" data-id="<?= $d_task->id ?>" src="<?php echo $d_task->ava ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$d_task->ava:'/images/avatar/nophoto.png'?>">
        <? endforeach; ?>
    <?php endif;;?>
</div>