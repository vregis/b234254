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

<!-- Content -->
<div class="main-content-container mid-alligned">
        <?= $content ?>
</div>