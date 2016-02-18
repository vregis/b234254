

<div class="col-md-6 form-group">
    <div class="col-md-6"><select class="form-control lang_name">
            <option class="start" value="0">Select language</option>
            <?php foreach($lang_list as $l):?>
                <option value="<?php echo $l->Language?>"><?php echo $l->Language?></option>
            <?php endforeach;?>
        </select></div>
    <div class="col-md-5 last_lang">
        <select name="language" disabled class="form-control lang_skill">
            <option class="start" value="0">Select level</option>
            <?php foreach($language as $lang):?>
                <option value="<?php echo $lang->id?>"><?php echo $lang->name?></option>
            <?php endforeach;?>
        </select>
    </div>

    <div class="col-md-1"><img data-c="2" class="pluslang"  src="/images/plus.png"></div>
</div>

<?php $this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css");?>
<?php $this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js");?>

<script>
    $('select').on('change', function(){
        $(this).closest('div.lang_name').find('.start').hide();
    })

    $('select.lang_skill').on('change', function(){
        $(this).closest('div.lang_skill').find('.start').hide();
    })

    $('select').each(function(){
        $(this).addClass('selectpicker');
    })

    $('.selectpicker').selectpicker({
    });
</script>


