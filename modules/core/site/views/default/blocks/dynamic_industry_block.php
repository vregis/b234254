<div class="col-md-12">
    <h3 style="margin-left:12px;">Industry</h3>
    <div style="clear:both"></div>
</div>

<div class="industry">

    <?php $specializations = \modules\user\models\UserIndustry::find()->where(['user_id' => Yii::$app->user->id])->all(); ?>
    <?php if($specializations):?>
        <?php $i = 0;?>
        <?php foreach($specializations as $sp):?>
            <?php $i++;?>
            <div class="dynamic-block col-md-4">
                <div class="col-sm-11" style="padding-left: 0;padding-right: 0;">
                    <select data-id = '<?php echo $sp->id?>' class="update change-industry form-control selectpicker">
                        <option class="start" value="0">Select Industry</option>
                        <?php foreach(\modules\departments\models\Industry::find()->all() as $spec):?>
                            <option <?php echo $sp->industry_id == $spec->id?'selected':''?> value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if($i == count($specializations)):?>
                    <div class="action_btn btn btn-primary circle plus"><i class="ico-add"></i></div>
                <?php else:?>
                    <div data-id = '<?php echo $sp->id?>' class="action_btn btn btn-primary circle del_special"><i class="ico-delete"></i></div>
                <?php endif;?>
            </div>
        <?php endforeach;?>
        <?php if(count($specializations) == 1):?>
            <div class="dynamic-block col-md-4">
                <div class="col-sm-11" style="padding-left: 0;padding-right: 0;">
                    <select class="update form-control add-industry selectpicker">
                        <option class="start" value="0">Select Industry</option>
                        <?php foreach(\modules\departments\models\Industry::find()->all() as $spec):?>
                            <option value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="action_btn btn btn-primary circle del_special"><i class="ico-delete"></i></div>
            </div>
            <div class="dynamic-block col-md-4">
                <div class="col-sm-11" style="padding-left: 0;padding-right: 0;">
                    <select class="update form-control add-industry selectpicker">
                        <option class="start" value="0">Select Industry</option>
                        <?php foreach(\modules\departments\models\Industry::find()->all() as $spec):?>
                            <option value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="action_btn btn btn-primary circle plus"><i class="ico-add"></i></div>
            </div>
        <?php endif;?>

        <?php if(count($specializations) == 2):?>
            <div class="dynamic-block col-md-4">
                <div class="col-sm-11" style="padding-left: 0;padding-right: 0;">
                    <select class="update form-control add-industry selectpicker">
                        <option class="start" value="0">Select Industry</option>
                        <?php foreach(\modules\departments\models\Industry::find()->all() as $spec):?>
                            <option value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="action_btn btn btn-primary circle plus"><i class="ico-add"></i></div>
            </div>
        <?php endif; ?>

    <?php else:?>

        <div class="dynamic-block col-md-4">
            <div class="col-sm-11" style="padding-left: 0;padding-right: 0;">
                <select class="update form-control add-industry selectpicker">
                    <option class="start" value="0">Select Industry</option>
                    <?php foreach(\modules\departments\models\Industry::find()->all() as $spec):?>
                        <option value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="action_btn btn btn-primary circle del_special"><i class="ico-delete"></i></div>
        </div>
        <div class="dynamic-block col-md-4">
            <div class="col-sm-11" style="padding-left: 0;padding-right: 0;">
                <select class="update form-control add-industry selectpicker">
                    <option class="start" value="0">Select Industry</option>
                    <?php foreach(\modules\departments\models\Industry::find()->all() as $spec):?>
                        <option value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="action_btn btn btn-primary circle del_special"><i class="ico-delete"></i></div>
        </div>
        <div class="dynamic-block col-md-4">
            <div class="col-sm-11" style="padding-left: 0;padding-right: 0;">
                <select class="update form-control add-industry selectpicker">
                    <option class="start" value="0">Select Industry</option>
                    <?php foreach(\modules\departments\models\Industry::find()->all() as $spec):?>
                        <option value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="action_btn btn btn-primary circle plus add-industry"><i class="ico-add"></i></div>
        </div>
    <?php endif;?>
</div>