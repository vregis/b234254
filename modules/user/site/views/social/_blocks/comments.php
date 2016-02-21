<div class="comments">
    <div class="wrapper">
        <?php if($comments):?>
            <?php foreach($comments as $com):?>
                <div class="item">
                    <a target="_blank" href="/user/social/shared-profile?id=<?php echo $com->uid?>"><img src="<?php echo $com->ava != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$com->ava:'/images/avatar/nophoto.png'?>" alt="" width="40" height="40" class="avatar"></a>
                    <div class="name"><?php echo ($com->fn)?$com->fn:''?> <?php echo ($com->ln)?$com->ln:''?> <?php echo (!$com->fn && !$com->ln)?'User':''?></div>
                    <div class="comment"><?php echo $com->text?></div>
                    <div class="time">about 8 hours<?php //echo date('Y-m-d, H:i:s', $com->time)?></div>
                </div>
            <?php endforeach;?>
        <?php endif?>
        <?php if(!isset($index)):?>
            <?php $index = 0;?>
        <?php endif;?>
        <ul class="pagination" style="margin-left: -41.5px;">
            <li class="<?php echo $index == 0?'disabled':''?>">
                <a class="prev-page go-page" data-page-id = '<?php echo $index-1?>'>
                    <i class="fa fa-angle-left"></i>
                </a>
            </li>
            <?php $num = intval($count/5);?>

            <?php if($index < 4):?>
            <?php $start = 0;?>
            <?php elseif($num-$index > 1):?>
            <?php $start = $index - 2;?>
                <?php else:?>
                <?php $start = $num - 4;?>
            <?php endif;?>
            <?php $j = 0;?>
            <?php for ($i = $start; $i<=$num; $i++):?>
            <?php if($j <5):?>
            <li class="<?php echo $index == $i?'active':''?>">
                <a class="go-page" data-page-id="<?php echo $i?>"> <?php echo $i+1?> </a>
            </li>
                <?php endif;?>

                <?php $j++;?>
            <?php endfor;?>

            <li class="<?php echo intval($count/5)==$index?'disabled':''?>">
                <a class="next-page go-page" data-page-id = '<?php echo $index+1?>'>
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>

            <div class="clearfix"></div>
        </ul>
    </div>
    
</div>
