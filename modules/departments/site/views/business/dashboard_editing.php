<?
use yii\helpers\Url;
?>
<?php $this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css");?>
<?php $this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js");?>
<div id="dashboard-editing" class="col-md-12" data-tool-id="<?= $tool->id ?>">
    <div class="well" style="margin: 60px auto; max-width: 1000px">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#idea" aria-controls="my" role="tab" data-toggle="tab">Idea</a></li>
            <li role="presentation"><a id="btn-statistic" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Will be available in the next version">Statistic</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="active" id="idea">
                <div class="idea">
                    <div class="idea-title title text-center" style="margin-top: -10px;">
                        Idea description
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-10 <?= isset($idea->errors['name']) ? 'has-error' : '' ?>">
                            <input type="text" maxlength="150" placeholder="Idea name (No more than 150 characters)" name="Idea[name]" value="<?= $idea->name ?>" class="form-control">
                        </div>
                        <div class="col-sm-2 <?= isset($idea->errors['industry_id']) ? 'has-error' : '' ?>" style="padding-left: 0;">
                            <select class="form-control selectpicker" name="Idea[industry_id]">
                                <option value="">Select industry</option>
                                <?php foreach($industries as $industrie):?>
                                    <option <?php echo $idea && $industrie->id==$idea->industry_id ? 'selected':''?> value="<?php echo $industrie->id?>"><?php echo $industrie->name?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group <?= isset($idea->errors['description_like']) ? 'has-error' : '' ?>">
                        <div class="col-sm-12">
                            <textarea style="height:85px;resize:none;" maxlength="300" name="Idea[description_like]" placeholder="Small description of your idea (No more than 300 characters)" class="form-control"><?= $idea->description_like ?></textarea>
                        </div>
                    </div>
                    <div class="row form-group <?= isset($idea->errors['description_problem']) ? 'has-error' : '' ?>">
                        <div class="col-sm-12">
                            <textarea style="height:85px;resize:none;" maxlength="300" placeholder="What problem is solving? (No more than 300 characters)" name="Idea[description_problem]" class="form-control"><?= $idea->description_problem ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="benefits">
                    <div class="benefits-title title text-center">
                        Benefits
                    </div>
                    <div class="row form-group <?= isset($benefit->errors['first']) ? 'has-error' : '' ?>">
                        <div class="col-sm-12">
                            <input type="text" maxlength="200" class="form-control" placeholder="First benefit (No more than 200 characters)" value="<?= $benefit->first ?>" name="Benefit[first]">
                        </div>
                    </div>
                    <div class="row form-group <?= isset($benefit->errors['second']) ? 'has-error' : '' ?>">
                        <div class="col-sm-12">
                            <input type="text" maxlength="200" class="form-control" placeholder="Second benefit (No more than 200 characters)" value="<?= $benefit->second ?>" name="Benefit[second]">
                        </div>
                    </div>
                    <div class="row form-group <?= isset($benefit->errors['third']) ? 'has-error' : '' ?>">
                        <div class="col-sm-12">
                            <input type="text" maxlength="200" class="form-control" placeholder="Third benefit (No more than 200 characters)" value="<?= $benefit->third ?>" name="Benefit[third]">
                        </div>
                    </div>
                </div>
                <div class="button-panel" style="overflow: hidden">
                    <a style="margin:15px auto 0;" onclick="return false" href="#<? //= Url::toRoute(['/departments/business']) ?>" class="btn btn-primary static btn-lg pull-left">Share</a>
                    <a style="margin:15px auto 0;" href="<?= Url::toRoute(['/departments/business']) ?>" class="btn btn-primary btn-lg pull-right">Close</a>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="statistic">
            </div>
        </div>

    </div>
</div>
<style>
.bootstrap-select.btn-group .dropdown-toggle .caret{
    height: 30px;
    width: 30px;
    line-height:30px;
    top:0;
    margin-top: 0 !important;
    right: 0;
    font-size: 20px;
    width: 100%;
    text-align: right;
    padding-right: 10px;
}
.bootstrap-select.btn-group .dropdown-toggle .caret i{
    display: block;
    height: 30px;
    line-height: 30px;
    font-size: 20px;
}
.bootstrap-select .btn{
    border-color:#d7d7d7 !important;
    background: #fff !important;
    border-radius: 0;
}
.bootstrap-select .btn:hover:before{
    display: none;
}
.bootstrap-select .btn:hover{
    box-shadow: none !important;
    color: #5a5a5a !important;
    border-color: #c2cad8 !important;
}
.bootstrap-select>.dropdown-toggle{
    height: 32px;
    line-height:30px;
    padding: 0 30px 0 12px;
}
    .tab-content .title{
        color:#5a5a5a;
        font-size:18px; 
        text-transform: uppercase;
        line-height:36px;
    }
    .btn-primary{
        width:100px;
        height:30px;
        line-height:30px;
        padding: 0;
        font-size:16px;
    }
    .nav-tabs{
        position:absolute;
        top:-30px;
        left:0px;
    }
    .nav-tabs li a{
        padding:0;
        height:30px;
        line-height:30px;
        width:170px;
        text-align:center;
        font-size:16px;
        color:rgba(90,90,90,0.5);
        border:1px solid transparent;
        background:url("/images/tab-bg-dash.png") 0 0 repeat-x;
    }
    .nav-tabs li a:hover{
        border:1px solid rgba(215,215,215,0.5);
    }
    .nav-tabs li.active a:hover,.nav-tabs li.active a:focus{
        border-color: #fff !important;
    }
    .nav-tabs li:first-child a{
        border-radius:10px 0 0 0;
    }
    .nav-tabs li:last-child a{
        border-radius:0px 10px 0 0;
    }
    .nav-tabs li.active a{
        color:#5a5a5a;
        border-color:#fff;
        background:#fff;
    }
    .well{
        position: relative;
        border-top-left-radius:0 !important;
        padding: 20px !important;
    }
</style>
<script>
$(document).ready(function(){
        $('.page-content').mCustomScrollbar({
        setHeight: $('.page-content').css('minHeight'),
        theme:"dark"
    }); 
});
    // $(".selectpicker").selectpicker({});
    $("#find_job").on('show.bs.collapse',function(){
        $(".toggle-findjod .fa").removeClass('fa-angle-down').addClass('fa-angle-up');
    });
    $("#find_job").on('hide.bs.collapse',function(){
        $(".toggle-findjod .fa").removeClass('fa-angle-up').addClass('fa-angle-down');
    });
    $("#btn-statistic").popover();
    $('.form-control').on('change', function(){
        var _this = $(this);
        var text = _this.val();
        var name = _this.attr('name');
        $.ajax({
            url: '/departments/business/dashboard-save',
            type: 'post',
            dataType: 'json',
            data: {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                tool_id: $('#dashboard-editing').attr('data-tool-id'),
                name: name,
                text: text
            },
            success: function (response) {
                if (!response.error) {
                    _this.closest('div').removeClass('has-error');
                }
                else {
                    _this.closest('div').addClass('has-error');
                }
            }
        });
        $(this).removeClass('active');
    });
</script>