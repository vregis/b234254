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
<?php $this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css");?>
<?php $this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js");?>
<?php $this->registerCssFile("/metronic/theme/assets/global/plugins/select2/css/select2.min.css"); ?>
<?php $this->registerCssFile("/metronic/theme/assets/global/plugins/select2/css/select2-bootstrap.min.css"); ?>
<div class="col-md-12 tables-business">
    <div class="well" style="margin: 0 auto; max-width: 1000px">
                <div class="text-center btn-div" style="padding-bottom:30px;">
                    <a href="<?= Url::toRoute(['/departments/business/create']) ?>" style="padding: 0px 75px;line-height: 45px !important;height: 45px;vertical-align: middle;" class="btn btn-primary">Add new idea</a>
                </div>
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
                        <th width="260"> Business Name </th>
                        <th style="width: 52px;"> <button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button> </th>
                        <th width="170"> Industry </th>
                        <th width="170"> Location </th>
                        <th width="100"> Total tasks </th>
                        <th width="100"> My tasks </th>
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
                                <a href="javascript:;" style="padding-top: 1px;padding-left: 1px;" class="dropmenu<?php echo $i?> history btn btn-primary circle" data-toggle="popover" data-not_autoclose="1"><i class="ico-history"></i></a>
                            </td>
                            <td style="text-transform: uppercase">
                                <a href="<?= Url::toRoute(['/departments/business/select-tool', 'id' => $current_userTool->id]) ?>"
                                <?php if(strlen($current_userTool->name) >37):?>
                                     data-toggle="popover" data-placement="bottom" data-content="<?= $current_userTool->name ?>"
                                <?php endif;?>
                                 style="display: block;width: 269px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;" 
                                 class="name"
                                ><?= $current_userTool->name ? $current_userTool->name : 'No name' ?> <!--<span class="label label-danger circle"></span>--></a>
                            </td>
                            <td>
                                <a href="/user/social/shared-profile?id=88" target="_blank">
                                    <img onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" style="margin:0;" class="active gant_avatar mCS_img_loaded" src="/images/avatar/nophoto.png" >
                                </a>
                            </td>
                            <td>
                                Industry
                            </td>
                            <td>
                                Location
                            </td>
                            <td>
                                23
                            </td>
                            <td>
                                12
                            </td>
                        </tr>
                        <div id="huistory<?php echo $i?>" class="huistory" style="display:none;">
                            <a href="<?= Url::toRoute(['/departments/business/shared-business','id' => $current_userTool->id]) ?>" target="_blank">View Business</a>
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
                    <? require __DIR__.'/blocks/pagination.php' ?>
                    </tbody>
                </table>

                <? endif; ?>

                <div class="text-center btn-div" style="padding-top:30px;">
                    <?php $do = \modules\departments\models\UserDo::find()->where(['user_id' => Yii::$app->user->id, 'status_sell' => 1])->all();?>
                    <?php if(count($do) == 0):?>
                        <p>Fill in the information about your skills before look for a job</p>
                        <a href="/core/profile" style="padding: 0px 75px;line-height: 45px !important;height: 45px;vertical-align: middle;" class="btn btn-lg btn-primary" >Go To Profile</a>
                    <?php else:?>
                    <a href="#delegated#open" style="padding: 0px 75px;line-height: 45px !important;height: 45px;vertical-align: middle;" class="btn btn-primary toggle-findjod" data-toggle="collapse" data-target="#find_job" aria-expanded="false">Search</a>
                    <?php endif;?>
                </div>
                <div id="find_job" class="collapse in slidePop">
                <?php $i = 0;?>
                <? foreach($self_userTools as $cur) : ?>
                    <?php if($cur->name):?>
                        <?php $i++;?>
                    <?php endif;?>
                <?php endforeach;?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 52px;"><a href="#" class="btn btn-primary circle static" style="margin:0;border:none !important;font-size: 24px;line-height: 42px !important;padding-left: 1px;padding-top: 1px;"><i class="ico-history"></i></a></th>
                        <th width="260"> Business Name </th>
                        <th style="width: 52px;"> <button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button> </th>
                        <th width="170">
                            <select name="industry" id="" class="selectpicker">
                                <option value="" class="start">Industry</option>
                                <option value="">Art</option>
                                <option value="">Bar</option>
                            </select>
                        </th>
                        <th class="dropmenu filter-task deps" width="170">
                            <select name="industry" id="" class="selectpicker">
                                <option value="" class="start">Location</option>
                                <option value="">USA</option>
                                <option value="">Ukraine</option>
                            </select>
                        </th>
                        <th width="100"> Total tasks </th>
                        <th width="100"> My tasks </th>
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
                                <a href="javascript:;" style="padding-top: 1px;padding-left: 1px;" class="dropmenu<?php echo $i?> history btn btn-primary circle" data-toggle="popover" data-not_autoclose="1"><i class="ico-history"></i></a>
                            </td>
                            <td style="text-transform: uppercase">
                                <a href="<?= Url::toRoute(['/departments/business/select-tool', 'id' => $current_userTool->id]) ?>"
                                <?php if(strlen($current_userTool->name) >37):?>
                                     data-toggle="popover" data-placement="bottom" data-content="<?= $current_userTool->name ?>"
                                <?php endif;?>
                                 style="display: block;width: 269px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;" 
                                 class="name"
                                ><?= $current_userTool->name ? $current_userTool->name : 'No name' ?> <!--<span class="label label-danger circle"></span>--></a>
                            </td>
                            <td>
                                <a href="/user/social/shared-profile?id=88" target="_blank">
                                    <img onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" style="margin:0;" class="active gant_avatar mCS_img_loaded" src="/images/avatar/nophoto.png" >
                                </a>
                            </td>
                            <td>
                                Industry
                            </td>
                            <td>
                                Location
                            </td>
                            <td>
                                23
                            </td>
                            <td>
                                12
                            </td>
                        </tr>
                        <div id="huistory<?php echo $i?>" class="huistory" style="display:none;">
                            <a href="<?= Url::toRoute(['/departments/business/shared-business','id' => $current_userTool->id]) ?>" target="_blank">View Business</a>
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
                    <? require __DIR__.'/blocks/pagination.php' ?>
                    </tbody>
                </table>
                </div>

                <? //require __DIR__.'/blocks/find_job.php' ?>           
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
            $(".toggle-findjod").click(function(){
               $(this).toggleClass('active');
            });
    });
