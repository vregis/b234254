<?php

use modules\user\models\User;
use yii\bootstrap\Alert;
use yii\helpers\Url;

/**
 * @var User $lastUsers
 */

$this->title = 'Core scenarios';

$this->params['breadcrumbs'][] = 'Главная страница';

?>

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
                    <a href="<?= Url::toRoute('/core/create')?>" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New scenario </span>
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
                                <i class="fa fa-cubes"></i> Controller
                            </th>
                            <th>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach($scenarios as $scenario) : ?>
                            <tr <? if($scenario->is_active) : ?> style="background-color: #DAFDD9" <? endif; ?>>
                                <td class="highlight">
                                    <a href="<?= Url::toRoute(['/core/update', 'id' => $scenario->id])?>"><?= $scenario->name ?></a>
                                </td>
                                <td width="25%">
                                    <a href="<?= Url::toRoute(['/core/update', 'id' => $scenario->id])?>"><?= $scenario->controller ?></a>
                                </td>
                                <td width="25%">
                                    <a href="<?= Url::toRoute(['/core/update', 'id' => $scenario->id])?>" class="btn default btn-xs purple">
                                        <i class="fa fa-edit"></i> Edit </a>
                                    <a href="<?= Url::toRoute(['/core/delete', 'id' => $scenario->id])?>" class="btn btn-danger btn-xs black">
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