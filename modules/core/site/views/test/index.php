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
        <a href="<?= Url::toRoute('/user/registration/register') ?>" class="btn btn-primary">Enter</a>
        <a href="<?= Url::toRoute('/user/security/login') ?>" class="btn btn-primary">Sign In</a>
    </div>
</div>