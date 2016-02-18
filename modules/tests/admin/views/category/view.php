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
            <a href="<?= Url::toRoute(['/'.$this->context->module->id.'/view', 'id' => $test->id])?>"><?= $test->name ?></a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#"><?= $test_category->name ?></a>
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
                    <?=$test_category->name?>
                </div>
                <div class="actions">
                    <a href="<?= Url::toRoute(['/tests/question/create', 'id' => $test_category->id])?>" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New question </span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-advance table-hover">
                        <thead>
                        <tr>
                            <th>
                                <i class="fa fa-tasks"></i> Questions
                            </th>
                            <th>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach($test_questions as $test_question) : ?>
                            <tr>
                                <td class="highlight">
                                    <a href="<?= Url::toRoute(['/tests/question/update', 'id' => $test_question->id])?>"><?= $test_question->name ?></a>
                                </td>
                                <td width="25%">
                                    <a href="<?= Url::toRoute(['/tests/question/update', 'id' => $test_question->id])?>" class="btn default btn-xs purple">
                                        <i class="fa fa-edit"></i> Edit </a>
                                    <a href="<?= Url::toRoute(['/tests/question/delete', 'id' => $test_question->id])?>" class="btn btn-danger btn-xs black">
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