<?php

use yii\helpers\Url;

?>
<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

    <?php foreach (Yii::$app->getModules(true) as $module): ?>
        <?php if (isset($module->inMenu) && !empty($module->title)): ?>
            <li class="nav-item <?= $this->context->module->id == $module->id ? 'active' : '' ?>">
                <a href="<?= Url::to(['/' . $module->id]) ?>">
                    <i class="fa fa-circle-thin"></i>
                    <?= $module->title ?>
                </a>
            </li>
        <?php endif ?>
    <?php endforeach ?>
</ul>