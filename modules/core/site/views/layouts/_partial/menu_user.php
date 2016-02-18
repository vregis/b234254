<?php

use common\modules\core\helpers\MoneyHelper;
use common\modules\finance\models\Robokassa;
use frontend\modules\core\widgets\LangSwitcher;
use yii\helpers\Url;

/**
 * @var frontend\modules\core\base\View $this
 */

/** @var frontend\modules\user\Module $userMod */
$userMod = Yii::$app->getModule('user');

//найти модель юзера и по его имени посчитать количество писем
$user_id = Yii::$app->user->id;

$curModId = $this->context->module->id;

/** @var common\modules\user\models\User $identity */
$identity = Yii::$app->user->identity;

?>


<div class="jx-right-topbar">
    <div class="nick left">
        <a href="<?= Url::to(['/user/profile/index']) ?>">
            <img class="user_avatar img-banner-img"
                 src="<?= $userMod->getAvatarUrl(null, true) ?>"
                 width="40" height="40">
            <?= $this->encode($identity->username) ?>
        </a>
    </div>

    <ul class="status right">
        <li><a href="http://www.facebook.com/janxcode"><img src="/images/icon-valuta.png"><span>$0.00</span></a></li>
        <li><a href="http://www.facebook.com/janxcode"><i class="fa fa-bell"></i></a></li>
        <li><a href="http://www.facebook.com/janxcode"><i class="fa fa-facebook"></i></a></li>
        <li><a href="http://www.twitter.com/janxcode"><i class="fa fa-twitter"></i></a></li>
        <li><a href="http://www.googleplus.com/janxcode"><i class="fa fa-google-plus"></i></a></li>
    </ul>
    <!-- Social icons-->
</div>

<!--

<div class="menu">
    <div class="main-menu">
        <?= $this->render('//layouts/_partial/menu_header') ?>
    </div>
</div>
<div class="main-enter">
    <div class="enter-reg-title">
        <div class="enter-ava">
            <a href="<?=
            Url::to(
                ['/user/profile/index']
            ) ?>">
                <img class="user_avatar img-banner-img"
                     src="<?= $userMod->getAvatarUrl(null, true) ?>"
                     width="40" height="40">
                <?= $this->encode($identity->username) ?>
            </a>
        </div>
        <a href="<?= Url::toRoute('/finance/default/history') ?>" class="enter-balance">
            <i class="icon-valuta-dollar"></i>
            <span id="user_current_balance"><?= MoneyHelper::format(Robokassa::getTotalSumm()) ?></span>
        </a>

        <div class="message-bl">

            <div class="message-button btn_active m-system" id="message_alert" href="javascript:void(0);"
                 onclick="ShowSystemAlert(<?= Yii::$app->user->id ?>)">
                <i class="icon-alert"></i>
                <div class="dialog-info center-bl"></div>
            </div>
            <a class="options-button <?= $this->context->module->id == 'user' && $this->context->id == 'settings' ? 'active' : '' ?>"
               href="<?= Url::to(['/user/settings/profile']) ?>">
                <i class="icon-options"></i>
            </a>

            <a href="<?= Url::to(['/user/security/logout']) ?>" class="enter-reg-close"><i class="icon-exit"></i></a>

        </div>

    </div>
</div>




<audio id="beep-one" controls="controls" preload="auto" style="display: none">
    <source src="/audio/button-30.mp3">
    <?= Yii::t('core', 'Ваш браузер не поддерживает элемент "audio"') ?>
</audio>
<audio id="beep-two" controls="controls" preload="auto" style="display: none">
    <source src="/audio/button-20.mp3">
    <?= Yii::t('core', 'Ваш браузер не поддерживает элемент "audio"') ?>
</audio>
<audio id="beep-three" controls="controls" preload="auto" style="display: none">
    <source src="/audio/error1.mp3">
    <?= Yii::t('core', 'Ваш браузер не поддерживает элемент "audio"') ?>
</audio>
<audio id="beep-system" controls="controls" preload="auto" style="display: none">
    <source src="/audio/beep.mp3">
    <?= Yii::t('core', 'Ваш браузер не поддерживает элемент "audio"') ?>
</audio>

-->