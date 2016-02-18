<? $i=0; ?>
<?php //var_dump($users); die();?>
<? foreach($users as $user) : ?>
    <tr class="user-row" data-page-id="<?= intval($i/5) ?>" style="<?=intval($i/5)!=0 ? 'display: none':'' ?>">
        <td><img style="margin:0;" data-toggle="popover" data-placement="right" data-content='<div style="text-align:left;"><strong><?= $user->fname && $user->lname ? $user->fname.' '.$user->lname : $user->email ?></strong> <br/> <?= $user->country ? $user->country : '' ?><?= $user->city ? ($user->country ? ', ' : '').$user->city : '' ?><br> Eco Farm </div><p style="text-align:justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat.</p><div class="clearfix"></div> <a href="#" class="btn btn-primary pull-left">My profile</a><a href="/departments/business" class="btn btn-primary pull-right">My business</a> <div class="clearfix"></div>'  class="active gant_avatar" src="<?php echo $user->user_avatar ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$user->user_avatar:'/images/avatar/nophoto.png'?>"></td>
        <td style="text-align:left;" class="name"><div data-toggle="popover" data-placement="bottom" data-content="<?= $user->task_name ?>" class="pull-left" style="width: 220px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><?= $user->task_name ?></div> <div class="pull-right"><a href="javascript:;" data-toggle="popover" data-content="<?= strip_tags($user->name) ?>" class="btn btn-primary static circle info">i</a></div></td>
        <td><?= $user->dname ?></td>
        <td><?= $user->task_special ?></td>
        <td><?= $user->task_user_time ?></td>
        <? $rate_h = $user->task_user_price && $user->task_user_time ? intval($user->task_user_price / $user->task_user_time) : 0 ?>
        <td><?= $rate_h && $rate_h!=0 ? $rate_h.'$' : '-' ?></td>
        <td><button data-id="<?= $user->id ?>" style="font-size:10px;" class="btn btn-danger circle button-select"><i class="ico-delete"></i></button></td>
    </tr>
    <? $i++; ?>
<? endforeach; ?>
<? require __DIR__.'/pagination.php' ?>