</script>
<style>
    .mCSB_outside + .mCSB_scrollTools {
        right: -13px;
    }
    table th .fa{
        margin-left:10px;
    }
    table th.rate .fa,table th.time .fa{
        position:absolute;
        margin-top:4px;
    }
    table th.rate,table th.time{
        cursor:pointer;
    }
    table th.rate{
        text-align:right;
        padding-right:30px !important;
        padding-left:0 !important;
    }
    table th.time{
        padding-right:40px !important;
        padding-left:0 !important;
        text-align:right;
    }
    .select-all{
        width:100px;
        height:28px;
    }
    #advanced-search-form{
        border:none;
    }
    .popover{
        min-width: 420px;
        border:1px solid #d7d7d7;
        padding: 10px;
        /*white-space: nowrap;*/
        /*background: #ebebeb;*/
        border-radius:10px !important;
        box-shadow: 0 0 32px 0 rgba(139,139,143,0.34) !important;
        border: 1px solid #dae2ea;
    }
    .advanced-search-btn+.popover .popover-content{
        padding:0;
        width: 410px;
        height:239px;
    }
    .popover.bottom > .arrow:after {
        border-bottom-color: #FFF !important;
    }
    .popover.top > .arrow:after {
        border-top-color: #FFF !important;
    }
    .popover.right > .arrow:after {
        border-right-color: #fff !important;
    }
    .popover .popover-content,.advanced-search-btn+.popover .popover-content{
        background: #fff;
        /*border: 1px solid #d7d7d7;*/
    }
    .dropselect,.dropselect1{
        min-width:195px !important;
        width:195px !important;
    }
