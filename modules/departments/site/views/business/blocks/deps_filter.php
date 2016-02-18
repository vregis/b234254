<div class="arrow" style="left: 50%;"></div>
<div class="popover-content">
    <div style="">
        <?php foreach($departments as $dep):?>
            <a class="background-<?= $dep['id'] ?> <?= $dep['is_hide'] ? 'off' : 'on' ?>" data-id="<?php echo $dep['id']?>"><?php echo $dep['name']?></a>
        <?php endforeach; ?>
    </div>
</div>
