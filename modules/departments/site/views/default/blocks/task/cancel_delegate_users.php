<? foreach($users as $user) : ?>
    <tr class="user-row">
        <td><img  onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" class="active gant_avatar" src="<?php echo $user->ava ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$user->ava:'/images/avatar/nophoto.png'?>"></td>
        <td class="field-name"><?= $user->fname && $user->lname ? $user->fname.' '.$user->lname : $user->email ?></td>
        <td><?= $user->level ? $user->level : '-' ?></td>
        <td><?= $user->rate_h ? $user->rate_h.'$' : '-' ?></td>
        <td><?= $user->country ? $user->country : '' ?><?= $user->city ? ($user->country ? ', ' : '').$user->city : '' ?></td>
        <td><button data-id="<?= $user->id ?>" class="btn btn-danger circle offerall cancel-delegate-select"><i class="ico-cancel"></i></button></td>
    </tr>

<? endforeach; ?>