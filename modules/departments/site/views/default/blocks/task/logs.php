<? foreach($taskUserLogs as $taskUserLog) : ?>
    <? $oDate = new DateTime($taskUserLog->date); ?>
    <li><?= $oDate->format("m/d/Y") ?> <br>
        <?= $taskUserLog->log ?>
    </li>
<? endforeach; ?>