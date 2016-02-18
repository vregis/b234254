<?php

/**
 * @var frontend\modules\core\base\View $this
 * @var string $content
 */
?>

<?php
/**
 * Шаблон для страниц с заголовком на фоне картинки
 *
 * Использование:
 *
 *      <?php $this->beginContent('//layouts/main_page', [
 *          'title' => Yii::t('user', 'Завершение регистрации')
 *      ]) ?>
 *
 *          ... контент ...
 *
 *      <?php $this->endContent() ?>
 *
 */
?>

<?php
$title = $this->encode($title);
$this->title = $title;
//$this->context->breadcrumbs = [$title];
?>

<!-- Head -->
<div class="main-head-div">
    <div class="main-head-background">
        <div class="left"></div>
    </div>
    <div class="game-banner-info container960">
        <div class="title-center">
            <span><?= $title ?></span>
            <img src="/image/banner-head960x134.jpg" alt="" width="240px" height="134px"/>
        </div>
    </div>
</div>
<!-- Head END -->
<!-- Content -->
<div class="main-content-container">
    <div class="main-content960">
        <div class="divider28px"></div>

        <?= $content ?>

    </div>
</div>