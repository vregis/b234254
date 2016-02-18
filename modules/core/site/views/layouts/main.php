
<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 4.0.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->

<?

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\departments\models\Department;
use modules\milestones\models\Milestone;
use modules\tasks\models\Task;
use \modules\user\models\Profile;
use modules\user\site\controllers\ProfileController;

$this->beginPage();
?>
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>BSB</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <?
    $this->registerMetaTag(['name' => 'csrf-param', 'content' => Yii::$app->getRequest()->csrfParam], 'csrf-param');
    $this->registerMetaTag(['name' => 'csrf-token', 'content' => Yii::$app->getRequest()->getCsrfToken()], 'csrf-token');

    require_once __DIR__ . '/metronic_blank.php';


    //$this->registerCssFile('/style/chat/style.css');

    //$this->registerJsFile('/js/chat/dialog.js');
    //$this->registerJsFile('/js/chat/chat.js');
    $this->registerJsFile('/js/lib/jquery.tooltipster.min.js');

    $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.min.js");
    $this->registerJsFile("/plugins/switchery/dist/switchery.js");
    $this->registerCssFile("/plugins/switchery/dist/switchery.css");
    $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-toastr/toastr.min.js");
    $this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-toastr/toastr.min.css");
    $this->registerCssFile("/plugins/custom-scrollbar-plugin/jquery.mCustomScrollbar.css");
    $this->registerJsFile("/plugins/custom-scrollbar-plugin/jquery.mCustomScrollbar.js");
    
    $this->registerCssFile("/plugins/bsb-icons/style.css");
    $this->registerCssFile("/css/main.css");
    $this->registerJsFile("/js/global/department.js");
    $this->registerJsFile("/js/global/index.js");
    $this->registerJsFile("/js/bootbox.min.js");
    $this->registerJsFile("/js/jquery.blockui.min.js");
    $this->registerJsFile("/js/app.js");
    $this->registerJsFile("/js/timer.js");

    $this->registerCssFile("/css/grid/320.css");
    $this->registerCssFile("/css/grid/375.css");
    $this->registerCssFile("/css/grid/414.css");
    $this->registerCssFile("/css/grid/480.css");
    $this->registerCssFile("/css/grid/568.css");
    $this->registerCssFile("/css/grid/667.css");
    $this->registerCssFile("/css/grid/736.css");
    $this->registerCssFile("/css/grid/768.css");
    $this->registerCssFile("/css/grid/1024.css");
    $this->registerCssFile("/css/grid/1280.css");
    $this->registerCssFile("/css/grid/1366.css");
    $this->registerCssFile("/css/grid/1680.css");
    $this->registerCssFile("/css/grid/1920.css");
    $this->registerCssFile("/css/grid/grid.css");



    $pos = ['position' => View::POS_HEAD];

    if(Yii::$app->controller->module->id == 'tasks' || Yii::$app->controller->module->id ==  'departments' || Yii::$app->controller->module->id ==  'core') {
        $departments = Department::find()->where(['is_additional' => false])->all();
        $department_active = 0;
        if(Yii::$app->controller->module->id == 'departments') {
            $department_active = !is_null(Yii::$app->request->get('id')) ? Yii::$app->request->get('id') : 1;
        }
        else if(Yii::$app->controller->module->id == 'tasks') {
            $task = Task::find()->where(['id' => Yii::$app->request->get('id')])->one();
            if(!is_null($task)) {
                $department_active = $task->department_id;
            }
        }
        $milestone_active = null;
        if(isset(Yii::$app->session['milestone_id'])) {
            $milestone_active = Milestone::find()->where(['id' => Yii::$app->session['milestone_id']])->one();
        }

        $milestones = Milestone::find()->all();

        $task_counts = [];
        foreach($departments as $department) {
            $task_counts[$department->id] = Task::find();
            $task_counts[$department->id]->join('LEFT JOIN', 'milestone', '`task`.milestone_id = `milestone`.`id`')->where(['milestone.is_pay'=>0]);
            $task_counts[$department->id]->andWhere(['department_id' => $department->id]);
            if(!is_null($milestone_active)) {
                $task_counts[$department->id]->andWhere(['milestone_id' => $milestone_active->id]);
            }
            $task_counts[$department->id] = $task_counts[$department->id]->count();
        }
    }

    ?>

    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/favicon.ico"/>

    <?php $this->head() ?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body>
