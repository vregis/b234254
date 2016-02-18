<div class="dynamic-block col-md-12" data-id="<?= $model ? $model->id : '0' ?>">
        <div class="col-md-6" style="padding-left: 0;">
            <input type="text" data-key="university" class="form-control update" value="<?= $model ? $model->university : '' ?>">
        </div>
        <div class="col-sm-6">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon" style="padding: 0;border: 0;padding-right:10px;">From</span>
                        <input <? if(!$model) echo 'disabled'; ?> type="text" data-key="year_start" class="form-control update" value="<?= $model ? $model->year_start : '' ?>">
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon" style="padding: 0;border: 0;padding-right:10px;">To</span>
                        <input <? if(!$model) echo 'disabled'; ?> type="text" data-key="year_end" class="form-control update" value="<?= $model ? $model->year_end : '' ?>">
                    </div>
                </div>
            </div>
        </div>
        <? if($is_add) : ?>
            <div class="action_btn btn btn-primary circle plus"><i class="ico-add"></i></div>
        <? else : ?>
            <div class="action_btn btn btn-danger circle remove delete-ajax"><i class="ico-delete"></i></div>
        <? endif; ?>
    <div class="clearfix"></div>
</div>
