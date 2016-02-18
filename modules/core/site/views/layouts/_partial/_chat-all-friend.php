<?php

use common\modules\chat\models\Friend;
use yii\helpers\StringHelper;
use common\modules\user\models\Online;
use common\modules\chat\models\Message;
use common\modules\user\models\User;

/** @var frontend\modules\user\Module $userMod */
$userMod = Yii::$app->getModule('user');

$friend_model = Friend::getModelByUserId(Yii::$app->user->id);
//$all_model = Message::getallDialogs();
$is_Visible = Friend::getVisible(Yii::$app->user->id);
?>

<?php
/*
foreach ($all_model as $friend):
    if( Friend::IsKillDialog($friend->sender_id) != true): 
    $status = Online::getStatus($friend->sender_id);
    ?>
    <div class="dialog-box-user-list-item" >
        <div class="dialog-box-main-avatar-block">
            <div class="num num-<?= $friend->sender_id ?> <?php
            if (Message::getMessagesNotRediedYet($friend->sender_id) > 0) {
                echo"active";
            }
            ?>"><?= Message::getMessagesNotRediedYet($friend->sender_id) ?> </div>
            <img src="<?= $userMod->getAvatarUrl($friend->sender_id) ?>" width="30" height="30" alt=""/>
            <div class="dialog-box-user-status">
                <div class="<?php
                if ($status == true) {
                    echo 'online on';
                } else {
                    echo'offline off';
                }
                ?>"></div>
            </div>
        </div>
        <div class="dialog-box-user-list-name">
            <span><?= StringHelper::truncate(User::getFullNameById($friend->sender_id), 20) ?></span>
        </div>
        <div class="dialog-box-user-choosen-block">
            <i class="dialog-box-icon star <?= Friend::getFavorit($friend->sender_id); ?>" onclick="Chat.star($(this))"></i> 
        </div>
        <div class="dialog_box_show dialog-box-show posible-dublicate" data-userid="<?= $friend->sender_id ?>" data-user="<?= $friend->sender_id ?>">
        </div>
    </div>
    <?php endif;
    endforeach;
 */   
foreach ($friend_model as $friend):
    if( Friend::IsKillDialog($friend->friend_id) != true): 
    $status = Online::getStatus($friend->friend_id);
    ?>
    <div class="dialog-box-user-list-item" >
        <div class="dialog-box-main-avatar-block">
            <div class="num num-<?= $friend->friend_id ?> <?php
            if (Message::getMessagesNotRediedYet($friend->friend_id) > 0) {
                echo"active";
            }
            ?>"><?= Message::getMessagesNotRediedYet($friend->friend_id) ?> </div>
            <img src="<?= $userMod->getAvatarUrl($friend->friend_id) ?>" width="30" height="30" alt=""/>
            <div class="dialog-box-user-status">
                <div class="<?php
                if ($status == true) {
                    echo 'online on';
                } else {
                    echo'offline off';
                }
                ?>"></div>
            </div>
        </div>
        <div class="dialog-box-user-list-name">
            <span><?= StringHelper::truncate(User::getFullNameById($friend->friend_id), 20) ?></span>
        </div>
        <div class="dialog-box-user-choosen-block">
            <i class="dialog-box-icon star dialog-box-onclick-activated <?= Friend::getFavorit($friend->friend_id); ?>" onclick="Chat.star($(this))"></i> 
        </div>
        <div class="dialog_box_show dialog-box-show posible-dublicate" data-userid="<?= $friend->friend_id ?>" data-user="<?= $friend->friend_id ?>">
        </div>
    </div>
<?php endif;
endforeach; ?>