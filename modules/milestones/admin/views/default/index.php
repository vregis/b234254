<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 */


$this->title = $this->context->module->title;
$this->params['breadcrumbs'][] = $this->title;

?>

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?= Url::toRoute(['/']) ?>">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <?=$this->title?>
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
                    <a href="<?= Url::toRoute(['/milestones/create'])?>" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New milestone </span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th width="7%">
                                <i class="fa fa-sort-numeric-asc"></i> Number
                            </th>
                            <th>
                                <i class="fa fa-tasks"></i> Name
                            </th>
                            <th>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? $number = 1; ?>
                        <? foreach($milestones as $milestone) : ?>
                            <tr>
                                <td>
                                    <?= $number ?>
                                </td>
                                <td class="highlight">
                                    <a href="<?= Url::toRoute(['/milestones/view', 'id' => $milestone->id])?>"><?= $milestone->name ?></a>
                                </td>
                                <td width="25%">
                                    <a href="<?= Url::toRoute(['/milestones/update', 'id' => $milestone->id])?>" class="btn default btn-xs purple">
                                        <i class="fa fa-edit"></i> Edit </a>
                                    <a href="<?= Url::toRoute(['/milestones/view', 'id' => $milestone->id])?>" class="btn default btn-xs green-stripe">
                                        View </a>
                                    <a href="<?= Url::toRoute(['/milestones/delete', 'id' => $milestone->id])?>" class="btn btn-danger btn-xs black">
                                        <i class="fa fa-trash-o"></i> Delete </a>
                                </td>
                            </tr>
                            <? $number++; ?>
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