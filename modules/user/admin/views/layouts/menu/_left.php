<?php

use yii\helpers\Url;

?>

<ul id="menu" class="dker">

    <li class="nav-header"><?= Yii::t('core', 'Модули') ?></li>

    <li class="nav-divider"></li>

    <?php foreach (Yii::$app->getModules(true) as $module): ?>    
        <?php if (isset($module->inMenu) && !empty($module->title)): ?>    
            <li class="<?= $this->context->module->id == $module->id ? 'active' : '' ?>">
                <a href="<?= Url::to(['/' . $module->id . '/default/index']) ?>">
                    <i class="fa fa-<?= isset($module->icon) ? $module->icon : 'code' ?>"></i>
                    <span class="link-title"><?= $this->encode($module->title) ?></span>
                </a>
            </li>
        <?php endif ?>
    <?php endforeach ?>

</ul>