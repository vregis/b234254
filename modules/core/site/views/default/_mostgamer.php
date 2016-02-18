<?php

/** @var frontend\modules\user\Module $userMod */
use yii\helpers\StringHelper;
use common\modules\user\models\User;

$userMod = Yii::$app->getModule('user');

?>

<table class="top-gamers-item">
    <tr>
        <th colspan="2">НИК</th>
        <th>ИГР</th>
    </tr>
    <?php if (!$mostGamer){ ?>
        <?php for ($i = 0; $i < 7; $i++): ?>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        <?php endfor; ?>
    <?php }else{ ?>

        <?php $i = 1; ?>
        <?php if(count($mostGamer) > 0){ ?>
        <?php foreach ($mostGamer as $player): ?>
            <tr>
                <td>
                    <?php echo $i;
                    $i++; ?>
                </td>
                <td>
                    <a href="<?= $this->url(['/user/profile/profile', 'id' => $player->user_id]) ?>" class="ava-bl40"
                       title="<?= $this->encode($player->user_id) ?>">
                        <img width="40" height="40" src="<?= $userMod->getAvatarUrl($player->user_id) ?>"
                             class="user_avatar img-banner-img">
                        <?= StringHelper::truncate($this->encode($player->user_id), 14) ?>
                    </a>
                </td>
                <td>
                    <?php echo $player->count_games; ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php } ?>
    <?php } ?>
</table>