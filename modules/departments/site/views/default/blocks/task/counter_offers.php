<?php

use modules\tasks\models\TaskUser;

function getData($data) {
    $m = '';
    $d = '';
    if($data != '') {
        preg_match("#(\d+)-(\d+)-(\d+)#", $data,$mathces);
        $m = TaskUser::getMonth($mathces[2]);
        $d = intval($mathces[3]);
    }
    return '<span class="title-value start">'.$d.'</span> <span class="title-caption start">'.$m.'</span>';
}

?>
<!--
<div class="arrow"></div>
<table style="width:100%;" class="table">
    <tbody id="counter_users">-->
<div class="counter_users">
    <? foreach($counter_offers as $counter_offer) : ?>

        <tr class="counter-offer-row">
            <td width="50">
                <a target="_blank" href="/user/social/shared-profile?id=<?= $counter_offer->id ?>"><img style="margin-right: 5px;" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" class="active gant_avatar" src="<?php echo $counter_offer->delegate_avatar ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$counter_offer->delegate_avatar:'/images/avatar/nophoto.png'?>"></a>
            </td>
            <td class="field-name" width="263"><div <?php if(strlen($counter_offer->name) >32):?>data-toggle="popover" data-placement="bottom" data-content="<?= $counter_offer->name ?>"<?php endif;?> style="width: 160px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;display: inline-block;line-height: 32px;vertical-align: middle;"><?= $counter_offer->name ?></div>
            </td>
            <td width="165">
                <button style="margin-right: 5px;padding-top: 2px;font-size: 17px;" class="btn btn-primary circle icon static"><i class="ico-calendar"></i></button>
                <?= getData($counter_offer->start) ?> - <?= getData($counter_offer->end) ?>
            </td>
            <td width="105" style="text-align: left;">
                <button style="margin-right: 5px;text-align: center;padding-top: 3px;font-size: 24px !important;" class="btn btn-primary circle icon static <? if($counter_offer->counter_time > $counter_offer->time) echo 'bg-red-pink';
            elseif($counter_offer->counter_time < $counter_offer->time) echo 'bg-green-jungle' ?>"><i class="ico-clock1"></i></button>    
                <?php if($counter_offer->counter_time): ?>
                <div class="<? if($counter_offer->counter_time > $counter_offer->time) echo 'bg-red-pink';
            elseif($counter_offer->counter_time < $counter_offer->time) echo 'bg-green-jungle' ?>" style="display: inline-block;text-align: center;width:62px;border: none;">
                    <?= $counter_offer->counter_time ?>h
                </div>
            <?php else: ?>
                <div style="display: inline-block;text-align: center;width:62px;border:0 !important;"> - </div>
            <?php endif; ?>
            </td>
            <td style="width: 122px;" class="">
                <button style="margin-right: 5px;padding-top: 2px;font-size: 17px;" class="btn btn-primary circle icon static <? if($counter_offer->counter_price > $counter_offer->price) echo 'bg-red-pink';
            elseif($counter_offer->counter_price < $counter_offer->price) echo 'bg-green-jungle' ?>"><i class="ico-dollar"></i></button>
                <div class="<? if($counter_offer->counter_price > $counter_offer->price) echo 'bg-red-pink';
            elseif($counter_offer->counter_price < $counter_offer->price) echo 'bg-green-jungle' ?>" style="display: inline-block;text-align: center;width:62px;border:0 !important;"><?= $counter_offer->counter_price ? $counter_offer->counter_price : '-' ?></div>
            </td>
            <td style="width: 360px;text-align:right;border-right: 1px solid #d7d7d7 !important;"><button style="display:inline-block;margin-right: 12px;" class="btn btn-danger confirn" data-status="0" data-delegate_task_id="<?= $counter_offer->id ?>">Reject</button>
                <button style="display:inline-block;margin-right: 28px;" class="btn btn-success confirn" data-status="1" data-delegate_task_id="<?= $counter_offer->id ?>">Accept</button>
            </td>
        </tr>

    <? endforeach; ?>
    </div>
    <!--</tbody>
</table>-->
