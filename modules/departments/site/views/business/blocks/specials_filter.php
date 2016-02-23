<div class="arrow" style="left: 50%;"></div>
<div class="popover-content">
    <div style="">
        <?php foreach($user_specials as $special):?>
            <?php if(isset($dep_idd)):?>
                <?php if($dep_idd == $special->dep_id):?>
                    <?php $special->spec_hide = null; ?>
                <?php endif;?>
            <?php endif;?>
            <a class="background-<?= $special->dep_id ?>  <?= $special->spec_hide ? 'off' : 'on' ?>" data-id="<?php echo $special->id ?>"><?php echo $special->name?></a>
        <?php endforeach; ?>
    </div>
</div>
