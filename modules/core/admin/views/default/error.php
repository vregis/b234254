<?php

/**
 * @var backend\modules\core\base\View $this
 */

$this->title = $name;
?>
<div class="site-error">
    <h1><?= $this->title ?></h1>

    <div class="alert alert-danger">
        <?= nl2br($message) ?>
    </div>
</div>