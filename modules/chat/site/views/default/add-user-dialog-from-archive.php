<?php
use modules\user\models\User;

$userMod = Yii::$app->getModule('user');

?>

<?php if(!empty($model)): ?>
    <?php foreach ($model as $dialog): ?>
   
        <!-- massage item begin -->
        <div class="dialog-box-massage inbox" style="opacity: 0.4;" >
            <input class="sender-id" type="hidden" value="<?= $dialog['sender_id'] ?>"> 
            <a href="#" class="dialog-box-massage-avatar">

                <img src="<?= $userMod->getAvatarUrl($dialog['sender_id']) ?>" width="30" height="30" alt=""/>
            </a>
            <div class="massage-info" >
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
