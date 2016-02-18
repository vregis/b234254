<?php

use yii\helpers\Url;

/**
 * @var frontend\modules\core\base\View $this
 */

/** @var nodge\eauth\EAuth $eauth */
$eauth = Yii::$app->eauth;
$services = $eauth->services;

?>

<div class="social-vxod">
    <ul class="auth-services-vxod">
        <?php foreach ($services as $id => $service): ?>
            <li>
                <a href="<?= Url::to(['/user/social/login/' . $id]) ?>" title="<?= $this->encode($service->title) ?>">
                    <i class="icon-reg-soc icon-<?= $id ?>">icon</i>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>