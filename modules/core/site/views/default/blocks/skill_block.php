<div class="col-md-6 form-group">
    <div class="col-md-6"><input type="text" class="form-control skill_name"></div>
    <div class="col-md-5 last_lang">
        <select disabled name="language" class="form-control skill_year selectpicker">
            <option class="start" value="0">Select level</option>
            <?php foreach($sklist as $list):?>
                <option value="<?php echo $list->id?>"><?php echo $list->name; ?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-1"><img data-c="2" class="plussk"  src="/images/plus.png"></div>
</div>
<?php $this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css");?>
<?php $this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js");?>

<script>
    $('select').on('change', function(){
        $(this).closest('div.skill_year').find('.start').hide();
    })

    $('.selectpicker').selectpicker({
    });

</script>