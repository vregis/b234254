<?php
use modules\user\models\User;

$userMod = Yii::$app->getModule('user');
asort($model);
?>


<?php foreach($model as $message): ?>
<?php if($message['sender_id'] == Yii::$app->user->id){ ?>

        <div class="dialog-box-massage outbox" style="opacity: 0.4;">
            <div class="massage-info">
                <div class="arrow-right"></div>
                <p class="massage"><?= $message['message'] ?></p>
                <div class="date" data-time="<?= $message['created_at'] ?>"><?=
            Yii::t(
                    'chat', '{0, date, dd MMMM YYYY HH:mm:ss}', [$message['created_at']]
            )
            ?></div>
            </div>
            <div class="clearfix"></div>
        </div>
     

<?php }else{ ?>

      <div class="dialog-box-massage inbox" style="opacity: 0.4;">
            <a href="#" class="dialog-box-massage-avatar">
             
                <img src="<?= $userMod->getAvatarUrl($message['sender_id']) ?>" width="30" height="30" alt=""/>
            </a>
            <div class="massage-info">
                <div class="arrow-left"></div>
                <div class="name"><?= User::getFullNameById($message['sender_id']); ?></div>
                <p class="massage"><?= $message['message'] ?></p>
                <div class="date" data-time="<?= $message['created_at'] ?>"><?=
            Yii::t(
                    'chat', '{0, date, dd MMMM YYYY HH:mm:ss}', [$message['created_at']]
            )
            ?></div>
            </div>
            <div class="clearfix"></div>
        </div>

<?php } ?>

      
      
        
<?php endforeach; ?>
  


 