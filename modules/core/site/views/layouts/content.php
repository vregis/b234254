<?php

/**
 * @var frontend\modules\core\base\View $this
 * @var string $content
 */

?>

<?= $this->render('//layouts/_partial/_header') ?>

    <!-- CONTAINER -->

    <div class="container">
        <div class="clearfix"></div>

        <!-- Main Content -->
        <div class="main-content-container">

            <div class="main-content960">

                <div class="content-page p70">

                    <?= $this->render('@viewsPath/content/_top_links') ?>

                    <?= $content ?>

                </div>
            </div>
        </div>
        <!-- Content END-->

        <?=
        $this->render(
            '//core/dialog/message',
            [
                'id' => 'system-dialog',
                'title' => Yii::t('mirprost', 'Информация'),
                'message' => '',
                'open' => false
            ]
        ) ?>
        <div class="clearfix"></div>
    </div>
    <!-- CONTAINER END -->

<?= $this->render('//layouts/_partial/_footer') ?>

<?php if (!Yii::$app->user->isGuest) {
    echo $this->render('//layouts/_partial/_chat');
} ?>