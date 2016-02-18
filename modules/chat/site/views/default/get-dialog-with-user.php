<?php

use modules\user\models\User;
use modules\chat\models\Friend;

$userMod = Yii::$app->getModule('user');
asort($model);
?>

<!-- dialog selector arrow begin -->
<div class="dialog-selector-arrow">
    <div>

    </div>
</div>

<div class="dialog-main-general-massage-box-title">
    <input class="user-id" type="hidden" value="<?= $id ?> ">
    <a href="<?= $id ?>">
        <div>
            <img src="<?= $id ?>" width="30" height="30" alt=""/>
            <div class="dialog-box-user-status">
                <div class="<?php
                if ($status == true) {
                    echo"online";
                } else {
                    echo"offline";
                }
                ?>">

                </div>
            </div>
        </div>
        <div>
            <?= User::getFullNameById($id) ?>
        </div>
    </a> 
    <button  onclick="hide_dialog_chat(<?= $id ?>)" type="button">
        <i class="dialog-box-icon close"></i>
    </button>
</div>


<?php if($IsFiendOfMine == true){ ?>

<div class="dialog-massage-add-users">
    <div class="title-bl">Пользователя нет в вашем <br> списке контактов</div>
    <div class="btn-bl">
        <?php if( Friend::IsKillDialog($id)== true){ ?>
             <button onclick="Chat.AddUserToFriend(<?= $id ?>)" class="button-add-user" type="button">Востановить</button>  
        <?php }else{ ?>
             <button onclick="Chat.AddUserToFriend(<?= $id ?>)" class="button-add-user" type="button">Добавить</button>
        <?php } ?>
       
        <button onclick="Chat.HideGrayArea($(this))" class="button-add-no-user" type="button">нет</button>
    </div>
</div>

<?php } ?>



<div  class="dialog-massage-history-block">
    <!-- add user on chat -->

<?php if(!empty($model)): ?>
    <?php foreach ($model as $dialog): ?>
  
   
        <!-- massage item begin -->
        <div class="dialog-box-massage inbox">
            <input class="sender-id" type="hidden" value="<?= $dialog['sender_id'] ?>"> 
            <a href="#" class="dialog-box-massage-avatar">

                <img src="<?= $userMod->getAvatarUrl($dialog['sender_id']) ?>" width="30" height="30" alt=""/>
            </a>
            <div class="massage-info">
                <div class="arrow-left"></div>
                <div class="name"> <?= User::getFullNameById($dialog['sender_id']) ?> </div>
                <p class="massage"><?= $dialog['message'] ?></p>
                <div class="date" data-time="<?= $dialog['created_at'] ?>"><?=
                    Yii::t(
                            'chat', '{0, date, dd MMMM YYYY HH:mm:ss}', [$dialog['created_at']]
                    )
                    ?></div>
            </div>
            <div class="clearfix">

            </div>
        </div>
        <!-- massage item end -->
    <?php endforeach; ?>
    <?php endif; ?>


    <!-- massage item begin -->
 <!--   <div class="dialog-box-massage inbox">
        <a href="#" class="dialog-box-massage-avatar">
            <img alt="ava" src="images/dodik.jpg">
        </a>
        <div class="massage-info">
            <div class="arrow-left"></div>
            <div class="name">Лёша Долматов</div>
            <p class="massage">Всем привет с вами снова я и я и я и мои друзья</p>

            <div class="massage-photo-content-block">
                <img src="images/imaga.jpg">
                <img src="images/imaga.jpg">
                <img src="images/imaga.jpg">
                <img src="images/imaga.jpg">
                <div class="clearfix"></div>
            </div>

            <div class="date">04.11.2014</div>
        </div>
        <div class="clearfix"></div>
    </div> -->
    <!-- massage item end -->





</div>
<!-- massage history block end -->

<!-- massage typing block begin -->
<div class="dialog-massage-typing-block">
    <form>
        <?php 
        $warning = 'Ваше сообщение...';
        $warningLink = "Вы не можете отправлять сообщения!";
        ?>
        <button class="dialog-adding-photo-btn" type="button"></button>
        <textarea id="message-area" placeholder="<?php if($IsBloked == true){echo $warningLink; }else{ echo $warning;}?>" name="message"></textarea>
        <button class="wide"><i class="dialog-box-icon wide"></i></button>
        <button class="send" type="button" onclick="Chat.sendMessageToUser(<?= $id ?>)">ок</button>


    </form>
</div>
<!-- massage typing block end -->

<!-- user dialog actions begin -->

<table class="dialog-massage-actions-block">
    <tr>
        <?php if($IsBloked == true): ?>
        <td>
            <button type="button" onclick="Chat.UnblockUser(<?= $id ?>)">Разблокировать</button>
        </td>
        <?php endif; ?>
        
        <?php if($IsBloked == false): ?>
        <td>
            <button type="button" onclick="Chat.blockUser(<?= $id ?>)">Блокировать</button>
        </td>
        <?php endif; ?>
        
        <td>
            <button type="button" onclick="Chat.deleteDialogToUser(<?= $id ?>)">Удалить диалог</button>
        </td>
    </tr>
</table>
<!-- user dialog actions end -->
