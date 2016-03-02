<?php
use modules\tasks\models\DelegateTask;
use yii\helpers\Url;
use modules\milestones\models\Milestone;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use modules\departments\models\Idea;
use modules\user\models\User;
use yii\helpers\ArrayHelper;
$this->registerJsFile("/js/bootstrap-confirmation.js");
$this->registerCssFile("/css/business.css");
// $this->registerCssFile("/css/task.css");
$this->registerCssFile("/css/team.css");
$msgJs = <<<JS
$(document).ready(function(){
var offs = 32;
console.log(offs);
$('.well').css({
'margin-top': offs - 2,
'margin-bottom': offs - 2
});
});
JS;
$this->registerJs($msgJs);
?>
<div class="col-md-12 tables-business team" style="font-size: 14px;">
    <div class="well" style="margin: 30px auto; max-width: 1000px;">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#search-block" aria-controls="search-block" role="tab" data-toggle="tab">Search teammate</a></li>
            <li role="presentation" class=""><a id="btn-request-block" href="#request-block" aria-controls="request-block" role="tab" data-toggle="tab">Request teammate</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in in active" id="search-block">

                <?php echo $search_table;?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="request-block">
                <?php echo $request_table; ?>
            </div>
        </div>
    </div>

</div>
</div>
</div>
<script>
$(document).ready(function(){
    $('.close-ava').on('click', function(e){
    var __this = $(this);
    var targ = $(this).prev('a');
    targ.confirmation({
        title: 'Are you sure you want to exclude a member of the team?',
        placement: "bottom",
        btnOkClass: "btn btn-success",
        btnCancelClass: "btn btn-danger",
        btnOkLabel: '<i class="icon-ok-sign icon-white"></i> Yes',
        onConfirm: function (event) {
            var recipient = __this.attr('data-user-id');
            var dep_id = __this.attr('data-dep-id');
            var tool_id = <?php echo $_GET['id']?>;
            $.ajax({
                url: '/departments/team/delete-invite-user',
                type: 'post',
                data: {recipient:recipient, dep_id:dep_id, tool_id:tool_id},
                dataType: 'json',
                success: function(){
                    location.reload(); //refactor this
                }
            })
            targ.confirmation('destroy');
        },
        onCancel: function (event) {
            targ.confirmation('destroy');
            return false;
        }
    });

    targ.confirmation('show');
});
});
$('[data-toggle="collapse"]').click(function(){
    var el = $(this).parents('.item').attr('data-id');
    $('[data-toggle="collapse"], .deps .item').removeClass('active');

    if($(this).attr('aria-expanded') == 'false'){
        $(this).addClass('active');
        $('.deps').find('[data-id='+el+']').addClass('active');
    }else{
        $(this).removeClass('active');
        $('.deps').find('[data-id='+el+']').removeClass('active');
    }
});
$('.collapse').on('show.bs.collapse',function(){
    $(".btn-chat").popover({
        placement:"auto left",
        html:true,
        trigger:"click",
        content:$("#chat"),
        template:'<div class="popover chat" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
        // container:$("#delegate"),
    });
$(".invite-by-email").popover({
    placement:"auto top",
    html:true,
    trigger:"click",
    content:$("#invite-form"),
    // container:$("#delegate"),
});
$(this).find(".btn-chat").on('show.bs.popover',function(){
    $("#chat").show();
    $(this).addClass('active');
    $("#chat .actions a").on('show.bs.tab',function(){
        $("#chat .scroller").mCustomScrollbar({
            theme:"dark",
            scrollbarPosition:"outside"
        });    
    });
}).on('hide.bs.popover',function(){
    $(this).removeClass('active');
    // $("#chat").hide();
});
$(this).find(".invite-by-email").on('show.bs.popover',function(){
    $("#invite-form").show();
    $(".invite-by-email").addClass('active');
}).on('hide.bs.popover',function(){
    $(".invite-by-email").removeClass('active');
    // $("#invite-form").hide();
});
$("body").on("click", function(e){
        $('.invite-by-email,.btn-chat').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});
}).on('hide.bs.collapse',function(){
    var el = $(this).parents('.item').attr('class');
    $('.deps').find(el).removeClass('active');
});

    //ajax




</script>