<select class="specialization form-control selectpicker">
    <option class="start" value="0">Select specialization</option>
    <?php if($speclist):?>
        <?php foreach($speclist as $spec):?>
            <option value="<?php echo $spec->id?>"><?php echo $spec->name?></option>
        <?php endforeach;?>
    <?php endif;?>
</select>

<script>
    $('.selectpicker').selectpicker({
    });

</script>