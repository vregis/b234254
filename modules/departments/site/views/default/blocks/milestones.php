<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 26.12.2015
 * Time: 12:51
 */

use yii\helpers\Url;

?>
    <div style="text-align:center;" class="btn all <? if($milestone_id == -1) : ?>active<? endif; ?>">
        <a href="<?= Url::toRoute(['/departments','id' => $department->id]) ?>" class="milestone-link">
            All milestones
        </a>
    </div>
    <? $number = 1; ?>
    <? foreach($milestones as $milestone) : ?>
    <? if($milestone->is_pay == 0) : ?>
        <div class="btn  <? if($milestone_id == $milestone->id) : ?>active<? endif; ?>">  
                <a href="<?= Url::toRoute(['/departments','milestone_id' => $milestone->id]) ?>" class="milestone-link">
                    <?= $number ?>.
                    <?= $milestone->name ?>
                </a>          
            <div class="body-collapse-description">
                <i class="fa fa-question-circle font-white no-decoretion" data-container="body" data-toggle="popover" data-placement="auto" data-content="<?= $milestone->description ?>"></i>
            </div>
        </div>
        <? else : ?>
        <div class="btn <? if($milestone_id == $milestone->id) : ?>active<? endif; ?>" data-container="body" data-toggle="popover" data-placement="auto" data-content="Will be available in the next version">
                <a class="milestone-link">
                    <?= $number ?>.
                    <?= $milestone->name ?>
                </a>
            <div class="body-collapse-description">
                <i class="fa fa-question-circle font-white no-decoretion" data-container="body" data-toggle="popover" data-placement="auto" data-content="<?= $milestone->description ?>"></i>
            </div>
        </div>
        <? endif; ?>
        <? $number++; ?>
    <? endforeach; ?>
