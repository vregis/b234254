<?
use modules\tasks\models\TaskUser;
use yii\helpers\Url;
use modules\tasks\models\DelegateTask;

$start_m = '';
$start_d = '';

if(!isset($start_date)) {
    if($is_my) {
        $start_date = $task_user->start;
    }
    else {
        if($delegate_task->status <= DelegateTask::$status_offer) {
            $start_date = $delegate_task->start;
        }
        else {
            $start_date = $task_user->start;
        }
    }
}
if(!isset($end_date)) {
    if($is_my) {
        $end_date = $task_user->end;
    }
    else {
        if($delegate_task->status <= DelegateTask::$status_offer) {
            $end_date = $delegate_task->end;
        }
        else {
            $end_date = $task_user->end;
        }
    }
}
$start_date = $task_user->start;
$end_date = $task_user->end;
if(!$is_my) {
    if($delegate_task->status <= DelegateTask::$status_offer) {
        $start_date = $delegate_task->start;
    }
    else {
        $start_date = $task_user->start;
    }
    if($delegate_task->status <= DelegateTask::$status_offer) {
        $end_date = $delegate_task->end;
    }
    else {
        $end_date = $task_user->end;
    }
}

if($start_date != '') {
    preg_match("#(\d+)-(\d+)-(\d+)#", $start_date,$mathces);
    if(isset($mathces[2]) && isset($mathces[3])) {
        $start_m = TaskUser::getMonth($mathces[2]);
        $start_d = intval($mathces[3]);
    }
}
$end_m = '';
$end_d = '';
if($start_date != '') {
    preg_match("#(\d+)-(\d+)-(\d+)#", $end_date,$mathces);
    if(isset($mathces[2]) && isset($mathces[3])) {
        $end_m = TaskUser::getMonth($mathces[2]);
        $end_d = intval($mathces[3]);
    }
}

?>

<div id="status-delegate" data-status="<? if($delegate_task) echo $delegate_task->status; ?>"></div>

<input type="hidden" id="taskuser-start" data-value="<?= $start_date ?>" value="<?= $start_date ?>">
<input type="hidden" id="taskuser-end" data-value="<?= $end_date ?>" value="<?= $end_date ?>">

<div class="item date">
    <input type="hidden" id="input-href" name="href" value="none">
    <? if($is_my || ($delegate_task->status == DelegateTask::$status_inactive)) : ?>
        <button class="btn btn-primary circle icon" id="btn-datepicker" data-toggle="collapse" data-target="#datepicker" aria-expanded="false" aria-controls="datepicker">
            <i class="ico-calendar"></i>
        </button>
    <? else : ?>
        <button class="btn btn-primary circle icon static">
            <i class="ico-calendar"></i>
        </button>
    <? endif; ?>
    <span class="title-value start"><?= $start_d ?></span> <span class="title-caption start"><?= $start_m ?></span> -
    <span class="title-value end"><?= $end_d ?></span> <span class="title-caption end"><?= $end_m ?></span>
</div>
<div class="item time">
    <button class="btn btn-primary circle icon static" data-toggle="popover" data-placement="bottom" data-content="test">
        <i class="ico-clock"></i>
    </button>
    <? if($is_my) : ?>
        <? if($delegate_task && $delegate_task->status >= DelegateTask::$status_active) : ?>
            <span id="input-time"><?= $task_user->time ?></span>
        <? else : ?>
            <input id="input-time" value="<?= $task_user->time ?>" type="text">
        <? endif; ?>
    <? else : ?>
        <? if($delegate_task->status == DelegateTask::$status_inactive) : ?>
            <input id="input-time" data-value="<?= $delegate_task->time ?>" value="<?= $delegate_task->time ?>" type="text">
        <? elseif($delegate_task->status == DelegateTask::$status_offer) : ?>
            <span id="input-time"><?= $delegate_task->counter_time ?></span>
        <? else : ?>
            <span id="input-time"><?= $task_user->time ?></span>
        <? endif; ?>
    <? endif; ?>
