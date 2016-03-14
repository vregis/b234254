<div class="dynamic-block col-md-4">
    <div class="col-sm-11" style="padding-left: 0;padding-right: 0;">
        <select class="add-industry form-control selectpicker">
            <option class="start" value="0">Select Industry</option>
            <?php foreach(\modules\departments\models\Industry::find()->all() as $spec):?>
                <option value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="action_btn btn btn-primary circle plus add-industry"><i class="ico-add"></i></div>
</div>