/*     .dropselect1{
        min-width:150px !important;
        width:150px !important;
    } */
    .dropselect .popover-content,.dropselect1 .popover-content{
        padding: 0;
    }
    .dropselect a{
        display: block;
        width: 100%;
        text-align: center;
        line-height: 30px;
        font-size: 16px;
        color: #7b7b7b;
        text-decoration: none;
        /*border-bottom: 1px solid #d7d7d7;*/
        border-radius:3px;
        margin-bottom:1px;
    }
    #status-menu ul{
        position: relative;
        top: 0;
        border:none;
        margin: 0;
    }
    #status-menu a{
        border:none;
        display:block;
        width:100%;
        background:none !important;
        color: #7b7b7b !important;
        padding: 0 !important;
        line-height: 30px;
    }
    #status-menu li{
        display:block;
        width:100%;
        float:none;
    }
    #status-menu li.active a{
        background:#8eb6f8 !important;
        color:#fff !important;
        border-radius:3px;
    }
    .dropmenu,.dropmenu1{
        cursor: pointer;
        padding:0 !important;
    }
    .dropmenu .trigger{
        height:50px;
        line-height:50px;
    }
    .dropmenu > div:first-child{
        padding:0px;
    }
    .dropmenu .popover{
        top:100%;
    }
    .dropselect a:last-child {
        border-bottom: 0;
    }

    .dropselect a.off{
        color:rgba(123,123,123,0.5);
    }
    .background-1.on{
        background-color: rgba(145, 135, 208,0.6);
    }
    .background-2.on{
        background-color: rgba(183, 135, 209,0.6);
    }
    .background-3.on{
        background-color: rgba(253, 109, 100,0.6);
    }
    .background-4.on{
        background-color: rgba(255, 162, 93,0.6);
    }
    .background-5.on{
        background-color: rgba(255, 209, 71,0.6);
    }
    .background-6.on{
        background-color: rgba(170,215,114,0.6);
    }
    .background-7.on{
        background-color: rgba(112,202,200,0.6);
    }
    .background-8.on{
        background-color: rgba(93,201,240,0.6);
    }
    #input-rate-start,#input-rate-end{
        background: #fff url("/images/cost-bg.png") 7px 0 no-repeat;
        padding-left: 30px;
    }
    .advanced-search-btn+.popover.top > .arrow {
        left: 28px !important;
    }
    label{
        text-indent: 12px;
    }
    .bootstrap-select.btn-group .dropdown-toggle .filter-option{
        line-height: 30px;
    }
    .pagination{
        position: absolute;
        z-index: 1;
        margin: 0;
        display: block;
        margin-top: 17px;
        left:50%;
    }
    .btn.info {
        width: 18px !important;
        height: 18px;
        padding: 0;
        line-height: 18px !important;
        font-size: 12px;
    }
    .dropmenu{
        cursor: pointer;
    }
    .popover.avatar{
        text-align:center;
        min-width:185px;
        color:#5a5a5a;
    }
