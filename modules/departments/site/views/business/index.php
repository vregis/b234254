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
$this->registerCssFile("/css/task.css");
$this->registerCssFile("/css/contribute-modal.css");

$msgJs = <<<JS
    $(document).ready(function(){
        var offs = 32;
        console.log(offs);
        $('.well').css({
            'margin-top': offs - 2,
            'margin-bottom': offs - 2
        });
    });
        function fontSize() {
            if($('html').width() < 767) {
                var width = 520; // ширина, от которой идет отсчет
                var fontSize = 10; // минимальный размер шрифта
                var bodyWidth = $('html').width();
                var multiplier = bodyWidth / width;
                if ($('html').width() >= width) fontSize = Math.floor(fontSize * multiplier);
                $('.tables-business').css({fontSize: fontSize+'px'});
            }
            else {
                $('.tables-business').css({fontSize: '14px'});
            }
        }
        $(function() { fontSize(); });
        $(window).resize(function() { fontSize(); });
JS;
$this->registerJs($msgJs);
?>

<div class="col-md-12 tables-business">
    <div class="well" style="margin: 0 auto; max-width: 1000px">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="<?= count($self_userTools) != 0 ? 'active' : '' ?>"><a href="#my" aria-controls="my" role="tab" data-toggle="tab">My business</a></li>
            <li role="presentation" class="<?= count($self_userTools) == 0 ? 'active' : '' ?>"><a id="btn-offered-block" href="#delegated" aria-controls="delegated" role="tab" data-toggle="tab">Delegated business <!--<span class="label label-danger circle"></span>--></a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in <?= count($self_userTools) != 0 ? 'in active' : '' ?>" id="my">
                <?php $i = 0;?>
                <? foreach($self_userTools as $cur) : ?>
                    <?php if($cur->name):?>
                        <?php $i++;?>
                    <?php endif;?>
                <?php endforeach;?>
            <? if(count($self_userTools) == 0 || $i == 0) : ?>
                <div class="text-center" style="padding:22px 0;">
                    Everyone can start a business. All you need is just an idea!
                </div>
                <div style="border-top:1px solid #d7d7d7;height:1px;"></div>
            <?php else: ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 52px;"><a href="#" class="btn btn-primary circle static" style="margin:0;border:none !important;font-size: 24px;line-height: 42px !important;padding-left: 1px;padding-top: 1px;"><i class="ico-history"></i></a></th>
                        <th> Name </th>
                        <th width="170"> Creation date </th>
                        <th width="130"> Tasks </th>
                        <th width="130"> New </th>
                        <th width="130"> In progress </th>
                        <th width="130"> Completed </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0;?>
                    <? foreach($self_userTools as $current_userTool) : ?>
                        <?php $i++; ?>
                        <?php if(!$current_userTool->name):?>
                        <?php else:?>
                        <tr>
                            <?
                            $task_count = Task::find()
                                ->join('JOIN','milestone','milestone.id = task.milestone_id')
                                ->join('JOIN', 'department', 'department.id = task.department_id')
                                ->where(['is_hidden' => '0','department.is_additional' => 0])
                                ->count();
                            $count_progress = TaskUser::find()->where(['user_tool_id' => $current_userTool->id,'status' => TaskUser::$status_active])->count();
                            $count_completed = TaskUser::find()->where(['user_tool_id' => $current_userTool->id,'status' => TaskUser::$status_completed])->count();
                            ?>
                            <td>
                                <a href="javascript:;" class="dropmenu<?php echo $i?> history btn btn-primary circle" data-toggle="popover" data-not_autoclose="1"><i class="ico-history"></i></a>
                            </td>
                            <td style="text-transform: uppercase">
                                <a href="<?= Url::toRoute(['/departments/business/select-tool', 'id' => $current_userTool->id]) ?>"
                                <?php if(strlen($current_userTool->name) >30):?>
                                     data-toggle="popover" data-placement="bottom" data-content="<?= $current_userTool->name ?>"
                                <?php endif;?>
                                 style="display: block;width: 220px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;" 
                                 class="name"
                                ><?= $current_userTool->name ? $current_userTool->name : 'No name' ?> <!--<span class="label label-danger circle"></span>--></a>
                            </td>
                            <td>
                                <?= (new DateTime($current_userTool->create_date))->format("m/d/Y") ?>
                            </td>
                            <td>
                                <?= $task_count ?>
                            </td>
                            <td>
                                <?= $task_count - $count_progress - $count_completed ?>
                            </td>
                            <td>
                                <?= $count_progress ?>
                            </td>
                            <td>
                                <?= $count_completed ?>
                            </td>
                        </tr>
                        <div id="huistory<?php echo $i?>" class="huistory" style="display:none;">
                            <a href="<?= Url::toRoute(['/departments/business/shared-business','id' => $current_userTool->id]) ?>" target="_blank">View Profile</a>
                            <a href="javascript:;" class="team" data-toggle="popover">View Team</a>
                            <a data-toggle="popover" class="delete<?php echo $i?> delete" href="javascript:;">Delete Business</a>
                            <div id="delete-block" style="display: none;">
                                Are you sure you want to delete <?php echo $current_userTool->name?> ?
                                <br>
                                <button class="btn btn-danger">
                                    <i class="glyphicon glyphicon-remove"></i> No
                                </button>
                                <button class="btn btn-success" href="#" target="_self">
                                    <i class="glyphicon glyphicon-ok"></i> <i class="icon-ok-sign icon-white"></i> Yes
                                </button>
                            </div>
                        </div>
                        <script>
                        $(document).ready(function(){
                            $(".dropmenu<?php echo $i?>.history").popover({
                                placement:"bottom",
                                html:true,
                                content:$("#huistory<?php echo $i?>"),
                                container:$("body"),
                                template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
                            });
                            $(".dropmenu<?php echo $i?>.history").on('show.bs.popover',function(){
                                $("#huistory<?php echo $i?>").show();
                                $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
                            }).on('hide.bs.popover',function(){
                                $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                            });
                        });
                        $(".well > .nav-tabs li a").on('shown.bs.tab',function(){
                            $(".dropmenu<?php echo $i?>.history").popover({
                                placement:"bottom",
                                html:true,
                                content:$("#huistory<?php echo $i?>"),
                                container:$("body"),
                                template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
                            });
                            $(".dropmenu<?php echo $i?>.history").on('show.bs.popover',function(){
                                $("#huistory<?php echo $i?>").show();
                                $(".huistory a.team").popover({
                                    container: 'body',
                                    placement: "right",
                                    html:true,
                                    template:'<div class="popover delegation" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                                    content : 'Will be available in the next version'
                                });
                                $(".huistory a.delete").click(function(){
                                    var delBlock = $(this).next('#delete-block');
                                    var toHide = $(this).parent().find('a');
                                    delBlock.show();
                                    toHide.hide();
                                    delBlock.find(".btn-success").click(function(){
                                        document.location.href = '<?php echo Url::toRoute(['/departments/business/delete','id' => $current_userTool->id]);?>';
                                    });
                                    delBlock.find(".btn-danger").click(function(){
                                        delBlock.hide();
                                        toHide.show();
                                    });
                                });
                                $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
                            }).on('hide.bs.popover',function(){
                                $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                            });
                        });


                        $(".huistory a.delete<?php echo $i?>").click(function(){
                            var delBlock = $(this).next('#delete-block');
                            var toHide = $(this).parent().find('a');
                            delBlock.show();
                            toHide.hide();
                            delBlock.find(".btn-success").click(function(){
                                document.location.href = '<?php echo Url::toRoute(['/departments/business/delete','id' => $current_userTool->id]);?>';
                            });
                            delBlock.find(".btn-danger").click(function(){
                                delBlock.hide();
                                toHide.show();
                            });
                        });

                        </script>

                            <?php endif;?>
                    <? endforeach; ?>
                    </tbody>
                </table>

                <? endif; ?>
                <div class="text-center btn-div" style="padding-top:30px;">
                    <a href="<?= Url::toRoute(['/departments/business/create']) ?>" style="padding: 0px 75px;line-height: 45px !important;height: 45px;vertical-align: middle;" class="btn btn-lg btn-primary">Add business idea</a>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade <?= count($self_userTools) == 0 ? 'in active' : '' ?>" id="delegated">
                <div id="delegated_businesses">
                    <?= $delegated_businesses ?>
                </div>
                <div class="text-center btn-div" style="padding-top:30px;">
                    <?php $do = \modules\departments\models\UserDo::find()->where(['user_id' => Yii::$app->user->id, 'status_sell' => 1])->all();?>
                    <?php if(count($do) == 0):?>
                        <p>Fill in the information about your skills before look for a job</p>
                        <a href="/core/profile" style="padding: 0px 75px;line-height: 45px !important;height: 45px;vertical-align: middle;" class="btn btn-lg btn-primary" >Go To Profile</a>
                    <?php else:?>
                    <a href="#delegated#open" style="padding: 0px 75px;line-height: 45px !important;height: 45px;vertical-align: middle;" class="btn btn-lg btn-primary toggle-findjod" data-toggle="collapse" data-target="#find_job" aria-expanded="false">Search <i style="font-size: 20px;position: absolute;top: 14px;margin-left: 10px;" class="fa fa-angle-down"></i></a>
                    <?php endif;?>
                </div>
                <? require __DIR__.'/blocks/find_job.php' ?>           
            </div>
        </div>

    </div>