<?php $this->beginBody() ?>
<div class="b-page-wrap">
    <!-- BEGIN HEADER -->
    <div class="page-header">
        <!-- BEGIN HEADER TOP -->
        <div class="page-header-top">
            <div class="page-container">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="/"><img src="/images/logo-default.png" alt="logo" class="logo-default"></a>
                </div>
                <!-- END LOGO -->
                <? if(Yii::$app->controller->module->id == 'tasks' || Yii::$app->controller->module->id ==  'departments' || Yii::$app->controller->module->id ==  'core') : ?>
                <div class="typeSwitch">
                    <a class="btn disabled off">Life </a>
                    <input type="checkbox" id="typeSwitch" checked class="js-switch js-check-change" name="view">
                    <a href="<?= Url::toRoute(['/departments/business']) ?>" class="btn business-switch" class="control-label bus">Business <span style="display:none" class="label label-danger circle">3</span></a>
                </div>

                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu navbar-notification mobile-small-nav">

                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN NOTIFICATION DROPDOWN -->
                        <!-- END TODO DROPDOWN -->
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <li class="dropdown dropdown-user dropdown-dark">
                            <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
                                <?php $model = Profile::find()->where(['user_id' => Yii::$app->user->getId()])->one();?>
                                <img style="height:33px; width:33px"  src="<?php echo $model->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$model->avatar:'/images/avatar/nophoto.png'?>" class="img-circle" alt="">

                                <?php if(ProfileController::checkprofile() == false):?>
                                    <span class="label label-danger circle"><span class="icon-bell"></span></span>
                                <?php endif;?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">

                                <li>
                                    <a href="/core/profile">
                                        <i class="icon-user"></i> My Profile
                                        <?php if(ProfileController::checkprofile() == false):?>
                                            <span data-container="body" data-toggle="popover" data-placement="left" data-content="Not all fields are filled profile" class="label label-danger circle"><span class="icon-bell"></span></span>
                                        <?php endif;?>
                                        </a>
                                </li>
                                <li class="divider">
                                <li>
                                    <a href="#" id="showtoast" data-content="Will be available in the next version">
                                        <i class="icon-users"></i> <span>Team</span>
                                    </a>
                                </li>
                                <li class="divider">
                                </li>
                                <?php $user = \modules\user\models\User::find()->where(['id' => Yii::$app->user->getId()])->one();?>
                                <?php if(isset($user) && $user != null && $user->role == 10):?>
                                    <li><a href = '/admin'><i class="fa fa-line-chart"></i> Admin panel</a></li><li class="divider">
                                    </li>
                                <?php endif;?>
                                <li>
                                    <?php $form = ActiveForm::begin(['action'=>'/user/logout']);
                                    ActiveForm::end();
                                    echo Html::a(
                                        '<i class="icon-key"></i> Log Out',
                                        Url::toRoute(['/user/logout']),
                                        ['data-method' => 'post']
                                    );
                                    ?>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <? endif; ?>
                <!-- END TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- END HEADER TOP -->
        <!-- BEGIN HEADER MENU -->
    </div>
    <!-- END HEADER -->

    <div class="page-container">
        <div class="page-content-wrapper">
            <div class="page-content">
                <?=$content;?>
            </div>
        </div>
    </div>
    <!-- Center Wrap END -->

    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
    <!-- <button type="button" class="quick-sidebar-toggler quick-sidebar-toggler-chat" data-toggle="collapse">
        <span class="sr-only">Toggle Quick Sidebar</span>
        <i class="icon-logout"></i>
    </button> -->
    <!-- END QUICK SIDEBAR TOGGLER -->



    <!-- BEGIN PRE-FOOTER -->
    <!-- END PRE-FOOTER -->


</div>




