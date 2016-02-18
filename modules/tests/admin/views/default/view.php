<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Tests';
$this->params['breadcrumbs'][] = $this->title;

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
            <a href="<?= Url::toRoute('/'.$this->context->module->id)?>"><?= $this->title ?></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#"><?= $test->name ?></a>
        </li>
    </ul>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <?=$test->name?>
                </div>
                <div class="actions">
                    <a href="<?= Url::toRoute(['/tests/category/create', 'id' => $test->id])?>" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New category </span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th>
                                <i class="fa fa-tasks"></i> Categories
                            </th>
                            <th>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach($test_categories as $test_category) : ?>
                            <tr>
                                <td class="highlight">
                                    <a href="<?= Url::toRoute(['/tests/category/view', 'id' => $test_category->id])?>"><?= $test_category->name ?></a>
                                </td>
                                <td width="25%">
                                    <a href="<?= Url::toRoute(['/tests/category/update', 'id' => $test_category->id])?>" class="btn default btn-xs purple">
                                        <i class="fa fa-edit"></i> Edit </a>
                                    <a href="<?= Url::toRoute(['/tests/category/view', 'id' => $test_category->id])?>" class="btn default btn-xs green-stripe">
                                        View </a>
                                    <a href="<?= Url::toRoute(['/tests/category/delete', 'id' => $test_category->id])?>" class="btn btn-danger btn-xs black">
                                        <i class="fa fa-trash-o"></i> Delete </a>
                                </td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="portlet">
            <div class="portlet-title">
                <div class="actions">
                    <a href="<?= Url::toRoute(['/tests/result/create', 'id' => $test->id])?>" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New result </span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th>
                                <i class="fa fa-tasks"></i> Results
                            </th>
                            <th>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach($test_results as $test_result) : ?>
                            <tr>
                                <td class="highlight">
                                    <a href="<?= Url::toRoute(['/tests/result/update', 'id' => $test_result->id])?>"><?= $test_result->name ?></a>
                                </td>
                                <td width="25%">
                                    <a href="<?= Url::toRoute(['/tests/result/update', 'id' => $test_result->id])?>" class="btn default btn-xs purple">
                                        <i class="fa fa-edit"></i> Edit </a>
                                    <a href="<?= Url::toRoute(['/tests/result/delete', 'id' => $test_result->id])?>" class="btn btn-danger btn-xs black">
                                        <i class="fa fa-trash-o"></i> Delete </a>
                                </td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="portlet">
            <div class="portlet-title">
                <div class="actions">
                    <a href="<?= Url::toRoute(['/tests/option/create', 'id' => $test->id])?>" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New option </span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th>
                                <i class="fa fa-tasks"></i> Options
                            </th>
                            <th>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach($test_options as $test_option) : ?>
                            <tr>
                                <td class="highlight">
                                    <a href="<?= Url::toRoute(['/tests/option/update', 'id' => $test_option->id])?>"><?= $test_option->name ?></a>
                                </td>
                                <td width="25%">
                                    <a href="<?= Url::toRoute(['/tests/option/update', 'id' => $test_option->id])?>" class="btn default btn-xs purple">
                                        <i class="fa fa-edit"></i> Edit </a>
                                    <a href="<?= Url::toRoute(['/tests/option/delete', 'id' => $test_option->id])?>" class="btn btn-danger btn-xs black">
                                        <i class="fa fa-trash-o"></i> Delete </a>
                                </td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT-->