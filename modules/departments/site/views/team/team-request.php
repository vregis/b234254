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
            <li role="presentation" class="active"><a id="btn-request-block" href="#request-block" aria-controls="request-block" role="tab" data-toggle="tab">Request</a></li>
            <li role="presentation" class=""><a href="#delegate-block" aria-controls="delegate-block" role="tab" data-toggle="tab">Delegation</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="request-block">
                <?php echo $search_html?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="delegate-block">
                <div class="deps-wrap">
                    <div class="roww action">
                        <div data-id="1" class="item background-1">
                            <button data-toggle="collapse" data-target="#idea" aria-expanded="false" aria-controls="idea" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="2" class="item background-2">
                            <button data-toggle="collapse" data-target="#strategy" aria-expanded="false" aria-controls="strategy" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="3" class="item background-3">
                            <img width="30" onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" data-toggle="popover" class="gant_avatar active mCS_img_loaded" data-id="0" src="/images/avatar/nophoto.png" data-original-title="" title="">
                            <a href="javascript:;" class="close"><i class="ico-times"></i></a>
                            <button style="display: none;" data-toggle="collapse" data-target="#customers" aria-expanded="false" aria-controls="customers" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="4" class="item background-4">
                            <button data-toggle="collapse" data-target="#docs" aria-expanded="false" aria-controls="docs" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="5" class="item background-5">
                            <button data-toggle="collapse" data-target="#products" aria-expanded="false" aria-controls="products" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="6" class="item background-6">
                            <button data-toggle="collapse" data-target="#numbers" aria-expanded="false" aria-controls="numbers" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="7" class="item background-7">
                            <button data-toggle="collapse" data-target="#it" aria-expanded="false" aria-controls="it" class="btn btn-primary circle"><i class="ico-add"></i></button>
                        </div>
                        <div data-id="8" class="item background-8">
                            <button data-toggle="collapse" data-target="#team" aria-expanded="false" aria-controls="team" class="btn btn-primary circle"><i class="ico-add"></i></button>
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
                <div class="collapse fade" id="idea">
                    <table class="table table-bordered with-foot" style="width:100%;">
                        <thead>
                            <tr>
                                <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
                                <th width="300">Founder</th>
                                <th width="125">Milestones</th>
                                <th width="85">Tasks</th>
                                <th width="85">New</th>
                                <th width="85">Active</th>
                                <th width="85">Completed</th>
                                <th width="85">Chat</th>
                                <th width="85">Apply</th>
                                <th width="85">Reject</th>
                            </tr>
                        </thead>
                        <tbody id="user_request">
                            <tr class="user-row" data-page-id="0" style="">
                                <td>
                                    <img class="gant_avatar" src="/images/avatar/nophoto.png" height="33" style="margin:0;">
                                </td>
                                <td>Simon Swerdlow</td>
                                <td>40</td>
                                <td>15</td>
                                <td>4</td>
                                <td>2</td>
                                <td>1</td>
                                <td><button class="btn btn-primary circle btn-chat"><i class="ico-chat"></i></button></td>
                                <td><button style="font-size: 10px;" class="btn btn-success circle"><i class="ico-check1"></i></button></td>
                                <td><button style="font-size: 10px;" class="btn btn-danger circle"><i class="ico-delete"></i></button></td>
                            </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="10" style="border-right:0;height: 50px;">
                            </th>
                        </tr>
                        </tfoot>
                    </table>
                    <div id="chat" style="display: none;">
                        <div class="block chat">
                            <div class="content">
                                <div class="ajax-content">
                                    <div class="tab-content">
                                        <div class="tab-pane" id="portlet_tab1">
                                            <div class="scroller" style="height: 200px;">
                                                <ol id="taskUserNotes">
                                                    <li>
                                                        sdasdas
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                        <div class="tab-pane active" id="portlet_tab2">
                                            <div class="scroller" style="height: 200px;">
                                                <ul id="taskUserMessages">
                                                    <div class="daySepar"><span>Thu, Feb 25</span><div class="line"></div></div>
                                                    <li class="task-user-message my">
                                                        <table>
                                                            <tbody><tr>
                                                                <td class="time">05:12 AM</td>
                                                                <td style="width: 0px;"><div class="message">sadasdas</div></td>
                                                            </tr>
                                                        </tbody></table>
                                                    </li>
                                                    <li class="task-user-message">
                                                        <table>
                                                            <tbody><tr>
                                                                <td style="width: 0px;"><div class="message">asdasdas</div></td>
                                                                <td class="time">05:12 AM</td>
                                                                
                                                            </tr>
                                                        </tbody></table>
                                                    </li>
                                                    <li class="task-user-message my">
                                                        <table>
                                                            <tbody><tr>
                                                                <td class="time">05:12 AM</td>
                                                                <td style="width: 0px;"><div class="message">asdasda</div></td>
                                                            </tr>
                                                        </tbody></table>
                                                    </li>
                                                    <div class="clearfix"></div>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="portlet_tab3">
                                            <div class="scroller" style="height: 200px;">
                                                <ol id="taskUserLogs">
                                                    <li>02/22/2016 <br>
                                                    Task obtained    </li>
                                                    <li>02/25/2016 <br>
                                                    Task offered system    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="actions">
                                <ul class="nav nav-tabs pull-right">
                                    <li class="">
                                        <a href="#portlet_tab1" data-toggle="tab" class="btn btn-primary circle" id="btn-tab-note" aria-expanded="false">
                                            <span class="ico-edit"></span>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="#portlet_tab2" data-toggle="tab" class="btn btn-primary circle" id="btn-tab-message" aria-expanded="true">
                                            <span class="ico-chat"></span>
                                        </a>
                                        <span id="badge-chat" class="badge badge-danger"></span>
                                    </li>
                                    <li class="">
                                        <a href="#portlet_tab3" data-toggle="tab" class="btn btn-primary circle" id="btn-tab-log" aria-expanded="false">
                                            <span class="ico-history"></span>
                                        </a>
                                        <span id="badge-log" class="badge badge-danger"></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="footer">
                            <div id="message-input" style="display: block;">
                                <input type="text" id="textarea-task" class="form-control" placeholder="Put your message here...">
                                <button onclick="return false" type="submit" class="btn btn-primary" data-task_user_id="266" id="btn-message">Send </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="collapse fade" id="strategy">
            <table class="table table-bordered with-foot" style="width:100%;">
                <thead>
                    <tr>
                        <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
                        <th width="390">Name</th>
                        <th width="290">Location</th>
                        <th width="125">Chat</th>
                        <th width="125">Invite</th>
                    </tr>
                </thead>
                <tbody id="user_request">
                    <tr class="user-row" data-page-id="0" style="">
                        <td>
                            <img class="gant_avatar" src="/images/avatar/nophoto.png" height="33" style="margin:0;">
                        </td>
                        <td>Swerdlow</td>
                        <td>USA, Jupiter</td>
                        <td><button class="btn btn-primary circle"><i class="ico-chat"></i></button></td>
                        <td><button class="btn btn-primary circle"><i class="ico-add"></i></button></td>
                    </tr>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="5" style="border-right:0;padding: 10px 12px;">
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
                        <div class="pull-right">
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
<script>
$('[data-toggle="collapse"]').click(function(){
var el = $(this).parents('.item').attr('data-id');
console.log(el);
$('.deps .item').removeClass('active');
$('.deps').find('[data-id='+el+']').toggleClass('active');
});
$('.collapse').on('show.bs.collapse',function(){
    var flag = new Boolean(true);
    $(".btn-stat-toggle").click(function(){
        if (flag) {//Если flag == true
            $(this).removeClass('btn-primary').addClass('btn-danger').find('i').removeClass('ico-add').addClass('ico-delete');
            $("th.stat-toggle").html("&nbsp;Reject&nbsp;");
            flag = false;//Меняем значение переменной flag
        } else {//Если flag не равно true
            $(this).removeClass('btn-danger').addClass('btn-primary').find('i').removeClass('ico-delete').addClass('ico-add');
            $("th.stat-toggle").html("Request");
            flag = true;
        }
        return false;
    });
$(".btn-chat").popover({
placement:"auto left",
html:true,
trigger:"click",
content:$("#chat"),
template:'<div class="popover chat" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
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
$("body").on("click", function(e){
$('.btn-chat').each(function () {
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
</script>