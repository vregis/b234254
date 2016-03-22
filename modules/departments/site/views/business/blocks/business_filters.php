<th width="170">
    <select name="industry" id="" class="selectpicker">
        <option value="" class="start">Industry</option>
        <option value="all">All Industry</option>
        <?php foreach($industries as $ind):?>
            <option value="<?php echo $ind->industry_id?>"><?php echo $ind->industry_name?></option>
        <?php endforeach; ?>
    </select>
</th>

<th width="170">
    <select name="industry" id="" class="selectpicker">
        <option value="" class="start">Location</option>
        <option value="">Art</option>
        <option value="">Bar</option>
    </select>
</th>