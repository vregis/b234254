<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 11.01.2016
 * Time: 15:19
 */
?>

<? foreach($taskUserNotes as $taskUserNote) : ?>
    <li>
        <?= $taskUserNote->note ?>
        <!-- <a class="btn-edit-note" data-id="<?= $taskUserNote->id ?>" data-note="<?= $taskUserNote->note ?>"><i class="fa fa-edit font-green"></i></a> -->
        <!-- <a class="btn-remove-note" data-id="<?= $taskUserNote->id ?>" data-note="<?= $taskUserNote->note ?>"><i class="fa fa-remove font-red"></i></a> -->
    </li>
<? endforeach; ?>