</div>
<div id="contribute-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="title1">During the introductory stage</div>
                <div class="title2">PAYMENT IS OPTIONAL</div>
                <div class="arrow one"></div>
                <div class="arrow two"></div>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row top">
                        <div class="col-sm-6">
                            <div class="icon"><i class="ico-recycle"></i></div>
                            <div class="title">REFUSE</div>
                            <div class="subtitle">Specify the reason</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="icon" style="font-size: 24px;"><i class="ico-dollar1"></i></div>
                            <div class="title">CONTRIBUTE</div>
                            <div class="subtitle">Same functions with additional benefits.</div>
                            <div class="pay">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="ico-dollar"></i>
                                    </span>
                                    <input type="text" class="form-control"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row content">
                        <div class="col-sm-6">
                            <div class="form-group form-md-radios">
                                <div class="md-radio-list">
                                    <div class="md-radio">
                                        <input type="radio" id="radio1" name="radio1" class="md-radiobtn">
                                        <label for="radio1">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span>I don’t care how you guys grow</label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="radio2" name="radio1" class="md-radiobtn" checked="">
                                        <label for="radio2">
                                            <span class="inc"></span>
                                            <span class="check"></span>
                                            <span class="box"></span> I don’t have a few dollars </label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="radio3" name="radio1" class="md-radiobtn">
                                        <label for="radio3">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> I don’t see value in this tool </label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="radio4" name="radio1" class="md-radiobtn">
                                        <label for="radio4">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> I like to save anywhere I can </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <ul>
                                <li><span>Special "Supporter" status</span></li>
                                <li><span>Exclusive offers and deals</span></li>
                                <li><span>Claim your username</span></li>
                                <li><span>Your feedback takes precedence</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center col-sm-6">
                            <button style="width:100px;" class="btn btn-danger">Refuse</button>
                        </div>
                        <div class="text-center col-sm-6">
                            <button style="width:100px;" class="btn btn-success">Contribute</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center" style="margin-top: 17px;margin-bottom: -15px;">
                            <a href="#" style="color:#5184f3 !important;">Remind me later</a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    $(document).ready(function(){
        $("#contribute-modal").on('shown.bs.modal',function(){
            $("#contribute-modal .modal-dialog").css({'margin-top':$(window).outerHeight()/2 - $("#contribute-modal .modal-dialog").outerHeight()/2});
        });
    });
