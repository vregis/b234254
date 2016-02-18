<?php

//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Url;
//use yii\widgets\Pjax;

/**
 * @var modules\core\site\base\View $this
 */

$this->title = 'Start test';

$this->registerJsFile("/metronic/assets/admin/pages/scripts/components-dropdowns.js");

?>
<div class="col-md-12">
    <div class="row">
        This page start test<br>
        <div class="btn-wrap sm inline-block"><a href="<?= Url::toRoute('/tests/progress')?>" class="btn btn-cust">Start</a></div>
    </div>
</div>