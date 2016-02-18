<?php

/**
 * @var frontend\modules\core\base\View $this
 * @var array $messages
 */
use common\modules\core\helpers\UrlHelper;
use common\modules\user\models\Online;

/** @var common\modules\user\Module $userMod */
$userMod = Yii::$app->getModule('user');

$lastMessage = end($messages);
asort($messages);

?>

<?php if (empty($messages)): ?>
    <?= Yii::t('core', 'Нет сообщений') ?>
<?php else: ?>
    <input type="hidden" name="last_message_id" id="last_message_id" value="<?= $lastMessage['id'] ?>">
    <?php foreach ($messages as $message): ?>
        <table class="chat-messages-tbl">
            <tbody>
            <tr>
                <td>
                    <a class="ava-img" href="<?= $this->userUrl($message['user_id']) ?>" style="position: relative">
                        <div class="player_status40 <?= Online::getStatus($message['user_id']) ? 'online' : '' ?>">
                            <i class="circle-block"></i>
                        </div>
                        <img width="40px" height="40px" src="<?= $userMod->getAvatarUrl($message['user_id'], false) ?>">
                    </a>
                </td>
                <td>
                    <a class="user-name"
                       href="<?= $this->userUrl($message['user_id']) ?>">
                        <?= $this->encode($message['username']) ?>
                    </a>

                    <p class="user-title">
                        <?= UrlHelper::clickable($this->encode($message['message'])) ?>
                    </p>

                    <div class="user-date">
                        <div class="date-block">
                            <?= Yii::t('dota', '{0, date, dd.MM.YYYY}', [$message['created_at']]) ?>
                            <span>
                                <?= Yii::t('dota', '{0, date, HH:mm}', [$message['created_at']]) ?>
                            </span>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    <?php endforeach ?>
<?php endif ?>