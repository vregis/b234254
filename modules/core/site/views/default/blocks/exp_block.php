<div class="col-md-12 form-group" data-id="0">
    <div class="col-md-4">
        <select class="departments form-control selectpicker" name="departments">
            <option class="start" value="0">Select department</option>
            <?php foreach($departments as $dep):?>
                <option value="<?php echo $dep->id?>"><?php echo $dep->name?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-4 select_specialization">
        <select id="0" disabled class="specialization form-control selectpicker">
            <option class="start" value="0">Select specialization</option>
        </select>
    </div>
    <div style="width:29.3%" class="col-md-3">
        <select data-id="0" disabled class="form-control spec_level selectpicker">
            <option class="start" value="0">Select level</option>
            <?php foreach($sklist as $sklst):?>
                <option value="<?php echo $sklst->id?>"><?php echo $sklst->name?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div style="width:3.3%" class="col-md-1"><img class="plusexp"  src="/images/plus.png"></div>
</div>
<script>
    $('.selectpicker').selectpicker({
    });

</script>