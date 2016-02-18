<?php

//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Url;
//use yii\widgets\Pjax;

/**
 * @var modules\core\site\base\View $this
 */

$this->title = 'Finish';

?>

<div class="page-container">
    <div class="page-content">
        <div class="col-md-12">
            <div class="row">
                Придупреждение!!! эту страницу видят только тестировщики!!!
                Опросник завершен
                <br>
                <a href="<?= Url::toRoute('/departments/questionary/clear')?>" class="btn btn-primary">Clear</a>
                <a href="<?= Url::toRoute('/core/main')?>" class="btn btn-primary">Skip</a>
            </div>
        </div>
    </div>
</div>