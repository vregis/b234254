<?php use modules\departments\models\Industry;?>
<?php use modules\user\models\UserIndustry;?>
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
                        <?php foreach(UserIndustry::getUserIndustry(Yii::$app->user->id, $sp->industry_id) as $spec):?>
                            <option <?php echo $sp->industry_id == $spec->id?'selected':''?> value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                    <div data-id = '<?php echo $sp->id?>' class="action_btn btn btn-primary circle del_special"><i class="ico-delete"></i></div>
            </div>
        <?php endforeach;?>
        <?php if(count($specializations) == 1):?>
            <div class="dynamic-block col-md-4">
                <div class="col-sm-11" style="padding-left: 0;padding-right: 0;">
                    <select class="update form-control add-industry selectpicker">
                        <option class="start" value="0">Select Industry</option>
                        <?php foreach(UserIndustry::getUserIndustry(Yii::$app->user->id) as $spec):?>
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
                        <?php foreach(UserIndustry::getUserIndustry(Yii::$app->user->id) as $spec):?>
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
                        <?php foreach(UserIndustry::getUserIndustry(Yii::$app->user->id) as $spec):?>
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
                    <?php foreach(UserIndustry::getUserIndustry(Yii::$app->user->id) as $spec):?>
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
                    <?php foreach(UserIndustry::getUserIndustry(Yii::$app->user->id) as $spec):?>
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
                    <?php foreach(UserIndustry::getUserIndustry(Yii::$app->user->id, true) as $spec):?>
                        <option value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="action_btn btn btn-primary circle plus add-industry"><i class="ico-add"></i></div>
        </div>
    <?php endif;?>
</div>

<script>
    $(document).on('click', '.ico-add', function(){
        $.ajax({
            url: '/core/add-industry',
            dataType: 'json',
            type: 'post',
            success: function(response){
                $('.industry').append(response.html);
            }
        })
    })

    $('.add-industry').change(function(){
        $(this).removeClass('add-industry');
        $(this).addClass('change-industry');
        $.ajax({
            url: '/core/add-new-ind',
            data: {id:$(this).val()},
            dataType: 'json',
            type: 'post',
            success: function(response){

                $('.dynamic_industry').html(response.html);
                $('.selectpicker').selectpicker({

                });

            }
        })
    })

    $('.change-industry').change(function(){
        $.ajax({
            url: '/core/change-ind',
            data: {id:$(this).val(), ind:$(this).attr('data-id')},
            dataType: 'json',
            type: 'post',
            async: false,
            success: function(response){
                $('.dynamic_industry').html(response.html);
                $('.selectpicker').selectpicker({

                });
            }
        })
    })

    $(document).on('click', '.del_special', function(){
        var id = $(this).attr('data-id');
        var _this = $(this);
        $.ajax({
            url: '/core/del-specialization',
            type: 'post',
            data: {id:id},
            dataType: 'json',
            success: function(response){
                if(response.error == false){
                    _this.closest('.dynamic-block').remove();
                }
            }
        })
    })
</script>