</style>
<script>
    $( document ).ready(function() {
        $("#find_job").on('shown.bs.collapse',function(){
            $(".btn.info").popover({
                placement:"top",
                html:true
            });
            $(".selectpicker").selectpicker();
            $("table th.rate,table th.time").click(function(){
                if($(this).find('i').hasClass('fa-angle-down'))
                    $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
                else
                    $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
            });
            $(".gant_avatar").popover({
                container:$("body"),
                html:true,
                template:'<div class="popover avatar" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                trigger:"click"
            });
            $(".dropmenu1.status").popover({
                placement:"bottom",
                html:true,
                content:$("#status-menu"),
                // container:$("body"),
                template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
            });
            $(".dropmenu1.status").on('shown.bs.popover',function(){
                //$("#status-menu li").removeClass('active');
                // if($("#request-block").hasClass('in')){
                //     $("#btn-request-block").parent().addClass('active');
                //     console.log('reuest');
                // }else{
                //     $("#btn-task-block").parent().addClass('active');
                //     console.log("search");
                //     // $("#btn-request-block").parent().removeClass('active');
                // }
                $("#status-menu a[data-toggle='tab']").click(function(){
                    if($(this).parent().hasClass('disabled')){
                        return false;
                    }else{
                        $(this).tab('show');
                    }
                });
            });
            $(".btn.info").on('show.bs.popover',function(){
                $(".gant_avatar,table tr td.name .pull-left").popover('destroy');
            }).on('hide.bs.popover',function(){
                $(".gant_avatar").popover({
                    container:$("body"),
                    html:true,
                    template:'<div class="popover avatar" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                    trigger:"click"
                });
                $("table tr td.name .pull-left").popover({
                    container:$("body"),
                    trigger:"hover"
                });
            });

            $("table tr td.name .pull-left").popover({
                container:$("body"),
                trigger:"hover"
            });
            $(".dropmenu1").on('show.bs.popover',function(){
                $("#status-menu").show();
                $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
            }).on('hide.bs.popover',function(){
                $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
            });
            $(".dropmenu .trigger").click(function(){
                var that = $(this).parent('.dropmenu');
                
                if(!$(this).next('.dropselect').is(":visible")){
                    $('.dropselect').hide();
                    $(".dropmenu").find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                    $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
                    $(".gant_avatar,table tr td.name .pull-left").popover('destroy');

                }else{
                    $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                    $(".gant_avatar").popover({
                        container:$("body"),
                        html:true,
                        template:'<div class="popover avatar" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                        trigger:"click"
                    });
                    $("table tr td.name .pull-left").popover({
                        container:$("body"),
                        trigger:"hover"
                    });

                }
                $(this).next('.dropselect').toggle();
                 return false;
            });

            $('html').click(function(e) {
                $('.dropselect').hide(); 
                $('.dropmenu').find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                    $(".gant_avatar").popover({
                        container:$("body"),
                        html:true,
                        template:'<div class="popover avatar" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                        trigger:"click"
                    });
                    $("table tr td.name .pull-left").popover({
                        container:$("body"),
                        trigger:"hover"
                    });
                });
                
            $('.dropselect').click(function(e){
                e.stopPropagation();
            });
            $("#search-block .pagination").css({
                'margin-left': "-" + ($("#search-block .pagination").width() / 2) + "px",
            });
            $('#find_job a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                e.target // newly activated tab
                e.relatedTarget // previous active tab
                $(".pagination").css({
                    'margin-left': "-" + ($($(this).attr('href')).find(".pagination").width() / 2) + "px",
                });
                $(".btn.info").popover({
                    placement:"top",
                    html:true
                });
            });
        });
        $('.selectpicker').selectpicker({});
        $("#input-rate-start,#input-rate-end").inputmask({
            "mask": "9",
            "repeat": 3,
            "greedy": false,
        }); // 
        $(".advanced-search-btn").popover({
            placement:"auto top",
            html:true,
            trigger:"click",
            content:$("#advanced-search-form")
        });

        $(".advanced-search-btn").on('show.bs.popover',function(e){
            $('#advanced-search-form-dom').html('');
            $("#advanced-search-form").show();

            $.each($('#advanced-search-form .dropdown-menu.inner'),function(){
                // e.preventDefault();
                var els = $(this).find('li');
                console.log(els.length);
                if(els.length > 8){
                    $(this).mCustomScrollbar({
                        setHeight: 252,
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }else{
                    $(this).mCustomScrollbar({
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }
                $(this).mCustomScrollbar('update');
            });
        });
        $(".advanced-search-btn").on('hide.bs.popover',function(){
            $('#advanced-search-form-dom').html($('.popover.in').html());
        });

        function setHandlerPagination(table) {

            function goPage(page_id) {
                table.find('.user-row').each(function() {
                    var cur_page_id = parseInt($(this).attr('data-page-id'));
                    if(cur_page_id != page_id) {
                        $(this).attr('style','display: none');
                    }else {
                        $(this).attr('style','display: table-row');
                    }
                });
                table.find('.go-page').each(function() {
                    var cur_page_id = parseInt($(this).attr('data-page-id'));
                    var li = $(this).closest('li');
                    if(cur_page_id != page_id) {
                        li.removeClass('active');
                    }else {
                        li.addClass('active');
                    }
                });
                var prev_li = table.find('.prev-page').closest('li');
                if(page_id!=0) {
                    prev_li.removeClass('disabled');
                }else {
                    prev_li.addClass('disabled');
                }
                var next_li = table.find('.next-page').closest('li');
                if(page_id!=go_page.length-1) {
                    next_li.removeClass('disabled');
                }else {
                    next_li.addClass('disabled');
                }
                table.find('.button-select').each(function() {
                    $(this).removeClass('active');
                });
                table.find('.make-ajax').removeClass('active');
            }
            var go_page = table.find('.go-page');
            go_page.off();
            go_page.on('click', function(){
                if(!$(this).closest('li').hasClass('active')) {
                    var page_id = parseInt($(this).attr('data-page-id'));
                    goPage(page_id);
                }
            });
            var prev_page = table.find('.prev-page');
            prev_page.off();
            prev_page.on('click', function(){
                if(!$(this).closest('li').hasClass('disabled')) {
                    var page_id = parseInt(table.find('.pagination li.active .go-page').attr('data-page-id'));
                    goPage(page_id - 1);
                }
            });
            var next_page = table.find('.next-page');
            next_page.off();
            next_page.on('click', function(){
                if(!$(this).closest('li').hasClass('disabled')) {
                    var page_id = parseInt(table.find('.pagination li.active .go-page').attr('data-page-id'));
                    goPage(page_id + 1);
                }
            });
        }

        function set_user_task(_this, html) {
            if(html!=undefined) {
                _this.html(html);
            }else {
                _this = $('#user_task');
            }
            var button_select = _this.find('.button-select');
            button_select.off();
            button_select.on('click', function(){
                $(this).toggleClass("active");

                $("#request").addClass('active');
                if(_this.closest('.table').find('.button-select.active').length == 0){
                    $("#request").removeClass('active');
                }
            });
            setHandlerPagination(_this.closest('.table'));
            var on = $('.on');
            on.off();
            on.on('click',function(e) { //TODO this function
                var count = $(this).closest('div').find('.on').length;
                if(count > 1) {
                    $(this).removeClass('on');
                    $(this).addClass('off');
                    if($(this).closest('.filter-task').length > 0) {
                        if($(this).closest('#request-block').length > 0){
                            get_user_task_pending(false);
                        }else{
                            get_user_task(false);
                        }
                    }
                    else {
                        get_user_request(false);
                    }
                }
            });
            var off = $('.off');
            off.off();
            off.on('click',function(e) { //click from off
                $(this).removeClass('off');
                $(this).addClass('on');
                var is_dep = false;
                if($(this).closest('.deps-menu').length > 0) {
                    is_dep = true;
                    var dep_idd = $(this).attr('data-id');
                }

                if($(this).closest('.filter-task').length > 0) {
                    if($(this).closest('#request-block').length > 0){
                        get_user_task_pending(false, is_dep, dep_idd);
                    }else{
                        get_user_task(false, is_dep);
                    }

                }else {
                    get_user_request(is_dep);
                }
            });
            $.each($('.spec-menu .popover-content'),function(){
                var els = $(this).find('a');
                if(els.length > 8){
                    $(this).mCustomScrollbar({
                        setHeight: 250,
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }else{
                    $(this).mCustomScrollbar({
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }
            });

        }
        function set_user_request(_this, html) {
            if(html!=undefined) {
                _this.html(html);

            }
            var button_select = _this.find('.button-select');
            button_select.off();
            button_select.on('click', function(){
                $(this).toggleClass("active");

                $("#reject").addClass('active');
                if(_this.closest('.table').find('.button-select.active').length == 0){
                    $("#reject").removeClass('active');
                }
            });

            if(button_select.length == 0) {
                var btn_request_block = $('#btn-request-block');
                btn_request_block.removeAttr('data-toggle');
                btn_request_block.removeAttr('href');
                btn_request_block.removeAttr('css');
                btn_request_block.parent().addClass('disabled').removeClass('active');
                $('#btn-task-block').tab('show');
            }else {
                var btn_request_block = $('#btn-request-block');
                btn_request_block.attr('data-toggle','tab');
                btn_request_block.attr('href','#request-block');
                btn_request_block.parent().removeClass('disabled');
            }
            setHandlerPagination(_this.closest('.table'));

        }

        $('#request').on('click', function(){
            var ids = [];
            var task_ids = [];
            var names = "";
            var i=0;
            $('#user_task').find('.button-select').each(function() {
                if($(this).hasClass("active")) {
                    ids.push($(this).attr('data-id'));
                    task_ids.push($(this).attr('data-task-id'));
                    if(i != 0) {
                        names += ", ";
                    }
                    names += $(this).closest('.user-row').find('.name').find('.pull-left').text();
                    i++;
                }
            });

            if(ids.length > 0) {
                $.ajax({
                    url: '/departments/business/request',
                    type: 'post',
                    dataType: 'json',
                    data: Object.assign({
                        _csrf: $("meta[name=csrf-token]").attr("content"),
                        user_ids: ids,
                        user_task_ids: task_ids,
                        start: $("#input-rate-start").val(),
                        end: $("#input-rate-end").val()
                    }, get_find_params()),
                    success: function (response) {
                        if (!response.error) {
                            $(".dropmenu1.status").popover('show').on('shown.bs.popover',function(){

                                // $("#status-menu a[data-toggle='tab']").click(function(){
                                //     if($(this).parent().hasClass('disabled')){
                                //         return false;
                                //     }else{
                                //         $(this).tab('show');
                                //     }
                                // });
                                //$("#btn-request-block").parent().removeClass('active');

                                $("#btn-task-block").parent().addClass('active');
                                $("#btn-task-block").tab('show');  
                                var btn_request_block = $('#btn-request-block');
                                btn_request_block.parent().removeClass('disabled');
                                btn_request_block.attr('data-toggle','tab');
                                btn_request_block.attr('href','#request-block'); 
                                $("#status-menu li").removeClass('active');
                                if($("#request-block").hasClass('in')){
                                    $("#btn-request-block").parent().addClass('active');
                                    console.log('reuest1');
                                }else{
                                    $("#btn-task-block").parent().addClass('active');
                                    console.log("search1");
                                    // $("#btn-request-block").parent().removeClass('active');
                                }               
                            }).popover('hide');

                            console.log("hui");
                            $('.filter-task .deps-menu').html(response.html_deps_filter);
                            $('.filter-task .spec-menu').html(response.html_specials_filter);
                            set_user_task($('#user_task'), response.html_user_task);
                            set_user_request($('#user_request'), response.html_user_request);
                            $('#delegated_businesses').html(response.html_delegated_businesses);
                        }
                    }
                });
                $(this).removeClass('active');
            }
        });
        $('#reject').on('click', function(){
            var ids = [];
            var names = "";
            var i=0;
            $('#user_request').find('.button-select').each(function() {
                if($(this).hasClass("active")) {
                    ids.push($(this).attr('data-id'));
                    if(i != 0) {
                        names += ", ";
                    }
                    names += $(this).closest('.user-row').find('.name').find('.pull-left').text();
                    i++;
                }
            });

            if(ids.length > 0) {
                $.ajax({
                    url: '/departments/business/reject',
                    type: 'post',
                    dataType: 'json',
                    data: Object.assign({
                        _csrf: $("meta[name=csrf-token]").attr("content"),
                        user_ids: ids,
                        start: $("#input-rate-start").val(),
                        end: $("#input-rate-end").val()
                    }, get_find_params()),
                    success: function (response) {
                        if (!response.error) {
                            $('.filter-task .deps-menu').html(response.html_deps_filter);
                            $('.filter-task .spec-menu').html(response.html_specials_filter);
                            set_user_task($('#user_task'), response.html_user_task);
                            set_user_request($('#user_request'), response.html_user_request);
                            $('#delegated_businesses').html(response.html_delegated_businesses);
                            if(response.html_user_request == ''){
                                // Сюда впили переход на серч
                                                                $("#status-menu li").removeClass('active');
                                if($("#request-block").hasClass('in')){
                                    $("#btn-request-block").parent().addClass('active');
                                    console.log('reuest2');
                                }else{
                                    $("#btn-task-block").parent().addClass('active');
                                    console.log("search2");
                                    // $("#btn-request-block").parent().removeClass('active');
                                }
                                $("#task-block").addClass('in active');
                                $("#request-block").removeClass('in active');
                                $("#btn-task-block").parents('li').addClass('active');
                                $(".dropmenu1.status").popover('show').on('shown.bs.popover',function(){
                                    $("#btn-request-block").parent().removeClass('active').addClass('disabled');
                                    var btn_request_block = $('#btn-request-block');
                                    btn_request_block.removeAttr('data-toggle');
                                    btn_request_block.removeAttr('href');
                                    btn_request_block.removeAttr('css');
                                    $("#btn-task-block").parent().addClass('active');
                                    $("#btn-task-block").tab('show');                  
                                }).popover('hide');
                            }
                        }
                    }
                });
                $(this).removeClass('active');
            }
        });
        set_user_task($('#user_task'));
        set_user_request($('#user_request'));

        $('.select-all').on('click', function(){
            var select_all = $(this);
            var table = select_all.closest('.table');
            table.find('.user-row').each(function() {
                if($(this).css('display') != 'none') {
                    $(this).find('.button-select').addClass("active");
                }
            });
            table.find('.make-ajax').addClass("active");
        });

        function get_find_params(is_advance) {
            if(is_advance == undefined) {
                is_advance = false;
            }
            var country = 0;
            if($('#select-country').length > 0)
            {
                country = $('#select-country').val();
            }
            var rate_start = 0;
            if($('#input-rate-start').length > 0)
            {
                rate_start = $('#input-rate-start').val();
            }
            var rate_end = 0;
            if($('#input-rate-end').length > 0)
            {
                rate_end = $('#input-rate-end').val();
            }
            var department = 0;
            if($('#select-department').length > 0)
            {
                department = $('#select-department').val();
            }
            var special = 0;
            if($('#select-special').length > 0)
            {
                special = $('#select-special').val();
            }
            var is_request = false;
            if(!is_advance) {
                var deps = [];
                var tab = $('#task-block');
                if(!tab.hasClass('in')) {
                    tab = $('#request-block')
                    is_request = true;
                }
                tab.find('.deps-menu').find('.on').each(function() {
                    deps.push($(this).attr('data-id'));
                });
                var spec = [];
                tab.find('.spec-menu').find('.on').each(function() {
                    spec.push($(this).attr('data-id'));
                });
            }
            return {
                country: country,
                rate_start: rate_start,
                rate_end: rate_end,
                department: department,
                special: special,
                deps: deps,
                spec: spec,
                is_request: is_request
            };
        }

        function get_user_task(is_advance, is_dep) {
            if(is_advance == undefined) {
                is_advance = false;
            }
            if(is_dep == undefined) {
                is_dep = false;
            }
            if(is_dep == true){
                var click_dep = 1;
            }else{
                var click_dep = 0;
            }
            $.ajax({
                url: '/departments/business/user-task',
                type: 'post',
                dataType: 'json',
                data: Object.assign({
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    is_dep: is_dep,
                    click_dep: click_dep
                }, get_find_params(is_advance)),
                success: function (response) {
                    if (!response.error) {
                        $('#user_task').find('.filter-task .deps-menu').html(response.html_deps_filter);
                        $('#user_task').find('.filter-task .spec-menu').html(response.html_specials_filter);
                        set_user_task($('#user_task'), response.html_user_task);
                        set_user_request($('#user_request'), response.html_user_request);
                        $('#delegated_businesses').html(response.html_delegated_businesses);
                    }
                }
            });
        }


        function get_user_task_pending(is_advance, is_dep, dep_idd) {
            if(is_advance == undefined) {
                is_advance = false;
            }
            if(is_dep == undefined) {
                is_dep = false;
            }
            if(is_dep == true){
                var click_dep = 1;
            }else{
                var click_dep = 0;
            }
            if(dep_idd == undefined){
                dep_idd = false;
            }
            console.log(get_find_params());
            $.ajax({
                url: '/departments/business/user-task-pending',
                type: 'post',
                dataType: 'json',
                data: Object.assign({
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    is_dep: is_dep,
                    click_dep: click_dep,
                    dep_idd:dep_idd
                }, get_find_params()),
                success: function (response) {
                    if (!response.error) {
                        $('#user_request').find('.filter-task .deps-menu').html(response.html_deps_filter);
                        $('#user_request').find('.filter-task .spec-menu').html(response.html_specials_filter);
                        set_user_task($('#user_task'), response.html_user_task);
                        set_user_request($('#user_request'), response.html_user_request);
                        $('#delegated_businesses').html(response.html_delegated_businesses);
                    }
                }
            });
        }



        function get_user_request(is_dep) {
            if(is_dep == undefined) {
                is_dep = false;
            }
            $.ajax({
                url: '/departments/business/user-request',
                type: 'post',
                dataType: 'json',
                data: Object.assign({
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    is_dep: is_dep
                }, get_find_params(false)),
                success: function (response) {
                    if (!response.error) {
                        $('.filter-request .deps-menu').html(response.html_deps_filter);
                        $('.filter-request .spec-menu').html(response.html_specials_filter);
                        set_user_task();
                        set_user_request($('#user_request'), response.html_user_request);
                        $('#delegated_businesses').html(response.html_delegated_businesses);
                    }
                }
            });
        }

        var advanced_send = $('#advanced-search-send');
        advanced_send.on('click',function(e) {
            get_user_task(true);
            $('.popover').each(function(){
                $(this).popover('hide');
            });
        });

        $('#select-department').on('change',function(e) {
            var department = $(this).val();
            $.ajax({
                url: '/departments/business/get-specials',
                type: 'post',
                dataType: 'json',
                data: {
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    department: department
                },
                success: function (response) {
                    if (!response.error) {
                        var select_special = $('#select-special');
                        select_special.html('<option class="start" value="0">Select speciality</option>' + response.html);
                        if(response.html != '') {
                            select_special.removeAttr('disabled');
                        }else {
                            select_special.attr('disabled','');
                        }
                        select_special.selectpicker('refresh');
                    }
                }
            });
        });

        $("#status-menu li.disabled").on('click',function(e){
            $("#btn-task-block").parent().addClass('active');
            $(this).removeClass('active');
            return false;
        });
        $('.time').find('.fa-angle-down').on('click', function(){

        })
    });
</script>