</div>
<div class="item cost" style="margin-right: 33px;">
    <button class="btn btn-primary circle icon static" data-toggle="popover" data-placement="bottom" data-content="test">
        <i class="ico-dollar"></i>
    </button>
    <? if($is_my) : ?>
        <? if($delegate_task && $delegate_task->status >= DelegateTask::$status_active) : ?>
            <span id="input-price"><?= $task_user->price ?></span>
        <? else : ?>
            <input id="input-price" value="<?= $task_user->price ?>" type="text">
        <? endif; ?>
    <? else : ?>
        <? if($delegate_task->status == DelegateTask::$status_inactive) : ?>
            <input id="input-price" data-value="<?= $delegate_task->price ?>" value="<?= $delegate_task->price ?>" type="text">
        <? elseif($delegate_task->status == DelegateTask::$status_offer) : ?>
            <span id="input-price"><?= $delegate_task->counter_price ?></span>
        <? else : ?>
            <span id="input-price"><?= $task_user->price ?></span>
        <? endif; ?>
    <? endif; ?>
</div>
<input type="hidden" id="taskuser-status" name="TaskUser[status]" value="<?= $task_user->status ?>">
<? if($is_my) : ?>
    <? if(!$delegate_task || $delegate_task->status <= DelegateTask::$status_offer) : ?>
        <? if(count($counter_offers) > 0) : ?>
            <button onclick="return false" data-toggle="collapse" data-target="#counter" aria-expanded="false" aria-controls="counter" class="btn btn-primary offer">Offers <!--<span class="label label-danger circle"><? //=count($counter_offers) ?></span>--></button>
        <? else : ?>
            <button class="btn btn-primary offer disabled static">Offers</button>
        <? endif; ?>
        <? if($task_user->status != 2) : ?>
            <button id="btn-delegate" class="btn btn-primary"
                data-task_user_id="<?= $task_user->id ?>" data-target="#delegate" aria-expanded="false" aria-controls="delegate" style="width:93px;">Delegate</button>
            <button onclick="if(!$(this).hasClass('disabled')) document.location.href='<?= Url::toRoute(['/tasks/complete','id' => $task_user->id]) ?>'" class="btn btn-success" style="width:93px;">Complete</button>
        <? else : ?>
            <button id="btn-delegate" class="btn btn-primary disabled static" style="width:93px;">Delegate</button>
            <button id="restart" class="btn btn-success" style="width:93px;">Restart</button>
        <? endif; ?>
    <? else : ?>
        <? if($delegate_task->status == DelegateTask::$status_active) : ?>
            <form style="display:inline-block;" action="/tasks/paypal/createpayment" id="paypal-form" method="post" target="_blank">
                <input type="hidden" name="name">
                <input type="hidden" name="sum">
                <input type="hidden" value="<?php echo $delegate_task->id?>" name="id">
                <button id="payment-paypal" onclick="return false" class="btn btn-success payment-btn" style="width:93px;font-size: 14px;">Fund</button> <!-- this is payment from client -->
            </form>
        <? elseif($delegate_task->status >= DelegateTask::$status_payment) : ?>
            <button class="btn btn-success disabled static payment-btn" style="width:93px;">Fund <span class="label label-success circle"><i class="fa fa-check"></i></span></button>
        <? endif; ?>
        <? if($delegate_task->status == DelegateTask::$status_active) : ?>
            <button style="display: inline-block;font-size: 12px;padding: 0 10px;line-height: 1;" class="btn btn-danger confirn confirn-btn offer" data-status="0" data-delegate_task_id="<?= $delegate_task->id ?>">Cancel delegate</button>
        <? else : ?>
            <button style="display: inline-block;font-size: 12px;padding: 0 10px;line-height: 1;" class="btn btn-danger confirn confirn-btn offer" data-status="0" data-delegate_task_id="<?= $delegate_task->id ?>">Cancel delegate</button>
        <? endif; ?>
        <? if($task_user->status != 2) : ?>
            <button onclick="if(!$(this).hasClass('disabled')) document.location.href='<?= Url::toRoute(['/tasks/complete','id' => $task_user->id]) ?>'"
                class="btn btn-success <? if($delegate_task && $delegate_task->status < DelegateTask::$status_complete) echo 'disabled static' ?>" style="width:93px;">Complete</button>
        <? else : ?>
            <button style="display: inline-block;font-size: 12px;padding: 0 10px;line-height: 1;" class="btn btn-danger confirn confirn-btn offer restrt" data-status="0" data-delegate_task_id="<?= $delegate_task->id ?>">Restart</button>
        <? endif; ?>
    <? endif; ?>
