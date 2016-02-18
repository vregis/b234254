<?php
use modules\user\models\Online;
use yii\helpers\StringHelper;
use modules\chat\models\Message;


$userMod = Yii::$app->getModule('user');

?>

<!-- ****************** friends ***************************************** -->
              <?php
              if(!empty($model)){
                foreach ($model as $user):
                    $status = Online::getStatus($user->friend_id);
                    ?>
                    <div class="dialog-box-user-list-item" >
                        <div class="dialog-box-main-avatar-block">
                              <div class="num <?php if(Message::getMessagesNotRediedYet($user->friend_id) > 0){echo"active";} ?>"> <?= Message::getMessagesNotRediedYet($user->friend_id) ?> </div>
                            <img src="<?= $userMod->getAvatarUrl($user->friend_id) ?>" width="30" height="30" alt=""/>
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
                        <div class="dialog-box-user-list-name">
                            <span><?= StringHelper::truncate($user->name, 20) ?></span>
                        </div>
                        <div class="dialog-box-user-choosen-block">
                            <i class="dialog-box-icon star dialog-box-onclick-activated"></i>
                        </div>
                        <div class="dialog_box_show dialog-box-show posible-dublicate" data-userid="<?= $user->friend_id ?>" data-user="<?= $user->friend_id ?>">
                        </div>
                    </div>
                    

              <?php endforeach; } ?>
<!-- ****************** friends end ***************************************** -->
        