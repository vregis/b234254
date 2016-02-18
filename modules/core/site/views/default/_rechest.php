<?php
/** @var frontend\modules\user\Module $userMod */
use yii\helpers\StringHelper;

$userMod = Yii::$app->getModule('user');

/*
<div class="main-info-tab-block rechest-tbl">
        <div class="th row">
            <div class="col">НИК</div>
            <div class="col">ЧИСЛО</div>                
        </div>         
        <?php foreach($reachestMan as $player): ?>
        <div class="row td-bl">
            <div class="col">
                  <img src="<?= $userMod->getAvatarUrl($player->id ) ?>" width="30" height="30" alt=""/>
                <a href="<?= $this->userUrl($player->id)?>" class="a-bl">
                    <?php  echo $player->username; ?>
                </a>                
            </div>    
            <div class="col " >
                <i class="icon-valuta-dollar"></i>
                <?php echo $player->balance; ?> 
            </div>
        </div>    
        <?php endforeach; ?>                    
</div>
*/
?>

<table class="top-gamers-item">
    <tr>
        <th colspan="2">НИК</th>
        <th>MP</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach ($reachestMan as $player): ?>
        <?php if ($player->id != 2) { ?>
            <tr>
                <td>
                    <?php echo $i;
                    $i++; ?>
                </td>
                <td>
                    <a href="<?= $this->url(['/user/profile/profile', 'id' => $player->id]) ?>" class="ava-bl40"
                       title="<?= $this->encode($player->username) ?>">
                        <img width="40" height="40" src="<?= $userMod->getAvatarUrl($player->id) ?>"
                             class="user_avatar img-banner-img">
                        <?= StringHelper::truncate($this->encode($player->username), 14) ?>
                    </a>
                </td>
                <td>
                    <i class="icon-valuta-dollar"></i>
                    <?php echo $player->balance; ?>
                </td>
            </tr>
        <?php } ?>
    <?php endforeach; ?>
</table>