<? else : ?>
    <? if($delegate_task->status == DelegateTask::$status_inactive) : ?>
        <?php if($delegate_task->is_request == 1):?>
            <button id="<?= $delegate_task->is_request==0 ? 'btn-accept' :'' ?>" class="btn btn-primary static disabled" style="width:93px;<? //= $delegate_task->is_request==1?'visibility: hidden;':'' ?>">Payment</button>
            <button onclick="if(!$(this).hasClass('disabled')) document.location.href='<?= Url::toRoute(['/tasks/reject','id' => $task_user->id]) ?>'" class="btn btn-danger" style="width:93px;<? //= $delegate_task->is_request==1?'visibility: hidden;':'' ?>">Reject</button>
        <button id="<?= $delegate_task->is_request==1 ? 'btn-accept' :'' ?>" aria-expanded="false" class="btn btn-success offer <?= $delegate_task->is_request==0 ? '' :'' ?>">Request</button>

        <?php else:?>
            <button id="<?= $delegate_task->is_request==1 ? 'btn-accept' :'' ?>" aria-expanded="false" class="btn btn-primary offer <?= $delegate_task->is_request==0 ? 'static disabled' :'' ?>">Payment</button>
            <button onclick="if(!$(this).hasClass('disabled')) document.location.href='<?= Url::toRoute(['/tasks/reject','id' => $task_user->id]) ?>'" class="btn btn-primary" style="width:93px;<?= $delegate_task->is_request==1?'visibility: hidden;':'' ?>">Reject</button>
            <button id="<?= $delegate_task->is_request==0 ? 'btn-accept' :'' ?>" class="btn btn-success" style="width:93px;<?= $delegate_task->is_request==1?'visibility: hidden;':'' ?>">Accept</button>
        <?php endif;?>

        <? else : ?>
        <? if($delegate_task->status == DelegateTask::$status_checked && $task_user->status = 2) : ?>
            <button id="get_money_confirm" onclick="return false" class="btn btn-primary payment-btn" style="width:93px;" data-toggle="popover">
                Payment <span class="label label-primary circle"><i class="fa fa-plus"></i></span>
            </button>
        <? elseif($delegate_task->status >= DelegateTask::$status_payment && $delegate_task->status < DelegateTask::$status_checked) : ?>
            <?php $chk = 1;?>
            <button id="get_money" onclick="return false" class="btn btn-primary static disabled payment-btn" style="width:93px;" data-toggle="popover" data-trigger="hover" data-content="Your payment has been processed successfully. Wait for your task acceptance to get it">
                Payment <span class="label label-primary circle"><i class="fa fa-plus"></i></span>
            </button>
            <button class="btn btn-primary disabled static static" style="width:93px;">Reject</button>
            <?php if($delegate_task && $delegate_task->status != DelegateTask::$status_payment):?>
                <button class="btn btn-success disabled static" style="width:93px">Accept</button>
            <?php endif;?>
        <?php else: ?>
            <?php $chk = 1;?>
            <button class="btn btn-success disabled static payment-btn" style="width:93px;font-size:14px;">Payment</button>
            <?php if($delegate_task->status == 1):?>
            <button onclick="if(!$(this).hasClass('disabled')) document.location.href='<?= Url::toRoute(['/tasks/reject','id' => $task_user->id]) ?>'" class="btn btn-danger" style="width:93px;<? //= $delegate_task->is_request==1?'visibility: hidden;':'' ?>">Reject</button>
            <?php else:?>
                <button class="btn btn-primary disabled static" style="width:93px;">Reject</button>
            <?php endif;?>
            <?php if($delegate_task && $delegate_task->status == 1):?>
            <button class="btn btn-success disabled static" style="width:93px;<?= $delegate_task->is_request==1?'visibility: hidden;':'' ?>">Submit</button>
            <?php else:?>
                <?php if($delegate_task && $delegate_task->status == 7):?>
                    <button class="btn btn-success" onclick="location.reload()" style="width:93px;<?= $delegate_task->is_request==1?'visibility: hidden;':'' ?>">Complete</button>
                    <?php else:?>
                <button class="btn btn-success disabled static" style="width:93px;<?= $delegate_task->is_request==1?'visibility: hidden;':'' ?>">Accept</button>
                    <?php endif;?>
            <?php endif;?>
        <?php endif; ?>
        <!--<button class="btn btn-primary disabled static static" style="width:93px;">Reject</button>-->
        <?php if(!isset($chk)):?>
            <?php if($delegate_task && $delegate_task->status == 6):?>
                <button class="btn btn-danger disabled static" style="width:93px;">Reject</button>
                <button class="btn btn-success disabled static" style="width:93px">Accept</button>
            <?php else:?>
                <button onclick="if(!$(this).hasClass('disabled')) document.location.href='<?= Url::toRoute(['/tasks/reject','id' => $task_user->id]) ?>'" class="btn btn-danger" style="width:93px;<? //= $delegate_task->is_request==1?'visibility: hidden;':'' ?>">Reject</button>
            <?php endif;?>

        <?php endif;?>
            <?php if($delegate_task && $delegate_task->status != DelegateTask::$status_payment):?>
            <?php else: ?>
        <button onclick="if(!$(this).hasClass('disabled')) document.location.href='<?= Url::toRoute(['/tasks/submit','id' => $delegate_task->id]) ?>'"
                class="btn btn-success" style="width:93px;">Submit</button>
            <?php endif; ?>
    <? endif; ?>
