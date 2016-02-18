<?php

use yii\helpers\Url;

/**
 * @var frontend\modules\core\base\View $this
 */

?>

<div class="menu">
    <div class="main-menu">
        <?= $this->render('//layouts/_partial/menu_header') ?>
    </div>
</div>
<div class="main-enter">
    <a href="<?= Url::to(['/user/security/login']) ?>" class="enter-btn"><?= Yii::t('user', 'войти') ?></a>
</div>

<?php return ?>

<!--<div class="translation">
    <div class="tr-bl">
        <a href="<?/*= Url::to('/ru' . $url) */?>"
            <?/*= $currentLang == 'ru' ? 'class="active"' : '' */?>>ru</a></div>
    <div class="tr-bl">
        <a href="<?/*= Url::to('/en' . $url) */?>"
            <?/*= $currentLang == 'en' ? 'class="active"' : '' */?>>en</a></div>
</div>-->