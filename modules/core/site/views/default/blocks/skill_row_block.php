<?
use modules\user\models\SkillTag;
?>

<div class="dynamic-block col-md-6" style="padding-right: 25px;" data-id="<?= $model ? $model->id : '0' ?>">
        <div class="col-md-6" style="padding-left: 0;">
            <!--<input type="text" data-key="skillname" class="form-control update typeahead" value="<?= $model ? $model->skill_tag : '' ?>">-->
            <div id="form-user_v1">
                <div class="typeahead-container">
                    <div class="typeahead-field">
                        <span class="typeahead-query">
                            <input class="user_v1-query update" data-key="skill_tag" type="search" placeholder="Search" autocomplete="off" value="<?= $model ? SkillTag::find()->where(['id' => $model->skill_tag])->one()->name : '' ?>">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">

            <select <? if(!$model) echo 'disabled'; ?> class="update form-control selectpicker" data-key="skill_list_id">
                <? if(!$model) : ?>
                    <option class="start" value="0">Select level</option>
                <? endif; ?>
                <?php foreach($skill_list as $skill):?>
                    <option <?php echo $model && $skill->id==$model->skill_list_id ? 'selected':''?> value="<?php echo $skill->id?>"><?php echo $skill->name?></option>
                <?php endforeach;?>
            </select>
        </div>
        <? if($is_add) : ?>
            <div class="action_btn btn btn-primary circle plus"><i class="ico-add"></i></div>
        <? else : ?>
            <div class="action_btn btn btn-danger circle remove delete-ajax"><i class="ico-delete"></i></div>
        <? endif; ?>
    <div class="clearfix"></div>
</div>
