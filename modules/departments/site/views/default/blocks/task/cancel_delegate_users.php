<? foreach($users as $user) : ?>
    <?php
    $start_d = '';
    $start_m = '';
    $end_d = '';
    $end_m = '';
    if($user->start && $user->start != '') {
        preg_match("#(\d+)-(\d+)-(\d+)#", $user->start,$mathces);
        if(isset($mathces[2]) && isset($mathces[3])) {
            $start_m = \modules\tasks\models\TaskUser::getMonth($mathces[2]);
            $start_d = intval($mathces[3]);
        }
    }
    if($user->end && $user->end != '') {
        preg_match("#(\d+)-(\d+)-(\d+)#", $user->end,$mathces);
        if(isset($mathces[2]) && isset($mathces[3])) {
            $end_m = \modules\tasks\models\TaskUser::getMonth($mathces[2]);
            $end_d = intval($mathces[3]);
        }
    }
    ?>
    <tr class="user-row">
        <td width="50"><a target="_blank" href="/user/social/shared-profile?id=<?= $user->id ?>"><img  onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" class="active gant_avatar" src="<?php echo $user->ava ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$user->ava:'/images/avatar/nophoto.png'?>"></a></td>
        <td class="field-name" width="273"><?= $user->fname && $user->lname ? $user->fname.' '.$user->lname : $user->email ?></td>
        <td width="165" style="text-align: right;padding-right: 8px;">
            <div class="date" style="min-width: 141px;">
                <input type="hidden" id="input-href" name="href" value="none">
                        <button style="font-size: 17px;margin-right: 5px !important;" class="btn btn-primary circle icon click_ico" data-t-id = '<?php echo $user->del_id?>' id="btn-datepicker" data-toggle="collapse" data-target="#datepicker" aria-expanded="true" aria-controls="datepicker">
                        <i class="ico-calendar click_ico" data-t-id = '<?php echo $user->del_id?>' ></i>
                    </button>
                <span class="title-value start"><?php echo $start_d?></span> <span class="title-caption start"><?php echo $start_m?></span> -
                <span class="title-value end"><?php echo $end_d?></span> <span class="title-caption end"><?php echo $end_m?></span>
            </div>
        </td>
        <td width="105" style="text-align: left;">
            <div class="cost">
                <button style="display: inline-block;font-size: 17px;" class="btn btn-primary circle icon static" data-toggle="popover" data-placement="bottom" data-content="test">
                    <i class="ico-dollar"></i>
                </button>
                <? if($user->rate_h){ ?>
					<span  style="width: 62px;display: inline-block;text-align: center;"><?=$user->rate_h?></span>
                <?	} else{ ?>
                	<span  style="width: 62px;display: inline-block;text-align: center;">-</span>
                <?	} ?>
            </div>
        </td>
        <td width="50">
            <a data-delegate_task_id="<?= $user->del_id ?>" data-date="20 Mar - 1 May" data-rate="<?=$user->rate_h?$user->rate_h:"-"?>" data-location="<?= $user->country ? $user->country : '' ?><?= $user->city ? ($user->country ? ', ' : '').$user->city : '' ?>" data-name="<?= $user->fname && $user->lname ? $user->fname.' '.$user->lname : $user->email ?>" style="display: inline-block;padding-top: 1px;" href="#" class="to-chat btn btn-primary circle"><i class="ico-chat" style="margin-left: -2px;"></i></a>
        </td>
        <td style="text-align: right;padding-right: 20px;">
            <button data-id="<?= $user->id ?>" data-delegate_task_id="<?= $user->del_id ?>" style="display: inline-block;" class="cancel-delegate-select btn btn-primary btn btn-danger">Cancel</button>
        </td>
    </tr>
<? endforeach; ?>

<script>
    $(document).on('click', '.click_ico', function(){
        $(this).addClass('current_clk');
    })
</script>
