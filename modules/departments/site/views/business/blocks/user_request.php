<? $i=0; ?>
<? foreach($users as $user) : ?>
    <tr class="user-row" data-page-id="<?= intval($i/5) ?>" style="<?=intval($i/5)!=0 ? 'display: none':'' ?>">
        <td><img style="margin:0;" data-toggle="popover" data-placement="right" data-content="<strong><?= $user->fname && $user->lname ? $user->fname.' '.$user->lname : $user->email ?></strong> <br/> <?= $user->country ? $user->country : '' ?><?= $user->city ? ($user->country ? ', ' : '').$user->city : '' ?>"  class="active gant_avatar" src="<?php echo $user->user_avatar ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$user->user_avatar:'/images/avatar/nophoto.png'?>"></td>
        <td style="text-align:left;" class="name"><div data-toggle="popover" data-placement="bottom" class="pull-left" style="width: 240px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><?= $user->task_name ?></div> <div class="pull-right"><a href="#" data-toggle="popover" data-content="<?= $user->task_name ?>" class="btn btn-primary static circle info">i</a></div></td>
        <td><?= $user->dname ?></td>
        <td><?= $user->task_special ?></td>
        <td><?= $user->task_user_time ?></td>
        <? $rate_h = $user->task_user_price && $user->task_user_time ? intval($user->task_user_price / $user->task_user_time) : 0 ?>
        <td><?= $rate_h && $rate_h!=0 ? $rate_h.'$' : '-' ?></td>
        <td><button data-id="<?= $user->id ?>" style="font-size:10px;" class="btn btn-primary circle button-select"><i class="ico-delete"></i></button></td>
    </tr>
    <? $i++; ?>
<? endforeach; ?>
<? require __DIR__.'/pagination.php' ?>