<?php

/**
 * @var frontend\modules\core\base\View $this
 * @var string $content
 */

/** @var common\modules\news\models\News $contextModel */
$contextModel = $this->context->model;

/** @var common\modules\news\Module $mod */
$mod = $this->context->module;

?>

<?= $this->render('//layouts/_partial/_header') ?>

    <!-- CONTAINER -->
    <div class="container">

        <!-- Head -->
        <div class="main-head-div">
            <div class="main-head-background">
                <div class="left"></div>
            </div>
            <div class="game-banner-info container960">
                <div class="title-center">
                    <span><?= $this->encode($contextModel->title) ?></span>
                    <img src="<?= $mod->getImageUrl($contextModel->image) ?>" alt="" width="240" height="134">
                </div>
            </div>
        </div>
        <!-- Head END -->

        <!-- Content -->
        <div class="main-content-container">
            <div class="main-content960">
                <div class="tabs-form tabs-form5">
                    <ul class="navigation">
                        <li class="ui-state-default <?= $contextModel->alias == 'o-mirprost' ? 'ui-tabs-active' : '' ?>">
                            <a href="<?= $this->pageUrl('o-mirprost') ?>"><?= Yii::t('mirprost', 'О Mirprost') ?></a>
                            <i class="icon-arrow-red"></i>
                        </li>
                        <li class="ui-state-default <?= $contextModel->alias == 'rukovodstvo' ? 'ui-tabs-active' : '' ?>">
                            <a href="<?= $this->pageUrl('rukovodstvo') ?>"><?= Yii::t('mirprost', 'Руководство') ?></a>
                            <i class="icon-arrow-red"></i>
                        </li>
                        <li class="ui-state-default <?= $contextModel->alias == 'novosti-proekta' ? 'ui-tabs-active' : '' ?>">
                            <a href="<?= $this->pageUrl('novosti-proekta') ?>"><?=
                                Yii::t(
                                    'mirprost',
                                    'Новости проекта'
                                ) ?></a>
                            <i class="icon-arrow-red"></i>
                        </li>
                        <li class="ui-state-default <?= $contextModel->alias == 'vakansii' ? 'ui-tabs-active' : '' ?>">
                            <a href="<?= $this->pageUrl('vakansii') ?>"><?= Yii::t('mirprost', 'Вакансии') ?></a>
                            <i class="icon-arrow-red"></i>
                        </li>
                        <li class="ui-state-default <?= $contextModel->alias == 'kontakty' ? 'ui-tabs-active' : '' ?> ">
                            <a href="<?= $this->pageUrl('kontakty') ?>"><?= Yii::t('mirprost', 'Контакты') ?></a>
                            <i class="icon-arrow-red"></i>
                        </li>
                    </ul>
                </div>

                <?= $content ?>

            </div>
        </div>

    </div>
    <!-- CONTAINER END -->

<?= $this->render('//layouts/_partial/_footer') ?>