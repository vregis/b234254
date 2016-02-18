<?php

//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Url;
//use yii\widgets\Pjax;
use yii\web\View;

/**
 * @var modules\core\site\base\View $this
 */

$this->registerJsFile("/js/min/underscore-min.js");


$initJs = <<<JS
    function show_specializations()
    {
         $('#specializations').removeAttr('hidden');
         $('#department').attr('hidden', '1');
         updateData();
         setTimeout(function() { updateData(); }, 200);
    }
JS;
$this->registerJs($initJs,View::POS_HEAD);

if($department->icons != 'idea') {
    $this->registerJsFile("/js/global/departments_questionary.js");
}

$this->title = 'Progress questionary';

?>

<? require_once __DIR__ . '/_partial/_header.php'; ?>
<div class="page-container">
    <div class="page-content-wrapper  page-content-<?= $department->name ?>">
        <div class="page-content">
            <div class="row">

                <? if($step < count($departments)) : ?>
                    <div class="col-md-12">

                        <form method="post" action="<?= Url::toRoute('/departments/questionary/next') ?>">
                            <input type="text" name="_csrf" value="<?= Yii::$app->getRequest()->getCsrfToken() ?>" hidden>
                            <input type="text" name="step" value="<?= $step ?>" hidden>
                            <input type="text" name="open_step" value="<?= $open_step ?>" hidden>
                            <div id="department">
                                <div class="col-md-8 col-lg-9 department block-depart-<?= $department->id ?>">
                                    <h3 class="block-depart-head"><?= $department->name ?></h3>
                                    <div class="depart-head-icon">
                                    </div>
                                    <div class="depart-head-line">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3 department-action visible-md visible-lg">
                                    <div class="pull-right">
                                        <? if($step == $open_step) : ?>
                                            <a href="<?= Url::toRoute('/departments/questionary/next') ?>" class="btn btn-lg green">Skip</a>
                                        <? else: ?>
                                            <a href="<?= Url::toRoute(['/departments/questionary/next', 'step' => $open_step]) ?>" class="btn btn-lg green">Skip</a>
                                        <? endif; ?>
                                        <a class="btn btn-primary btn-lg" onclick="show_specializations()">Select</a>
                                    </div>
                                </div>
                                <div class="col-md-12 department">
                                    <?= $department->description ?>
                                </div>
                                <div class="col-md-4 col-lg-3 department-action department-action-down visible-xs visible-sm">
                                    <div class="pull-right">
                                        <? if($step == $open_step) : ?>
                                            <a href="<?= Url::toRoute('/departments/questionary/next') ?>" class="btn btn-lg green">Skip</a>
                                        <? else: ?>
                                            <a href="<?= Url::toRoute(['/departments/questionary/next', 'step' => $open_step]) ?>" class="btn btn-lg green">Skip</a>
                                        <? endif; ?>
                                        <a class="btn btn-primary btn-lg" onclick="show_specializations()">Select</a>
                                    </div>
                                </div>
                            </div>
                            <!--                     <img class="img-responsive" src="/images/departments/depart-bg-strategy.png" alt="">-->
                            <div class="col-md-12" id="specializations" hidden>

                                <div class="table-scrollable">
                                    <table class="table table-hover table-specializations">
                                        <thead>
                                        <tr>
                                            <th>
                                                <div class="dropdown rate-info">
                                                    Specializations<a style="font-size: 20px">
                                                    </a>
                                                </div>
                                            </th>
                                            <th width=30% class="market-col">
                                                <div class="dropdown rate-info">
                                                    Market rate/h&nbsp;<a class="font-blue-steel no-decoretion" id="dLabel" data-target="#" data-toggle="dropdown" role="menu" style="margin-right: 13px; text-decoration: none; font-size: 20px">
                                                        <i class="fa fa-question-circle"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel">
                                                        This is an amount per hour that you could either charge to perform a service or pay to delegate it
                                                    </ul>
                                                </div>
                                            </th>
                                            <th class="select-col">
                                                <div class="dropdown select-info font-blue-steel pull-right" style="margin-right: 13px; text-decoration: none; font-size: 20px">
                                                    <a class=" no-decoretion" id="dLabel" data-target="#" data-toggle="dropdown" role="menu">
                                                        <i class="fa fa-question-circle"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel">
                                                        Select if you want to do this either for your own or another business
                                                    </ul>
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <? $i=0; ?>
                                        <? foreach($specializations as $specialization) : ?>
                                            <tr>
                                                <td class="table-td-specialization">
                                                    <span><?= $specialization->name ?></span>
                                                    <div class="dropdown more-info font-blue-steel pull-right">
                                                        <a class=" no-decoretion" id="dLabel" data-target="#" data-toggle="dropdown" role="menu">
                                                            more info
                                                        </a>

                                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel">
                                                            <?= $specialization->description ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="table-td-market"> <?= $specialization->market_rate_min ?>$-<?= $specialization->market_rate_max ?>$ </td>
                                                <td class="table-td-select">
                                                    <div class="specialization-action pull-right">
                                                        <div class="md-checkbox pull-right">
                                                            <input type="checkbox" id="checkbox<?= $specialization->id ?>" name="QuestionaryProgress[<?= $i ?>]"
                                                                   class="md-check" <? if($user_specializations[$i]) : ?>checked<? endif; ?>>
                                                            <label for="checkbox<?= $specialization->id ?>">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="collapse-<?= $specialization->id ?>" class="panel-collapse collapse" style="background-color: rgba(238, 241, 245, 0.4)">
                                                <td colspan="5">
                                                    <div class="panel-body">
                                                        <?= $specialization->description ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <? $i++; ?>
                                        <? endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="pull-right" style="display: inline-block; position: relative;right: 0; top: 0">
                                    <? if($departments[0]->id != $department->id): ?>
                                        <a href="<?= Url::toRoute(['/departments/questionary/progress', 'step' => $step - 1]) ?>" class="btn green btn-lg">Back</a>
                                    <? endif; ?>
                                    <button type="submit" class="btn btn-primary btn-lg">Next</button>
                                </div>

                            </div>
                        </form>
                    </div>
                <? else: ?>
                    <? require_once __DIR__ . '/_partial/_idea.php'; ?>
                <? endif; ?>
            </div>
        </div>
    </div>
</div>
