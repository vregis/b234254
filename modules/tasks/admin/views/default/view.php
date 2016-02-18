<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;

?>

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="/">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="/admin/tasks"><?= $this->title ?></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#"><?= $task->name ?></a>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">

        <h3><?= $task->name ?></h3>
        <?= $task->description ?>
        <!-- Begin: life time stats -->
        <!-- End: life time stats -->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption tools pull-left">
                    <a href="javascript:;" class="expand">Supporting materials</a>
                </div>
            </div>
            <div class="portlet-body display-hide">
                <? require_once __DIR__ . '/_partial/_sup_materials.php'; ?>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->