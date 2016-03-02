<? $i=0; ?>
<?php //var_dump($users); die();?>
<? foreach($users as $user) : ?>
    <?php $tool = \modules\tasks\models\UserTool::find()->where(['user_id' => $user->id, 'status' => 3])->one();?>
    <?php $tl = \modules\tasks\models\UserTool::find()->where(['id' => $user->tool])->one();?>
    <tr class="user-row" data-page-id="<?= intval($i/5) ?>" style="<?=intval($i/5)!=0 ? 'display: none':'' ?>">
        <td width="60"><img  onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" style="margin:0;" data-toggle="popover" data-placement="right" data-content='<div style="text-align:left;"><strong><?= $user->fname && $user->lname ? $user->fname.' '.$user->lname : $user->email ?></strong> <br/> <?= $user->country ? $user->country : '' ?><?= $user->city ? ($user->country ? ', ' : '').$user->city : '' ?><br> Eco Farm </div><p style="text-align:justify">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat.</p><div class="clearfix"></div> <a target="_blank" href="/user/social/shared-profile?id=<?php echo $user->uid?>" class="btn btn-primary pull-left">My profile</a>
        <?php echo ($tool)?'<a target="_blank" href="/departments/business/shared-business?id='.$user->tool.'" class="btn btn-primary pull-right">My business</a>':'<a href="#" class="btn btn-primary pull-right">My business</a>'?> <div class="clearfix"></div>' class="active gant_avatar" src="<?php echo $user->ava ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$user->ava:'/images/avatar/nophoto.png'?>"></td>
        <td width="290" style="text-align:left;" class="name">
            <div data-toggle="popover" data-placement="bottom" <?php if(strlen($user->task_name) >30):?>data-content="<?= $user->task_name ?>"<?php endif;?> class="pull-left" style="width: 240px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><?= $user->task_name ?>
            </div>
            <div class="pull-right">
                <a href="javascript:;" data-toggle="popover" data-content="<?= strip_tags($user->task_desc) ?>" class="btn btn-primary static circle info">i</a>
            </div>

        </td>
        <td width="170"><?= $user->dname ?></td>
        <td width="121"><?= $user->task_special ?></td>
        <td width="120"><?= $user->task_user_time ?></td><!--Саша -ХУЙ-->
        <td width="120"><?= $user->task_rate && $user->task_rate!=0 ? $user->task_rate.'$' : '-' ?></td>
        <td width="121"><button data-id="<?= $user->tool ?>" data-task-id="<?= $user->task_id ?>" style="font-size:10px;" class="btn btn-primary circle button-select"><i class="ico-add"></i></button></td>
    </tr>
    <? $i++; ?>
<? endforeach; ?>
<? require __DIR__.'/pagination.php' ?>