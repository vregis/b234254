<?
use modules\departments\models\Department;
use yii\helpers\Url;

$this->beginPage();

?>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>BSB</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <?php
    $this->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->getRequest()->csrfParam], 'csrf-param');
    $this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->getRequest()->getCsrfToken()], 'csrf-token');

    require_once Yii::getAlias('@modules').'/core/site/views/layouts/metronic_blank.php';
    $this->registerCssFile("/plugins/bsb-icons/style.css");

    $this->registerCssFile("/css/task.css");
    ?>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/favicon.ico"/>

    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<div class="b-page-wrap">
    <div class="page-container">
        <div class="page-content-wrapper">
            <div class="page-content">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