<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="container">
        <span><?php echo date('Y');?> © BSB</span> <span>All rights reserved</span>
            <a data-toggle="modal" href="#support" class="btn-support">Support</a>

    </div>
</div>
<!-- END FOOTER -->

<div class="scroll-to-top">
    <i class="icon-arrow-up"></i>
</div>

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php $this->endBody() ?>


<div style="color: rgb(169, 169, 169); font-size:14px" class="modal fade" id="support" tabindex="-1" role="status" class="md-dial" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Send message</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Theme</label>
                    <input required style="border-color: rgb(169, 169, 169); color: rgb(169, 169, 169); text-align:left; padding:3px; font-size:14px" type="text" class="form-control support_theme">
                </div>
                <div class="form-group">
                    <label>Problem description</label>
                    <textarea rows="10" style="width:100%; padding:10px" class="support_description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary support_send">Send</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $.uniform.restore("#typeSwitch");
    $.uniform.restore("#typeSwitch1");
    var elems = document.querySelectorAll('.js-switch');

    for (var i = 0; i < elems.length; i++) {
        if($(elems[i]).attr('data-color')){
            var attrs = {
                secondaryColor: "#6699cc",
                color:$(elems[i]).attr('data-color'),
                checkedText: 'G',
                unCheckedText: 'L',
                disabled: false,
                disabledOpacity:1
            }
        }else{
            var colorSwitch = "#64BD63";
            var attrs = {
                secondaryColor: "#6699cc",
                color:"#64BD63",
                disabled: true,
                disabledOpacity:1
            }
        }
        var switchery = new Switchery(elems[i], attrs);
    }
    var changeCheckbox = document.querySelector('.js-check-change');
    var changeCheckbox1 = document.querySelector('#typeSwitch1');
    if(changeCheckbox){
        $(".page-header .switchery").popover({
            container: 'body',
            placement: "bottom",
            content : 'Will be available in the next version'
        });
    }
   /* if(changeCheckbox1){
        if(changeCheckbox1.checked == true){
            $(".wrapper.list").fadeOut(500);
            $(".wrapper.gant").fadeIn(500);
            $(changeCheckbox1).parents('.typeSwitch').parents('.btns').parents('.info').parents('.panel-heading').parents('.panel').removeClass('list');
            $(changeCheckbox1).parents('.typeSwitch').parents('.btns').parents('.info').parents('.panel-heading').parents('.panel').addClass('gant');
        }else{
            $(".wrapper.gant").fadeOut(500);
            $(".wrapper.list").fadeIn(500);
            $(changeCheckbox1).parents('.typeSwitch').parents('.btns').parents('.info').parents('.panel-heading').parents('.panel').removeClass('gant');
            $(changeCheckbox1).parents('.typeSwitch').parents('.btns').parents('.info').parents('.panel-heading').parents('.panel').addClass('list');
        }
    }*/


    $(document).ready(function() {

        if((navigator.userAgent.indexOf ('Linux')!= -1 && navigator.userAgent.indexOf ('Android')== -1) || navigator.userAgent.indexOf ('Windows NT') != -1 || (navigator.userAgent.indexOf ('Mac')!= -1 && navigator.userAgent.indexOf ('iPad') == -1 && navigator.userAgent.indexOf ('iPhone') == -1)){
            // console.log("desktop");
        }else{
            $(".get-started").popover({
                placement: "top",
                content : 'Please use computer to access the tool.'
            }).click(function(e){e.preventDefault();});
            // console.log("Mobile");
        }
        $("div.ganttview-block-text .fa").click(function(){
            console.log("clicked on bar in gantt task");
        });
        $('.milestones .panel-heading .info .btn-info').popover({
            placement: "bottom",
            trigger: "click",
            html:true
        });
        $('.milestones .panel-heading .info .delegate').popover({
            placement: "bottom",
            trigger: "click",
            html:true,
            content: "Will be available in the next version"
        });
        $('.milestones .milestones-users img').popover({
            placement: "bottom",
            trigger: "click",
            html:true,
        });


        /*$.each($('div.ganttview-block'),function(){
            var dataid = $(this).attr("data-id");

            $.ajax({
                url: '/departments/getpopupdata',
                data: {id:dataid},
                dataType: 'json',
                type: 'post',
                async: false,
                success: function(response){
                    callback(response.name, response.spec, response.status);
                }
            })

            function callback(name, spec, status){
                dataname = name;
                dataspec = spec;
                datastatus = status;
            }


            $(this).find('.fa').popover({
                placement: "auto bottom",
                trigger: "click",
                html:true,
                container:$(".milestones .panel-body"),
                content: "<div class='name'>"+dataname+"</div> <div class='divider'></div> <div class='spec'>"+dataspec+"</div><div class='divider'></div> <div class='status'>"+datastatus+"</div><div class='divider'></div> <div class='btn-wrap sm'><a href='/tasks?id="+dataid+"' class='btn btn-block btn-cust'>Go to Task</a></div>",
            });


        });*/


        $('div.ganttview-block').find('.fa').popover({
            placement: "auto bottom",
            trigger: "click",
            html:true,
            container:$(".milestones .panel-body"),
            content: "<div class='name'>33</div> <div class='divider'></div> <div class='spec'></div><div class='divider'></div> <div class='status'></div><div class='divider'></div> <div class='btn-wrap sm'><a href='/tasks?id=' class='btn btn-block btn-cust'>Go to Task</a></div>",
        });


        $.each($(".panel-toggle"),function(){
            if($(this).attr('aria-expanded') == "true"){
                $(this).find('.fa').removeClass('fa-angle-down').addClass('fa-angle-up');
                $(this).parent('.info').find('.btns').find('.typeSwitch').removeClass('hide').show();
                $(this).parent('.info').find('.btns').find('.label').hide();
                $(this).prev('.panel-heading').find('.hor-menu').show();
            }else{
                $(this).find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
                $(this).parent('.info').find('.btns').find('.label').show();
                $(this).prev('.panel-heading').find('.hor-menu').hide();
            }
        });
        $('.collapse').on('hidden.bs.collapse', function () {
            $('.panel-heading').find('.info').find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
            $(this).prev('.panel-heading').find('.info').find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
            $(this).prev('.panel-heading').find('.info').find('.btns').find('.typeSwitch').hide();
            $(this).prev('.panel-heading').find('.info').find('.btns').find('.label').show();
            $(this).prev('.panel-heading').find('.hor-menu').hide();
            $(this).find("div.ganttview-slide-container").mCustomScrollbar("destroy");
        });
        $('.collapse').on('show.bs.collapse', function () {
            $('.collapse').not($(this)).collapse('hide');
        });
        $('.collapse').on('shown.bs.collapse', function () {
            $('.panel-heading').find('.info').find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
            $(this).prev('.panel-heading').find('.info').find('.fa').removeClass('fa-angle-down').addClass('fa-angle-up');
            $(this).prev('.panel-heading').find('.info').find('.btns').find('.typeSwitch').removeClass('hide').show();
            $(this).prev('.panel-heading').find('.info').find('.btns').find('.label').hide();
            $(this).prev('.panel-heading').find('.hor-menu').show();
            $("div.ganttview-slide-container").mCustomScrollbar("update");
            // $("div.ganttview-slide-container").mCustomScrollbar("scrollTo",0,{
            //     scrollInertia:1
            // });
            $(this).find('div.ganttview-slide-container').mCustomScrollbar({
                theme:"dark",
                axis:"x", // horizontal scrollbar
                contentTouchScroll: 25,
                documentTouchScroll: true,
                setLeft:0
            });



            /*var changeCheckbox1 = document.querySelector('#typeSwitch1');
            if(changeCheckbox1){
                changeCheckbox1.onchange = function() {
                    console.log(changeCheckbox1.checked);
                    if(changeCheckbox1.checked == true){
                        $(".wrapper.list").fadeOut(500);
                        $(".wrapper.gant").fadeIn(500);
                        $(changeCheckbox1).parents('.typeSwitch').parents('.btns').parents('.info').parents('.panel-heading').parents('.panel').removeClass('list');
                        $(changeCheckbox1).parents('.typeSwitch').parents('.btns').parents('.info').parents('.panel-heading').parents('.panel').addClass('gant');
                    }else{
                        $(".wrapper.gant").fadeOut(500);
                        $(".wrapper.list").fadeIn(500);
                        $(changeCheckbox1).parents('.typeSwitch').parents('.btns').parents('.info').parents('.panel-heading').parents('.panel').removeClass('gant');
                        $(changeCheckbox1).parents('.typeSwitch').parents('.btns').parents('.info').parents('.panel-heading').parents('.panel').addClass('list');
                    }
                };
            }*/
        });
        $('.page-header .page-header-top .top-menu .navbar-nav > li.dropdown-dark .dropdown-menu.dropdown-menu-default [data-toggle="popover"]').popover({
            placement: "left",
            trigger: 'hover'
        });
        $('.page-header .page-header-top .top-menu .navbar-nav .pop').popover({
            placement: "left",
            trigger: "hover",
        });
        $('#showtoast').click(function () {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "5000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                }
            toastr.info("Will be available in the next version");
        });

        $('body').on('hidden.bs.popover', function (e) {
            $(e.target).data("bs.popover").inState.click = false;
        });
        $('html').on('mouseup', function(e) {
            if(!$(e.target).closest('.popover').length) {
                $('.popover').each(function(){
                    var autoclose = true;
                    if($(this).find('.no-autoclose').length > 0) {
                        autoclose = false;
                    }
                    if(autoclose) {
                        $(this).popover('hide');
                    }
                });
            }
        });

        $(".navbar-ico-nav-toggler").click(function(){
            $("#navbar-ico-nav").toggle('slow');
            //$("#header_notification_bar").toggle('slow');
            //$("#header_task_bar").toggle('slow');
        });
        $(document).click(function(event) {
            if ($(event.target).closest(".navbar-ico-nav-toggler").length) return;
            if ($("#navbar-ico-nav").length)
            {
                if(App.getViewPort().width < 561) {
                    $("#navbar-ico-nav").hide('slow');
                }
                //$("#header_notification_bar").hide('slow');
                //$("#header_task_bar").hide('slow');
                event.stopPropagation();
            }
        });
    });
