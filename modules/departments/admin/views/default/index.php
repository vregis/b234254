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


<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                Widget settings form goes here
            </div>
            <div class="modal-footer">
                <button type="button" class="btn blue">Save changes</button>
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="/admin">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#"><?=$this->title?></a>
        </li>
    </ul>
</div>
<h3 class="page-title">
    <?=$this->title?>
</h3>
<!-- END PAGE HEADER-->
<!-- BEGIN DASHBOARD STATS -->
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <? foreach($departments as $department) : ?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat departments-<?= $department->icons ?>">
                        <div class="visual">
                            <i class="ico-<?= $department->icons ?>"></i>
                        </div>
                        <div class="details">
                            <div class="desc">
                                <?= $department->name ?>
                            </div>
                            <div class="option">
                                <a class="departments-button" href="<?= Url::toRoute(['/departments/view', 'id' => $department->id])?>">
                                    <div class="name">
                                        Specializations
                                    </div>
                                    <div class="number">
                                        <?= $specializations_counts[$department->id] ?>
                                    </div>
                                </a>
                                <a class="departments-button" href="<?= Url::toRoute(['/departments/view', 'id' => $department->id])?>">
                                    <div class="name">
                                        Tasks
                                    </div>
                                    <div class="number">
                                        <?= $tasks_counts[$department->id] ?>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <a class="more" href="<?= Url::toRoute(['/departments/update', 'id' => $department->id])?>">
                            Edit <i class="fa fa-edit"></i>
                        </a>
                    </div>
                </div>
            <? endforeach; ?>
        </div>

        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    Additional departments
                </div>
                <div class="actions">
                    <a href="<?= Url::toRoute('/departments/create')?>" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New department </span>
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
                                Tasks
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach($additional_departments as $additional_department) : ?>
                            <tr>
                                <td class="highlight">
                                    <a href="<?= Url::toRoute(['/departments/view', 'id' => $additional_department->id])?>"><i class="ico-<?= $additional_department->icons ?>"></i> <?= $additional_department->name ?></a>
                                </td>
                                <td class="highlight">
                                    <?= $tasks_counts[$additional_department->id] ?>
                                </td>
                                <td width="25%">
                                    <a href="<?= Url::toRoute(['/departments/update', 'id' => $additional_department->id])?>" class="btn default btn-xs purple">
                                        <i class="fa fa-edit"></i> Edit </a>
                                    <a href="<?= Url::toRoute(['/departments/view', 'id' => $additional_department->id])?>" class="btn default btn-xs green-stripe">
                                        View </a>
                                    <a href="<?= Url::toRoute(['/departments/delete', 'id' => $additional_department->id])?>" class="btn btn-danger btn-xs black">
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
<!-- END DASHBOARD STATS -->
