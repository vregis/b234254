<? foreach($taskUserLogs as $taskUserLog) : ?>
    <? $oDate = new DateTime($taskUserLog->date); ?>
    <li style="font-size:14px;"><span><?= $oDate->format("m/d/Y") ?></span> <br>
        <span style="font-size:12px;"><strong><?= $taskUserLog->log ?></strong></span>
    </li>
<? endforeach; ?>