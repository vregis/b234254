<div class="dynamic-block col-md-6" style="padding-right: 25px;" data-id="<?= $model ? $model->id : '0' ?>">
        <div class="col-md-6 lang-sel" style="padding-left: 0;padding-right: 0;">
            <select class="update form-control selectpicker" data-key="language">
                <? if(!$model) : ?>
                    <option class="start" value="0">Select language</option>
                <? endif; ?>
                <?php foreach($languages as $language):?>
                    <option <?php echo isset($model) && $language->Language==$model['language'] ? 'selected':''?> value="<?php echo $language->Language?>"><?php echo $language->Language?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-md-6">
            <select <? if(!$model) echo 'disabled'; ?> class="update form-control selectpicker" data-key="language_skill_id">
                <? if(!$model) : ?>
                    <option class="start" value="0">Select level</option>
                <? endif; ?>
                <?php foreach($language_skills as $language_skill):?>
                    <option <?php echo $model && $language_skill->id==$model->language_skill_id ? 'selected':''?> value="<?php echo $language_skill->id?>"><?php echo $language_skill->name?></option>
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
