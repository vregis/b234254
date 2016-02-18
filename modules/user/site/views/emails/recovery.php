<?php

use yii\helpers\Html;

/**
 * @var frontend\modules\core\base\View $this
 */

?>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('mail', 'Здравствуйте') ?>,
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('mail', 'Был отправлен запрос на восстановление пароля на {0}', [Yii::$app->name]) ?>.
    <?= Yii::t('mail', 'Чтобы завершить смену пароля, мы должны удостовериться, что именно вы его начали') ?>.
    <?= Yii::t('mail', 'Чтобы восстановить пароль, нажмите на ссылку ниже') ?>.
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Html::a(Html::encode($params['tokenUrl']), $params['tokenUrl']) ?>
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?=
    Yii::t(
        'mail',
        'Если вы не отправляли этот запрос, проигнорируйте это письмо. Ваш аккаунт в безопасности'
    ) ?>.
</p>