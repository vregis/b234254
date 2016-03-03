<?php $can = \modules\departments\models\IdeaLike::find()->where(['idea_id' => $id, 'ip_address' => $_SERVER['REMOTE_ADDR']])->one();?>
<div class="title">DO YOU LIKE IDEA?</div>
<div class="question-name" style="position: relative;">
    <div class="bads" style="position: absolute;top: 33px;left: -50px;">1,233</div>
    <div class="goods" style="position: absolute;top: 33px;right: -50px;">4,433</div>
    <h4 class="left pull-left">No</h4>
    <h4 class="right pull-right">Yes</h4>
    <div class="clearfix"></div>
</div>
<div id="helpful" class="form-md-radios md-radio-inline b-page-checkbox-wrap ">
    <div class="separ"></div>
    <div class="md-radio has-test b-page-checkbox">
        <input type="radio" id="Helpful[0]" name="Helpful" <?php echo ($can && $can->like == 0)?'checked':''?> class="md-radiobtn idea-like <?php echo (!$can)?'':'not'?>" value="0">
        <label for="Helpful[0]">
            <span></span>
            <span class="check" style="left: 5px !important;"></span>
            <span class="box"></span>
        </label>
    </div>
    <div class="md-radio has-test b-page-checkbox">
        <input type="radio" id="Helpful[1]" name="Helpful" <?php echo ($can && $can->like == 1)?'checked':''?> class="md-radiobtn idea-like <?php echo (!$can)?'':'not'?>" value="1">
        <label for="Helpful[1]">
            <span></span>
            <span class="check"></span>
            <span class="box"></span>
        </label>
    </div>
    <div class="md-radio has-test b-page-checkbox">
        <input type="radio" id="Helpful[2]" name="Helpful" <?php echo ($can && $can->like == 2)?'checked':''?> class="md-radiobtn idea-like <?php echo (!$can)?'':'not'?>" value="2">
        <label for="Helpful[2]">
            <span></span>
            <span class="check"></span>
            <span class="box"></span>
        </label>
    </div>
    <div class="md-radio has-test b-page-checkbox">
        <input type="radio" id="Helpful[3]" name="Helpful" <?php echo ($can && $can->like == 3)?'checked':''?> class="md-radiobtn idea-like <?php echo (!$can)?'':'not'?>" value="3">
        <label for="Helpful[3]">
            <span></span>
            <span class="check"></span>
            <span class="box"></span>
        </label>
    </div>
    <div style="display:inline-block;width:100%;">
    </div>
</div>