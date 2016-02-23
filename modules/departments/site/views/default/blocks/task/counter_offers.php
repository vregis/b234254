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
<table style="width:100%;" class="table with-foot">
    <thead>
    <tr>
        <th colspan="7" style="height: 25px;"></th>
    </tr>
    </thead>
    <tbody id="counter_users">
    <? foreach($counter_offers as $counter_offer) : ?>
        <tr class="counter-offer-row">
            <td><img  onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" class="active gant_avatar" src="<?php echo $counter_offer->delegate_avatar ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$counter_offer->delegate_avatar:'/images/avatar/nophoto.png'?>"></td>
            <td><?= $counter_offer->name ?></td>
            <td><?= getData($counter_offer->start) ?> - <?= getData($counter_offer->end) ?></td>
            <td style="width: 50px;" class="<? if($counter_offer->counter_time > $counter_offer->time) echo 'bg-red-pink bg-font-red-pink';
            elseif($counter_offer->counter_time < $counter_offer->time) echo 'bg-green-jungle bg-font-green-jungle' ?>"><?= $counter_offer->counter_time ? $counter_offer->counter_time.'h' : '-' ?></td>
            <td style="width: 50px;" class="<? if($counter_offer->counter_price > $counter_offer->price) echo 'bg-red-pink bg-font-red-pink';
            elseif($counter_offer->counter_price < $counter_offer->price) echo 'bg-green-jungle bg-font-green-jungle' ?>"><?= $counter_offer->counter_price ? '$'.$counter_offer->counter_price : '-' ?></td>
            <td><?= $counter_offer->country ? $counter_offer->country : '' ?><?= $counter_offer->city ? ($counter_offer->country ? ', ' : '').$counter_offer->city : '' ?></td>
            <td style="width: 250px;"><button style="display:inline-block;" class="btn btn-primary confirn" data-status="0" data-delegate_task_id="<?= $counter_offer->id ?>">Reject</button>
                <button style="display:inline-block;" class="btn btn-primary confirn" data-status="1" data-delegate_task_id="<?= $counter_offer->id ?>">Accept</button>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="7" style="height: 25px;"></th>
    </tr>
    </tfoot>
</table>
