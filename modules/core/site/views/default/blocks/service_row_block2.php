<?php

use modules\departments\models\Specialization;

?>

<div class="dynamic-block col-md-12" data-id="<?= $service ? $service->id : '0' ?>">

        <div class="col-md-2 select_specialization">
            <div class="multiselect">
                <div class="btn-group bootstrap-select update form-control open">
                    <button type="button" class="btn dropdown-toggle btn-default" title="Native" aria-expanded="true">
                        <span class="filter-option pull-left">Select speciality</span>&nbsp;
                        <span class="bs-caret"><span class="caret"><i class="fa fa-angle-down"></i></span></span>
                    </button>
                    <div class="dropdown-content">
                        <ul>
                            <?php if($speclist):?>
                                <?php foreach($speclist as $spec):?>
                                    <li>
                                        <div class="pull-left"><?php echo $spec->name?></div>
                                        <div class="pull-right">
                                            <a href="#" data-toggle="popover" data-content="info text very big" class="btn btn-primary static circle info">i</a>
                                            <input type="checkbox" class="form-control">
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                <?php endforeach;?>
                            <?php endif;?>

                        </ul>
                    </div>
                </div>
            </div>
                    <!--<select data-key="specialization_id" class="update form-control selectpicker">
                <? if(!$service || $service->specialization_id == 0) : ?>
                    <option class="start" value="0">Select specialization</option>
                <? endif; ?>
                <?php if($speclist):?>
                    <?php foreach($speclist as $spec):?>
                        <option  <?php echo isset($service) && $service->specialization_id == $spec->id?'selected':''?>  value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
                    <?php endforeach;?>
                <?php endif;?>
            </select>-->
        </div>
        <div class="col-md-2">
            <select data-key="exp_type" <? if(!$service) echo 'disabled'; ?> class="form-control update selectpicker">
                <? if(!$service || $service->exp_type == 0) : ?>
                    <option class="start" value="0">Select level</option>
                <? endif; ?>
                <?php foreach($sklist as $sklst):?>
                    <option <?php echo isset($service) && $service->exp_type == $sklst->id?'selected':''?> value="<?php echo $sklst->id?>"><?php echo $sklst->name?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-md-2 select_task">
            <?= $tasks ?>
        </div>
        <div class="col-md-2">
            <div class="input-group">
              <span class="input-group-addon" style="padding: 0;border: 0;"><button class="btn btn-primary circle static" style="font-size:16px;margin-right:11px;background-color:#fff;">$</button></span>
              <input <? if(!$service) echo 'disabled'; ?> type="number" min="0" data-key="rate" class="form-control update" placeholder="Rate/h" value="<?= $service ? $service->rate : '' ?>">
            </div>
        </div>
        <div class="col-md-2" style="margin-left: -15px;">
            <div class="input-group">
              <span class="input-group-addon" style="padding: 0;border: 0;"><button class="btn btn-primary circle static" style="font-size:11px;margin-right:11px;background-color:#fff;"><i class="ico-clock"></i></button></span>
                <input <? if(!$service) echo 'disabled'; ?> type="number" min="0" data-key="time" class="form-control update" placeholder="Time" value="<?= $service ? $service->time : '' ?>">
            </div>
        </div>
        <? if($is_add) : ?>
            <div class="action_btn btn btn-primary circle plus"><i class="ico-add"></i></div>
        <? else : ?>
            <div class="action_btn btn btn-primary circle remove delete-ajax"><i class="ico-delete"></i></div>
        <? endif; ?>
    <div class="clearfix"></div>
</div>