<? endif; ?>
<a href="#" data-dismiss="modal" class="href-black task-close"></a>
<div id="payment-form" style="display:none;">
    <div class="container-fluid">
        <div class="row">
            <?php if($is_my): ?>
                <label for="" class="col-sm-12">Pay with credit card</label>
            <?php else: ?>
                <label for="" style="text-align: left;" class="col-sm-6">You will receive</label>
                <div class="col-sm-6 text-right">
                    $ <span class="money">1000</span>
                </div>
            <?php endif; ?>
        </div>
        <div class="row"><label for="" class="col-sm-12" style="text-align:center;">Enter payment information</label></div>

        <div class="row">
            <div class="col-sm-6 col-xs-6 noselect"><input style="height:28px;margin:2px 0;" type="text" class="form-control" data-inputmask="'alias': 'email'" placeholder="Paypal login" name="paypal_login"></div>
            <div class="col-sm-6 col-xs-6 noselect"><input style="height:28px;margin:2px 0;" type="text" class="form-control" data-inputmask="'alias': 'email'" placeholder="Re-type paypal login" name="paypal_loginre"></div>
        </div>
        <div class="row text-center">
            <button style="margin:20px 0 0 0;" id="btn-<?= ($is_my) ? "pay" : "receive" ?>" type="submit" class="btn btn-primary"><?= ($is_my) ? "Fund <span class='label' data-toggle='popover'>?</span>" : "Recieve" ?></button>
            <style type="text/css">
                [type="submit"] .label{
                    font-size:10px;
                    border:1px solid #818588;
                    border-radius:100% !important;
                    color: #818588;
                    z-index: 999999;
                }
                [type="submit"]:hover .label{
                    color:#fff;
                    border-color:#fff;
                }
            </style>
                <script>
                $(document).ready(function(){
                    $('.noselect').bind("cut copy paste",function(e) {
                        e.preventDefault();
                    });
                });

                function clickIE4(){
                    if (event.button==2 || event.button==86){
                        return false;
                    }
                }
                function clickNS4(e){
                    if (document.layers||document.getElementById&&!document.all){
                        if (e.which==2||e.which==3||e.which==86){
                            return false;
                        }
                    }
                }
                if (document.layers){
                    document.captureEvents(Event.MOUSEDOWN);
                    document.onmousedown=clickNS4;
                }
                else if (document.all&&!document.getElementById){
                    document.onmousedown=clickIE4;
                }
                document.oncontextmenu=new Function("return false")
            </script>
        </div>
    </div>
</div>
