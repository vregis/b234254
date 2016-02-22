<div id="advanced-search-form" style="display:none;">
    <div class="row form-group">
        <div class="col-sm-6">
            <label for="">Rate by/H</label> <br>
            <?
            $rate = '';
            $rate_min = '';
            $rate_max = '';
            ?>
            <div class="col-sm-5 pull-left" style="padding:0;"><input placeholder="Min" type="text" id="input-rate-start" value="<?=$rate_min?>" class="form-control"></div>
            <div class="col-sm-5 pull-right" style="padding:0;"><input placeholder="Max" type="text" id="input-rate-end" value="<?=$rate_max?>" class="form-control"></div>
            <div class="clearfix"></div>
        </div>
        <?php $levellist = \modules\user\models\Skilllist::find()->all();?>
        <div class="col-sm-6">
            <label for="">Level</label> <br>
            <select id="select-country" class="form-control selectpicker country">
                <?php foreach($levellist as $c):?>
                    <option <?php //echo $c->id == $profile->country_id?'selected':''?> value="<?php echo $c->id?>"><?php echo $c->name?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-6">
            <label for="">Country</label> <br>
            <select id="select-country" class="form-control selectpicker country">
                <?php foreach($countrylist as $c):?>
                    <option <?php echo $c->id == $profile->country_id?'selected':''?> value="<?php echo $c->id?>"><?php echo $c->title_en?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-6">
            <label for="">City</label> <br>
            <input type="text" style="height:32px;" placeholder="Type city" class="form-control">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-6">
            <label for="">Department</label> <br>
            <select id="select-department" class="form-control selectpicker country">
                <?php foreach($departments as $dep_id => $dep_name):?>
                    <option value="<?php echo $dep_id?>"><?php echo $dep_name?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-6">
            <label for="">Speciality</label> <br>
            <select id="select-special" disabled class="form-control selectpicker country">
            </select>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-12">
            <div class="pull-right">
                <button type="submit" width="80px;margin-right:0;" id="advanced-search-send" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
</div>
<div id="advanced-search-form-dom" style="display:none;">
</div>
<style>
    .invite-by-email+.popover .popover-content, .advanced-search-btn+.popover .popover-content{
        height:257px;
    }
</style>