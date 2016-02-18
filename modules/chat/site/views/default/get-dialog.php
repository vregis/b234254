<?php

use modules\user\models\User;
use modules\user\models\Profile;

$userMod = Yii::$app->getModule('user');
asort($model);
?>



<?php if(!empty($model)): ?>
    <?php foreach ($model as $dialog): ?>
        <!-- massage item begin -->
        <div class="dialog-box-massage inbox">
            <input class="sender-id" type="hidden" value="<?= $dialog['sender_id'] ?>">
            <a href="#" class="dialog-box-massage-avatar">
                <img src="<?php echo Profile::getUserAvatar($dialog['sender_id']);?>" width="30" height="30" alt=""/>
            </a>
            <div class="massage-info">
                <div class="arrow-left"></div>
                <div class="name"> <?= User::getFullNameById($dialog['sender_id']) ?> </div>
                <p class="massage"><?= $dialog['message'] ?></p>
                <div class="date" data-time="<?= $dialog['created_at'] ?>"><?= $dialog['created_at'] ?></div>
            </div>
            <div class="clearfix">

            </div>
        </div>
        <!-- massage item end -->
    <?php endforeach; ?>
    <?php endif; ?>