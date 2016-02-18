<?php
use modules\user\models\User;

$userMod = Yii::$app->getModule('user');

?>

<div class="dialog-box-massage inbox">
    <a href="#" class="dialog-box-massage-avatar">

        <img src="<?= $userMod->getAvatarUrl($model['sender_id']) ?>" width="30" height="30" alt=""/>
    </a>
    <div class="massage-info">
        <div class="arrow-left"></div>
        <div class="name"> <?= User::getFullNameById($model['sender_id']) ?> </div>
        <p class="massage"><?= 'Разблокируй пользователя!<a href="javascript:void(0)" onclick="Chat.UnblockUser('.$model['sender_id'].')" >Разблокировать</a>' ?></p>
        <div class="date">
            <?= Yii::t('chat', Time())?>
        </div>
    </div>
    <div class="clearfix">

    </div>
</div>
