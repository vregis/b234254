<?php

//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Url;
//use yii\widgets\Pjax;

/**
 * @var modules\core\site\base\View $this
 */

$this->title = 'Главная страница';

?>
<div class="col-md-12">
    <div class="row">
        <? foreach($tests as $test) : ?>
            <?= $test->name ?> <a href="<?= Url::toRoute(['/tests/start', 'id' => $test->id]) ?>" class="btn btn-primary">Start test</a>
        <? endforeach; ?>
    </div>
    <div class="row">
        <a href="<?= Url::toRoute('/core/main') ?>" class="btn btn-primary">Skip test</a>
    </div>
</div>