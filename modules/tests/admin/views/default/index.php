<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = $this->context->module->title;
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile("/metronic/assets/global/scripts/datatable.js");
$this->registerJsFile("/metronic/assets/admin/pages/scripts/table-ajax.js");

$msgJs = <<<JS
    TableAjax.init();
JS;
$this->registerJs($msgJs);
?>

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?= Url::toRoute('/')?>">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#"><?=$this->title?></a>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <?=$this->title?>
                </div>
                <div class="actions">
                    <a href="<?= Url::toRoute('/tests/create')?>" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New test </span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th>
                                <i class="fa fa-tasks"></i> Name
                            </th>
                            <th>
                                <i class="fa fa-file-o"></i> Start Page
                            </th>
                            <th>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach($tests as $test) : ?>
                            <tr>
                                <td class="highlight">
                                    <a href="<?= Url::toRoute(['/tests/view', 'id' => $test->id])?>"><?= $test->name ?></a>
                                </td>
                                <td width="35%">
                                    <a href="<?= $test->start_page ?>" onclick="return !window.open(this.href)"><?= $test->start_page ?></a>
                                </td>
                                <td width="25%">
                                    <a href="<?= Url::toRoute(['/tests/update', 'id' => $test->id])?>" class="btn default btn-xs purple">
                                        <i class="fa fa-edit"></i> Edit </a>
                                    <a href="<?= Url::toRoute(['/tests/view', 'id' => $test->id])?>" class="btn default btn-xs green-stripe">
                                        View </a>
                                    <a href="<?= Url::toRoute(['/tests/delete', 'id' => $test->id])?>" class="btn btn-danger btn-xs black">
                                        <i class="fa fa-trash-o"></i> Delete </a>
                                </td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>
<!-- END PAGE CONTENT-->