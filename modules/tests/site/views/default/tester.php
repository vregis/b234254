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
        Придупреждение!!! эту страницу видят только тестировщики!!!
        Тест пройден
        <br>
        <div class="btn-wrap sm inline-block"><a href="<?= Url::toRoute('/tests/clear')?>" class="btn btn-cust">Clear</a></div>
        <div class="btn-wrap sm inline-block"><a href="<?= Url::toRoute('/tests/result')?>" class="btn btn-cust">Result</a></div>
        <div class="btn-wrap sm inline-block"><a href="<?= Url::toRoute('/departments')?>" class="btn btn-cust">Skip</a></div>
    </div>
</div>