</script>
<style>
.popover.delegation{
    min-width:auto !important;
    width:auto !important;
}
#delete-block{
    text-align:center;
}
#delete-block button{
    margin-top:5px;
    width:75px;
}
.popover.delegation .popover-content {
    padding: 9px 14px !important;
}
.table .btn{
    margin:0;
}
    .dropselect1{
        min-width:190px !important;
        width:190px !important;
    }
    .huistory ul{
        position: relative;
        top: 0;
        border:none;
        margin: 0;
            list-style-type: none;
    padding: 0;
    }
    .huistory a{
        border:none;
        display:block;
        width:100%;
        background:none !important;
        color: #7b7b7b !important;
        padding: 0 !important;
        line-height: 30px;
        text-decoration: none;
        text-align: center;
    }
    .huistory a:hover{
        background:#8eb6f8 !important;
        color:#fff !important;
        border-radius:3px;
    }
    .huistory a.delete+.popover,.huistory a.delete+.popover .popover-title{
        background: #fff;
    border: none;
    text-align: center;
    padding:0;
    }
    .huistory a.delete+.popover{
        padding:15px 10px 6px;
            min-width: 250px;
    }
    .huistory a.delete+.popover button{
        width:83px;
        margin:15px 5px;

    }
</style>
<script>
$(document).ready(function () {
    $(".huistory a.team").popover({
        container: 'body',
        placement: "right",
        html:true,
        template:'<div class="popover delegation" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
        content : 'Will be available in the next version'
    });
  /*  $(".huistory a.delete").click(function(){
            $(this).confirmation({
                title: "Are you sure you want to delete <?php //echo $current_userTool->name?> ?",
                placement: "right",
                btnOkClass: "btn btn-success",
                btnCancelClass: "btn btn-danger",
                btnOkLabel: '<i class="icon-ok-sign icon-white"></i> Yes',
                onConfirm: function (event) {
                    $(this).confirmation('destroy');
                },
                onCancel: function (event) {
                    $(this).confirmation('destroy');
                    return false;
                }
            });
            $(this).confirmation('show');
        });*/
    $("#contribute-modal").modal();
    $(".dropmenu1.history1").popover({
        placement:"bottom",
        html:true,
        content:$("#huistory-one"),
        container:$("body"),
        template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
    });
    $(".dropmenu-two.history1").on('show.bs.popover',function(){
        $("#huistory-one").show();
        $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
    }).on('hide.bs.popover',function(){
        $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
    });
    $(".well > .nav-tabs li a").on('shown.bs.tab',function(){
        console.log("asdasd");
        $(".dropmenu-two.history1").popover({
            placement:"bottom",
            html:true,
            content:$("#huistory-one"),
            container:$("body"),
            template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
        });
        $(".dropmenu-two.history1").on('show.bs.popover',function(){
            $("#huistory-one").show();
            $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
        }).on('hide.bs.popover',function(){
            $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
        });
    });
});
</script>
<script>
    $(document).on('change',function(){
        $('.page-content').mCustomScrollbar({
            setHeight: $('.page-content').css('minHeight'),
            theme:"dark",
            advanced:{
                autoScrollOnFocus: false,
                updateOnContentResize: true,
                updateOnBrowserResize: true
            }
        });
    });

    $(document).ready(function () {
        $("table tr td a.name").popover({
            container:$("body"),
            trigger:"hover",
            template:'<div class="popover tname" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
        });
        $(".page-content-wrapper").mCustomScrollbar("destroy");
        $('.page-content-wrapper').mCustomScrollbar({
            setHeight: $('.page-content').css('minHeight'),
            theme:"dark",
            advanced:{
                autoScrollOnFocus: false,
                updateOnContentResize: true,
                updateOnBrowserResize: true
            }
        });
        $(".tables-business > .well > .nav-tabs a[data-toggle='tab']").on('show.bs.tab',function(){
            $("table tr td a.name").popover({
                container:$("body"),
                trigger:"hover",
                template:'<div class="popover tname" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
            });
            window.location.hash = $(this).attr('href');
            $(".page-content-wrapper").mCustomScrollbar("destroy");
            $('.page-content-wrapper').mCustomScrollbar({
                setHeight: $('.page-content').css('minHeight'),
                theme:"dark",
                advanced:{
                autoScrollOnFocus: false,
                updateOnContentResize: true,
                updateOnBrowserResize: true
            }
            });
            $("#find_job").on('shown.bs.collapse',function(){
                $(".toggle-findjod .fa").removeClass('fa-angle-down').addClass('fa-angle-up');
                $(".page-content-wrapper").mCustomScrollbar("destroy");
                $('.page-content-wrapper').mCustomScrollbar({
                    setHeight: $('.page-content').css('minHeight'),
                    theme:"dark",
                        advanced:{
                        autoScrollOnFocus: false,
                        updateOnContentResize: true,
                        updateOnBrowserResize: true
                    }
                });
            });
            $("#find_job").on('hidden.bs.collapse',function(){
                $(".toggle-findjod .fa").removeClass('fa-angle-up').addClass('fa-angle-down');
                $(".page-content-wrapper").mCustomScrollbar("destroy");
                $('.page-content-wrapper').mCustomScrollbar({
                    setHeight: $('.page-content').css('minHeight'),
                    theme:"dark",
                    advanced:{
                        autoScrollOnFocus: false,
                        updateOnContentResize: true,
                        updateOnBrowserResize: true
                    }
                });
            });
        });
        $(".tables-business > .well > .nav-tabs a[data-toggle='tab']").click(function(){
            
            $("#find_job").on('shown.bs.collapse',function(){
                $(".toggle-findjod .fa").removeClass('fa-angle-down').addClass('fa-angle-up');
            });
            $("#find_job").on('hidden.bs.collapse',function(){
                $(".toggle-findjod .fa").removeClass('fa-angle-up').addClass('fa-angle-down');
            });
            $("#find_job").collapse('hide');
            //$(".toggle-findjod").attr('href', '/departments/business#delegated');
            $(".toggle-findjod .fa").removeClass('fa-angle-up').addClass('fa-angle-down');

        });
    });

</script>