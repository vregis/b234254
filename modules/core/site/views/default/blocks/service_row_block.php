<?php

use modules\departments\models\Specialization;
?>
<div class="dynamic-block col-md-8 col-md-offset-2 service-wrapper" data-id="<?php echo (isset($service))?$service->id:''?>"  style="margin-bottom: 10px;">
    <div class="row">
        <div class="col-sm-5" style="padding: 0;">
            <div  class="multiselect <?php echo $type == 'add'?'add':''?> <?php echo $last == true?'disabled':''?>">
                    <div class="btn-group bootstrap-select update form-control open specialization-wrapper">
                        <button type="button" class="btn dropdown-toggle btn-default spec" title="Native" aria-expanded="true">
                            <span class="filter-option pull-left selected-specialization-name">Select </span>&nbsp;
                            <span class="bs-caret"><span class="caret"><i class="fa fa-angle-down"></i></span></span>
                        </button>
                        <div class="dropdown-content">
                            <ul>
                                <?php if($speclist):?>
                                    <?php foreach($speclist as $spec):?>
                                        <li class="<?php echo (isset($service) && $service->specialization_id == $spec->id)?'spec-selected':'' ?> specializ-id" data-id = '<?php echo $spec->id?>'>
                                            <div class="pull-left spec-name" data-id="<?php echo $spec->id?>" data-descr="<?php echo $spec->description?>"> <?php echo substr($spec->name, 0, 25)?> <?php echo mb_strlen($spec->name)>25?'...':''?></div>
                                            <div class="pull-right">
                                                <a href="#" data-toggle="popover" data-content="<?php echo $spec->description?>" class="btn btn-primary static circle info">i</a>
                                                <input <?php echo (isset($service) && $spec->id == $service->specialization_id)?'checked':''?> type="checkbox" class="form-control" data-specid = '<?php echo $spec->id?>'>
                                                <?php if(isset($service) && $spec->id == $service->specialization_id):?>
                                                    <div style="display:none" class="specialization_selected"><?php echo $spec->name?></div>
                                                <?php endif;?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </li>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                <a href="#" data-toggle="popover" data-content="" data-trigger="hover" class="pull-right btn btn-primary static circle info spec_desc">i</a>
            </div>
        </div>
        <div class="col-sm-4">
            <select data-key="exp_type" <? if(!$service) echo 'disabled'; ?> class="form-control update selectpicker sel2">
                <? //if(!$service || $service->exp_type == 0) : ?>
                    <!--<option class="start" value="0">Select1</option>-->
                <? //endif; ?>
                <?php if(!$service):?>
                <option class="start" value="0">Select</option>
                <?php endif; ?>
                <?php if($sklist):?>
                    <?php $sklist = array_reverse($sklist);?>
                <?php endif;?>
                <?php foreach($sklist as $sklst):?>
                    <option <?php echo isset($service) && $service->exp_type == $sklst->id?'selected':''?> value="<?php echo $sklst->id?>"><?php echo $sklst->name?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-sm-3" style="padding-left: 0;">
            <div class="row">
                <div class="col-sm-7" style="padding-right: 0;">
                    <input type="text" min="0" style="width:82px" data-key="rate" value="<?php echo $type == 'add'?'':$service->rate?>" class="form-control update">
                </div>
                <div class="col-sm-5" style="height: 34px;text-align: center;position: relative;">
                    <?php if(!$is_add):?>
                        <div class="action_btn btn btn-danger circle remove delete-ajax-serv" style="position: relative !important;"><i class="ico-delete"></i></div>
                    <?php else:?>
                        <div class="action_btn btn btn-primary circle plus <?php echo $type == 'add'?'plus_disabled':''?> <?php echo $last == true?'last_spec':''?>" style="position: relative !important;"><i class="ico-add"></i></div>
                    <?php endif;?>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".multiselect.disabled .specialization-wrapper").click(function(e){
        e.preventDefault();
        e.stopPropagation();
    });
    $('li.spec-selected').each(function(){
        var name = $(this).find('.spec-name').text();
        var id = $(this).find('.spec-name').attr('data-id');
        var desc = $(this).find('.spec-name').attr('data-descr');
        $(this).closest('.multiselect').find('.selected-specialization-name').html(name);
        $(this).closest('.multiselect').find('.selected-specialization-name').attr('data-id', id);
                $(".services .service .multiselect > .btn.info").popover({
            placement:"top",
            trigger:"hover"
        });
        $(this).closest('.multiselect').find('.spec_desc').attr('data-content', desc);
    })

    $('.plus_disabled').on('click', function(){
        return false;
    })
    $('.last_spec').on('click', function(){
        return false;
    })

    $('.selectpicker').on('change', function(){

        $(this).closest('.dynamic_block').find('.plus_disabled').removeClass('.plus_disabled');
    })

    $('.multiselect.add').find('.spec_desc').hide();
</script>