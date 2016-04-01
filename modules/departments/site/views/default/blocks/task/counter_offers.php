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
    <? foreach($counter_offers as $counter_offer) : ?>
        <tr class="counter-offer-row">
            <td width="50" style="border:0;">
                <a target="_blank" href="/user/social/shared-profile?id=<?= $counter_offer->id ?>"><img style="margin-right: 5px;" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" class="active gant_avatar" src="<?php echo $counter_offer->delegate_avatar ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$counter_offer->delegate_avatar:'/images/avatar/nophoto.png'?>"></a>
            </td>
            <td style="border:0;" class="field-name" width="273"><div <?php if(strlen($counter_offer->name) >32):?>data-toggle="popover" data-placement="bottom" data-content="<?= $counter_offer->name ?>"<?php endif;?> style="width: 160px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;display: inline-block;line-height: 32px;vertical-align: middle;"><?= $counter_offer->name ?></div>
            </td>
            <td width="165" style="text-align: right;padding-right: 8px;border:0;">
                <button style="margin-right: 5px;font-size: 17px;" class="btn btn-primary circle icon static"><i class="ico-calendar"></i></button>
                <?php if (getData2($counter_offer->start) == '' || getData2($counter_offer->end)): ?>
                    <span style="width:36px;display: inline-block;"></span>
                <?php else: ?>
                    <?= getData($counter_offer->start) ?> - <?= getData($counter_offer->end) ?>
                <?php endif; ?>
            </td>
            <td width="105" style="text-align: left;border:0;">
                <button style="margin-right: 5px;font-size: 17px;" class="btn btn-primary circle icon static <? if($counter_offer->counter_price > $counter_offer->price) echo 'bg-red-pink';
            elseif($counter_offer->counter_price < $counter_offer->price) echo 'bg-green-jungle' ?>"><i class="ico-dollar"></i></button>
                <div class="<? if($counter_offer->counter_price > $counter_offer->price) echo 'bg-red-pink';
            elseif($counter_offer->counter_price < $counter_offer->price) echo 'bg-green-jungle' ?>" style="display: inline-block;text-align: center;border:0 !important;margin-left: 5px;"><input class="chngval-accept" value="<?= $counter_offer->counter_price ? $counter_offer->counter_price : '-' ?>" type="text"></div>
            </td>
            <td style="border:0;" width="50">
                <a data-date="<?= getData2($counter_offer->start) ?> - <?= getData2($counter_offer->end) ?>" data-rate="<?= $counter_offer->counter_price ? $counter_offer->counter_price : '-' ?>" data-location="<?= $counter_offer->country ? $counter_offer->country : '' ?><?= $counter_offer->city ? ($counter_offer->country ? ', ' : '').$counter_offer->city : '' ?>" data-name="<?= $counter_offer->name ?>" style="display: inline-block;padding-top: 1px;" href="#" class="to-chat btn btn-primary circle"><i class="ico-chat" style="margin-left: -2px;"></i></a>
            </td>
            <td style="text-align: right;padding-right: 20px;border:0;">
                <button style="display:inline-block;" class="btn btn-danger confirn" data-status="0" data-delegate_task_id="<?= $counter_offer->id ?>">Reject</button>
            <?php if($counter_offer->counter_price == $counter_offer->price):?>
                <button style="display:inline-block;" class="btn btn-success confirn accept-counter" data-status="1" data-delegate_task_id="<?= $counter_offer->id ?>">Accept</button>
            <?php else: ?>
                <button style="display:inline-block;line-height: 1;font-size: 12px !important;" class="btn btn-success confirn accept-counter" data-status="1" data-delegate_task_id="<?= $counter_offer->id ?>">Counter <br/ > Offer</button>
            <?php endif; ?>
            </td>
        </tr>
    <? endforeach; ?>

<script>
    $('.chngval-accept').keyup(function(){
        $(this).closest('tr').find('.accept-counter').text('Counter <br/ > Offer').css({
            'font-size':'12px',
            'line-height':1
        });
    })
</script>
<style>
    .counter-offer-row div.bg-red-pink input{
        border-color:#E08283 !important;
        color:#E08283 !important;
    }
    .counter-offer-row div.bg-green-jungle input{
        border-color:#26C281 !important;
        color:#26C281 !important;
    }
    .counter-offer-row button.bg-red-pink{
        border-color:#E08283;
        color:#E08283;
    }
    .counter-offer-row button.bg-green-jungle{
        border-color:#26C281;
        color:#26C281;
    }
</style>