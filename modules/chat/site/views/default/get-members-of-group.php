<?php

use modules\user\models\Online;
use modules\chat\models\Group;
use modules\user\models\Profile;

/** @var frontend\modules\user\Module $userMod */
$userMod = Yii::$app->getModule('user');
?>
  <input id="group_id" type="hidden" value="<?= $id ?>">
  <div class="background-bl"></div>
<?php foreach ($model as $member): ?>

        <?php $status = Online::getStatus($member->member_id); ?>
      
        <div class="dialog-box-user-list-item ui-draggable ui-draggable-handle" style="position: relative; width: 30px; height: 30px;">
            <div class="dialog-box-main-avatar-block">
                <div class="num num-1 ">0 </div>

                <img src="<?= Profile::getUserAvatar($member->member_id) ?>" width="30" height="30" alt=""/>
                <div class="dialog-box-user-status">
                    <div class="<?php
                    if ($status == true) {
                        echo 'online';
                    } else {
                        echo'offline';
                    }
                    ?>"></div>
                </div>
            </div>
            <div class="dialog_box_show dialog-box-show posible-dublicate" data-userid="<?= $member->member_id ?>" data-user="<?= $member->member_id ?>">
            </div>
                <?php if( Group::Is_my($id) == true){ ?>
                    <!--<div onclick="Chat.DeleteMemberFromGrop(<? //= $member->member_id ?>, $(this))" class="active-bl">
                        <!--<i class="dialog-box-icon cansel">icon</i>-->
                    <!--</div>-->
                <?php }else{ ?>
                        <?php if($member->member_id == Yii::$app->user->id):?>
                   <!-- <div onclick="Chat.DeleteMemberFromGrop(<? //= $member->member_id ?>, $(this))" class="active-bl">
                        <i class="dialog-box-icon cansel">icon</i>
                    </div>-->
                <?php endif; ?>
               <?php } ?>    
        </div>
  
<?php endforeach; ?>