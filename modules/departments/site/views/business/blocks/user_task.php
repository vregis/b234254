<? $i=0; ?>
<? foreach($users as $user) : ?>
    <tr class="user-row" data-page-id="<?= intval($i/5) ?>" style="<?=intval($i/5)!=0 ? 'display: none':'' ?>">
        <td><a target="_blank" href="/user/social/shared-profile?id=<?php echo $user->id?>"><img  style="margin:0;" data-toggle="popover" data-trigger="hover" data-placement="right" data-content="<strong><?= $user->fname && $user->lname ? $user->fname.' '.$user->lname : $user->email ?></strong> <br/> <?= $user->country ? $user->country : '' ?><?= $user->city ? ($user->country ? ', ' : '').$user->city : '' ?>" class="active gant_avatar" src="<?php echo $user->ava ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$user->ava:'/images/avatar/nophoto.png'?>"></a></td>
        <td style="text-align:left;" class="name">
            <div data-toggle="popover" data-placement="bottom" <?php if(strlen($user->task_name) >30):?>data-content="<?= $user->task_name ?>"<?php endif;?> class="pull-left" style="width: 240px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><?= $user->task_name ?>
            </div>
            <div class="pull-right">
                <a href="#" data-toggle="popover" data-content="<?= strip_tags($user->task_desc) ?>" class="btn btn-primary static circle info">i</a>
            </div>

        </td>
        <td><?= $user->dname ?></td>
        <td><?= $user->task_special ?></td>
        <td><?= $user->task_user_time ?></td><!--Саша -ХУЙ-->
        <td><?= $user->task_rate && $user->task_rate!=0 ? $user->task_rate.'$' : '-' ?></td>
        <td><button data-id="<?= $user->tool ?>" data-task-id="<?= $user->task_id ?>" style="font-size:10px;" class="btn btn-primary circle button-select"><i class="ico-add"></i></button></td>
    </tr>
    <? $i++; ?>
<? endforeach; ?>
<? require __DIR__.'/pagination.php' ?>