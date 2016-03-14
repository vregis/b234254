



<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var frontend\modules\core\base\View $this
 */


$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/registration/confirm-common', 'token' => $key]);

?>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('mail', 'Здравствуйте') ?>
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <? //= Yii::t('mail', 'Спасибо за регистрацию на {0}', [Yii::$app->name]) ?>
    <? //= Yii::t('mail', 'Чтобы завершить регистрацию, нажмите на ссылку ниже') ?>
    To complete your registration, click on the link below:
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
<p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    If you have received this email by error, it might be that the Universe is guiding you to visit <a href="http://bigsbusiness.com">Big S Business</a> ;-)
    <? //= Yii::t('mail', 'Если вы получили это письмо по ошибке, просто удалите его') ?>.
</p>