</script>

<?php if (!Yii::$app->user->isGuest) {
    //require_once Yii::getAlias('@modules').'/core/site/views/layouts/_partial/_newchat.php';
} ?>
</body>
<!-- END BODY -->

<div style="color: rgb(169, 169, 169); font-size:14px" class="modal fade" id="support" tabindex="-1" role="status" class="md-dial" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Send message</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Theme</label>
                    <input required style="border-color: rgb(169, 169, 169); color: rgb(169, 169, 169); text-align:left; font-size:14px" type="text" class="form-control support_theme">
                </div>
                <div class="form-group">
                    <label>Problem description</label>
                    <textarea rows="10" style="width:100%; padding:10px" class="support_description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary support_send">Send</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div id="task" class="modal fade" tabindex="-1" role="status" aria-hidden="true">
</div>

<script>

    $('#showchat').on('click', function(e){
        e.preventDefault();
        $('.newchat').show();
    })

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-center",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    $('.support_send').on('click', function(){

        var theme = $('.support_theme').val();
        var desc = $('.support_description').val();

        App.blockUI({
            target: '.modal-content',
            animate: true
        });

        /*window.setTimeout(function() {
         App.unblockUI('#blockui_sample_1_portlet_body');
         }, 2000);*/

        $.ajax({
            url: '/core/supportform',
            method: 'post',
            data: {theme:theme, desc:desc},
            dataType: 'json',
            success: function(response){
                if(response.error == true){
                    bootbox.alert("Something wrong. Please try again", function(){
                        window.location.reload();
                    });
                }else{
                    bootbox.alert("Your message has been sent", function(){
                        window.location.reload();
                    });
                }
            }
        })


    })
</script>
</html>
<?php $this->endPage() ?>
