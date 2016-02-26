<?php
use modules\tasks\models\DelegateTask;
use yii\helpers\Url;
use modules\milestones\models\Milestone;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use modules\departments\models\Idea;
use modules\user\models\User;
use yii\helpers\ArrayHelper;
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
                <div class="deps-wrap">
                    <div class="roww action">
                        <div data-id="1" class="item background-1">
                            <button data-toggle="collapse" data-target="#idea" aria-expanded="false" aria-controls="idea" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="2" class="item background-2">
                            <button data-toggle="collapse" data-target="#strategy" aria-expanded="false" aria-controls="strategy" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="3" class="item background-3">
                            <!--img width="30" onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" data-toggle="popover" class="gant_avatar active mCS_img_loaded" data-id="0" src="/images/avatar/nophoto.png" data-original-title="" title="">
                            <a href="javascript:;" class="close"><i class="ico-times"></i></a>-->
                            <button data-toggle="collapse" data-target="#customers" aria-expanded="false" aria-controls="customers" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="4" class="item background-4">
                            <button data-toggle="collapse" data-target="#documents" aria-expanded="false" aria-controls="docs" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="5" class="item background-5">
                            <button data-toggle="collapse" data-target="#products" aria-expanded="false" aria-controls="products" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="6" class="item background-6">
                            <button data-toggle="collapse" data-target="#numbers" aria-expanded="false" aria-controls="numbers" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="7" class="item background-7">
                            <button data-toggle="collapse" data-target="#computers" aria-expanded="false" aria-controls="it" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="8" class="item background-8">
                            <button data-toggle="collapse" data-target="#people" aria-expanded="false" aria-controls="team" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                    </div>
                    <div class="roww deps">
                        <div data-id="1" href="javascript:;" class="item background-1">Idea<div class="arrow" style="left: 50%;"></div></div>
                        <div data-id="2" href="javascript:;" class="item background-2">Strategy<div class="arrow" style="left: 50%;"></div></div>
                        <div data-id="3" href="javascript:;" class="item background-3">Customers<div class="arrow" style="left: 50%;"></div></div>
                        <div data-id="4" href="javascript:;" class="item background-4">Documents<div class="arrow" style="left: 50%;"></div></div>
                        <div data-id="5" href="javascript:;" class="item background-5">Products<div class="arrow" style="left: 50%;"></div></div>
                        <div data-id="6" href="javascript:;" class="item background-6">Numbers<div class="arrow" style="left: 50%;"></div></div>
                        <div data-id="7" href="javascript:;" class="item background-7">IT<div class="arrow" style="left: 50%;"></div></div>
                        <div data-id="8" href="javascript:;" class="item background-8">Team<div class="arrow" style="left: 50%;"></div></div>
                    </div>
                </div>
                <?php echo $search_table;?>
            </div>
                <div role="tabpanel" class="tab-pane fade" id="request-block">
        <div class="deps-wrap">
            <div class="roww action">
                <div data-id="1" class="item background-1">
                    <button data-toggle="collapse" data-target="#idea1" aria-expanded="false" aria-controls="idea1" class="btn btn-primary circle"><i class="ico-add"></i></button>
                </div>
                <div data-id="2" class="item background-2">
                    <button data-toggle="collapse" data-target="#strategy1" aria-expanded="false" aria-controls="strategy1" class="btn btn-primary circle"><i class="ico-add"></i></button>
                </div>
                <div data-id="3" class="item background-3">
                    <!--<img width="30" onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" data-toggle="popover" class="gant_avatar active mCS_img_loaded" data-id="0" src="/images/avatar/nophoto.png" data-original-title="" title="">-->
                    <!--<a href="javascript:;" class="close"><i class="ico-times"></i></a>-->
                    <button data-toggle="collapse" data-target="#customers1" aria-expanded="false" aria-controls="customers1" class="btn btn-primary circle"><i class="ico-add"></i></button>
                </div>
                <div data-id="4" class="item background-4">
                    <button data-toggle="collapse" data-target="#docs1" aria-expanded="false" aria-controls="docs1" class="btn btn-primary circle"><i class="ico-add"></i></button>
                </div>
                <div data-id="5" class="item background-5">
                    <button data-toggle="collapse" data-target="#products1" aria-expanded="false" aria-controls="products1" class="btn btn-primary circle"><i class="ico-add"></i></button>
                </div>
                <div data-id="6" class="item background-6">
                    <button data-toggle="collapse" data-target="#numbers1" aria-expanded="false" aria-controls="numbers1" class="btn btn-primary circle"><i class="ico-add"></i></button>
                </div>
                <div data-id="7" class="item background-7">
                    <button data-toggle="collapse" data-target="#it1" aria-expanded="false" aria-controls="it1" class="btn btn-primary circle"><i class="ico-add"></i></button>
                </div>
                <div data-id="8" class="item background-8">
                    <button data-toggle="collapse" data-target="#team1" aria-expanded="false" aria-controls="team1" class="btn btn-primary circle"><i class="ico-add"></i></button>
                </div>
            </div>
            <div class="roww deps">
                <div data-id="1" href="javascript:;" class="item background-1">Idea<div class="arrow" style="left: 50%;"></div></div>
                <div data-id="2" href="javascript:;" class="item background-2">Strategy<div class="arrow" style="left: 50%;"></div></div>
                <div data-id="3" href="javascript:;" class="item background-3">Customers</div>
                <div data-id="4" href="javascript:;" class="item background-4">Documents</div>
                <div data-id="5" href="javascript:;" class="item background-5">Products</div>
                <div data-id="6" href="javascript:;" class="item background-6">Numbers</div>
                <div data-id="7" href="javascript:;" class="item background-7">IT</div>
                <div data-id="8" href="javascript:;" class="item background-8">Team</div>
            </div>
        </div>
        <div class="collapse fade" id="idea1">
            <table class="table table-bordered with-foot" style="width:100%;">
                <thead>
                    <tr>
                        <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
                        <th width="212">Name</th>
                        <th width="125">Department</th>
                        <th width="212">Location</th>
                        <th width="125">Chat</th>
                        <th width="125">Apply</th>
                        <th width="125">Reject</th>
                    </tr>
                </thead>
                <tbody id="user_request">
                    <tr class="user-row" data-page-id="0" style="">
                        <td>
                            <img class="gant_avatar" src="/images/avatar/nophoto.png" height="33" style="margin:0;">
                        </td>
                        <td>Simon Swerdlow</td>
                        <td>Idea</td>
                        <td>USA, Jupiter</td>
                        <td><button class="btn btn-primary btn-chat circle"><i class="ico-chat"></i></button></td>
                        <td><button style="font-size: 10px;" class="btn btn-success circle"><i class="ico-check1"></i></button></td>
                        <td><button style="font-size: 10px;" class="btn btn-danger circle"><i class="ico-delete"></i></button></td>
                    </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7" style="border-right:0;padding: 10px 12px;">
                        <div class="pull-left">
                            <div id="invite-form" class="no-autoclose" style="display:none;">
                                <div class="form-group">
                                    <input type="text" id="input-invite-email" class="form-control" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <textarea name="name" id="input-invite-offer" class="form-control" rows="8" cols="40" placeholder="Offer text"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="pull-right">
                                        <button type="submit" id="invite-form-send" class="btn btn-primary">Send</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <button class="btn btn-primary circle invite-by-email" data-toggle="popover">
                            <i class="ico-mail"></i>
                            </button>
                            Invite by email
                        </div>
                        <div class="clearfix"></div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="collapse fade" id="strategy1">
            <table class="table table-bordered with-foot" style="width:100%;">
                <thead>
                    <tr>
                        <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
                        <th width="212">Name</th>
                        <th width="125">Department</th>
                        <th width="212">Location</th>
                        <th width="125">Chat</th>
                        <th width="125">Apply</th>
                        <th width="125">Reject</th>
                    </tr>
                </thead>
                <tbody id="user_request">
                    <tr class="user-row" data-page-id="0" style="">
                        <td>
                            <img class="gant_avatar" src="/images/avatar/nophoto.png" height="33" style="margin:0;">
                        </td>
                        <td style="text-align:left;">Simon Swerdlow</td>
                        <td>Idea</td>
                        <td>USA, Jupiter</td>
                        <td><button class="btn btn-primary btn-chat circle"><i class="ico-chat"></i></button></td>
                        <td><button style="font-size: 10px;" class="btn btn-success circle"><i class="ico-check1"></i></button></td>
                        <td><button style="font-size: 10px;" class="btn btn-danger circle"><i class="ico-delete"></i></button></td>
                    </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7" style="border-right:0;padding: 10px 12px;">
                        <div class="pull-left">
                            <div id="invite-form" class="no-autoclose" style="display:none;">
                                <div class="form-group">
                                    <input type="text" id="input-invite-email" class="form-control" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <textarea name="name" id="input-invite-offer" class="form-control" rows="8" cols="40" placeholder="Offer text"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="pull-right">
                                        <button type="submit" id="invite-form-send" class="btn btn-primary">Send</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <button class="btn btn-primary circle invite-by-email" data-toggle="popover">
                            <i class="ico-mail"></i>
                            </button>
                            Invite by email
                        </div>
                        <div class="clearfix"></div>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
        </div>
    </div>

</div>
</div>
</div>
<script>
$('[data-toggle="collapse"]').click(function(){
    var el = $(this).parents('.item').attr('data-id');
    console.log(el);
    $('.deps .item').removeClass('active');
    $('.deps').find('[data-id='+el+']').toggleClass('active');
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