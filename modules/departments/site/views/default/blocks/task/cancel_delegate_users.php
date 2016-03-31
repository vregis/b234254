
<? foreach($users as $user) : ?>
    <tr class="user-row">
        <td width="50"><a target="_blank" href="/user/social/shared-profile?id=<?= $user->id ?>"><img  onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" class="active gant_avatar" src="<?php echo $user->ava ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$user->ava:'/images/avatar/nophoto.png'?>"></a></td>
        <td class="field-name" width="273"><?= $user->fname && $user->lname ? $user->fname.' '.$user->lname : $user->email ?></td>
        <td width="165">
            <div class="date" style="min-width: 141px;">
                <input type="hidden" id="input-href" name="href" value="none">
                        <button style="padding-top: 2px;font-size: 17px;margin-right: 5px !important;" class="btn btn-primary circle icon" id="btn-datepicker" data-toggle="collapse" data-target="#datepicker" aria-expanded="true" aria-controls="datepicker">
                        <i class="ico-calendar"></i>
                    </button>
                    <span class="title-value start">30</span> <span class="title-caption start">Mar</span> -
                <span class="title-value end">19</span> <span class="title-caption end">Apr</span>
            </div>
        </td>
        <td width="105" style="text-align: left;">
            <div class="cost">
                <button style="display: inline-block;padding-top: 2px;font-size: 17px;" class="btn btn-primary circle icon static" data-toggle="popover" data-placement="bottom" data-content="test">
                    <i class="ico-dollar"></i>
                </button>
                <? if($user->rate_h){ ?>
					<span  style="width: 62px;display: inline-block;text-align: center;"><?=$user->rate_h?></span>
                <?	} else{ ?>
                	<span  style="width: 62px;display: inline-block;text-align: center;">-</span>
                <?	} ?>
                <input class="chngval"  value="0" type="text" style="display:none;">
            </div>
        </td>
        <td width="50">
            <a data-date="20 Mar - 1 May" data-rate="<?=$user->rate_h?$user->rate_h:"-"?>" data-location="<?= $user->country ? $user->country : '' ?><?= $user->city ? ($user->country ? ', ' : '').$user->city : '' ?>" data-name="<?= $user->fname && $user->lname ? $user->fname.' '.$user->lname : $user->email ?>" style="display: inline-block;padding-top: 1px;" href="#" class="to-chat btn btn-primary circle"><i class="ico-chat" style="margin-left: -2px;"></i></a>
        </td>
        <td style="text-align: right;padding-right: 20px;">
            <button delegate-data-id="<?= $user->del_id ?>" style="display: inline-block;" class="offerall cancel-delegate-select btn btn-primary btn btn-danger confirn confirn-btn offer open">Cancel</button>
        </td>
    </tr>
<? endforeach; ?>