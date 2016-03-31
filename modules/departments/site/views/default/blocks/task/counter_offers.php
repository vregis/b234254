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
function getData2($data) {
    $m = '';
    $d = '';
    if($data != '') {
        preg_match("#(\d+)-(\d+)-(\d+)#", $data,$mathces);
        $m = TaskUser::getMonth($mathces[2]);
        $d = intval($mathces[3]);
    }
    return $d.' '.$m;
}
?>
<!--
<div class="arrow"></div>
<table style="width:100%;" class="table">
    <tbody id="counter_users">-->
<!-- <div class="counter_users"> -->
    <? foreach($counter_offers as $counter_offer) : ?>
        <tr class="counter-offer-row">
            <td width="50" style="border:0;">
                <a target="_blank" href="/user/social/shared-profile?id=<?= $counter_offer->id ?>"><img style="margin-right: 5px;" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" class="active gant_avatar" src="<?php echo $counter_offer->delegate_avatar ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$counter_offer->delegate_avatar:'/images/avatar/nophoto.png'?>"></a>
            </td>
            <td style="border:0;" class="field-name" width="273"><div <?php if(strlen($counter_offer->name) >32):?>data-toggle="popover" data-placement="bottom" data-content="<?= $counter_offer->name ?>"<?php endif;?> style="width: 160px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;display: inline-block;line-height: 32px;vertical-align: middle;"><?= $counter_offer->name ?></div>
            </td>
            <td width="165" style="text-align: left;border:0;">
                <button style="margin-right: 5px;font-size: 17px;" class="btn btn-primary circle icon static"><i class="ico-calendar"></i></button>
                <?= getData($counter_offer->start) ?> - <?= getData($counter_offer->end) ?>
            </td>
            <td width="105" style="text-align: left;border:0;">
                <button style="margin-right: 5px;font-size: 17px;" class="btn btn-primary circle icon static <? if($counter_offer->counter_price > $counter_offer->price) echo 'bg-red-pink';
            elseif($counter_offer->counter_price < $counter_offer->price) echo 'bg-green-jungle' ?>"><i class="ico-dollar"></i></button>
                <div class="<? if($counter_offer->counter_price > $counter_offer->price) echo 'bg-red-pink';
            elseif($counter_offer->counter_price < $counter_offer->price) echo 'bg-green-jungle' ?>" style="display: inline-block;text-align: center;width:62px;border:0 !important;"><input class="chngval" value="<?= $counter_offer->counter_price ? $counter_offer->counter_price : '-' ?>" type="text"></div>
            </td>
            <td style="border:0;" width="50">
                <a data-date="<?= getData2($counter_offer->start) ?> - <?= getData2($counter_offer->end) ?>" data-rate="<?= $counter_offer->counter_price ? $counter_offer->counter_price : '-' ?>" data-location="<?= $counter_offer->country ? $counter_offer->country : '' ?><?= $counter_offer->city ? ($counter_offer->country ? ', ' : '').$counter_offer->city : '' ?>" data-name="<?= $counter_offer->name ?>" style="display: inline-block;padding-top: 1px;" href="#" class="to-chat btn btn-primary circle"><i class="ico-chat" style="margin-left: -2px;"></i></a>
            </td>
            <td style="text-align: right;padding-right: 20px;border:0;">
                <button style="display:inline-block;" class="btn btn-danger confirn" data-status="0" data-delegate_task_id="<?= $counter_offer->id ?>">Reject</button>
                <button style="display:inline-block;" class="btn btn-success confirn" data-status="1" data-delegate_task_id="<?= $counter_offer->id ?>">Accept</button>
            </td>
        </tr>

    <? endforeach; ?>
    <!-- </div> -->
    <!--</tbody>
</table>-->
