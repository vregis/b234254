<!DOCTYPE html>

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
 //use kartik\social\FacebookPlugin;
 //use kartik\social\TwitterPlugin;


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
    <link rel="stylesheet" type="text/css" href="/fonts/Open Sans/OpenSans.css">
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css">
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/global/plugins/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/global/plugins/uniform/css/uniform.default.css">
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css">

    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/global/css/components.css">
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/global/css/plugins.css">


    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/global/plugins/bootstrap-toastr/toastr.min.css">

 
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/layouts/layout/css/layout.min.css">
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/layouts/layout/css/themes/darkblue.min.css">
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/layouts/layout/css/custom.css">



    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/respond.min.js"></script>
    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/excanvas.min.js"></script>


    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/jquery.min.js"></script>
    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/jquery.blockui.min.js"></script>
    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>


    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>



    <script type="text/javascript" src='/js/lib/jquery.tooltipster.min.js'></script>

    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/plugins/switchery/dist/switchery.js"></script>
    <link rel="stylesheet" type="text/css" href="/plugins/switchery/dist/switchery.css">
    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/global/plugins/bootstrap-toastr/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="/plugins/custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <script type="text/javascript" src="/plugins/custom-scrollbar-plugin/jquery.mCustomScrollbar.js"></script>

    <link rel="stylesheet" type="text/css" href="/plugins/bsb-icons/style.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/shared_profile.css">


    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/favicon.ico"/>
    <sctipt src="/js/comments.js"></sctipt>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body style="opacity:1">

<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.5&appId=1558782291101766";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<?php //var_dump($model); die();?>

    <div class="b-page-wrap">
        <div class="well">
            <div class="header text-center">
                <a href="/" class="logo-wrap"><img src="/images/logo_new.png" alt="logo" class="logo-default"></a>
                <div class="site-name">Business without busyness</div>
            </div>
            <div class="page-content">
                <section id="user">
                    <img src="<?php echo $model->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$model->avatar:'/images/avatar/nophoto.png'?>" height="125" width="125" alt="" class="avatar">
                    <div class="name"><?php echo ($model->first_name)?$model->first_name:''?> <?php echo ($model->last_name)?$model->last_name:''?> <?php echo (!$model->first_name && !$model->last_name)?'User':''?></div>
                    <div class="adres"><i class="ico-location"></i> <?php echo ($model->country_id)?$model->country_title:''?><?php echo ($model->city_title)?', '.$model->city_title:''?><?php echo ($model->zip)?', '.$model->zip:''?></div>
                    <div class="status"><?php echo ($model->status)?$model->status:''?></div>
                </section>
                <section id="services">
                    <div class="container-fluid">
                        <div class="row">
                            <?php $departments = \modules\departments\models\UserDo::find()
                                ->select('user_do.*, test_result.title_medium as high, test_result.name as dname, test_result.color as color, department.icons as icon')
                                ->join('LEFT JOIN', 'test_result', 'test_result.department_id = user_do.department_id')
                                ->join('LEFT JOIN', 'department', 'test_result.department_id = department.id')
                                ->where(['status_sell' => 1, 'user_id' => Yii::$app->user->id])->all();?>
                            <?php if($departments):?>
                                <?php $i = 0;?>
                                <?php foreach($departments as $dep):?>

                                    <?php $spec = \modules\user\models\UserSpecialization::find()
                                        ->select('user_specialization.*, specialization.department_id as dep_id, specialization.name as dname, skill_list.name as skillname')
                                        ->join('LEFT JOIN', 'specialization', 'specialization.id = user_specialization.specialization_id')
                                        ->join('LEFT OUTER JOIN', 'skill_list', 'skill_list.id = user_specialization.exp_type')
                                        ->where(['user_specialization.user_id' => Yii::$app->user->id, 'specialization.department_id' => $dep->department_id])->all()?>
                                    <?php $i++; ?>
                                    <?php if($spec):?>
                                        <?php //var_dump($spec); die();?>
                                        <div class="col-sm-12">
                                            <div class="panel-group accordion" aria-multiselectable="true" id="accordion1">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" data-toggle="collapse" href="#collapse_3_<?php echo $i;?>" aria-expanded="true">
                                                        <h4 class="panel-title">
                                                            <div class="accordion-toggle collapsed" style="background:<?php echo $dep->color?> ">
                                                                <div class="icon"><i class="ico-<?php echo $dep->icon?>"></i></div>
                                                                <div class="text">
                                                                    <?php $high = explode(' ', $dep->high);?>
                                                                    <div class="hui1"><?php echo $high[0]?></div>
                                                                    <div class="hui2"><?php echo $dep->dname?></div>
                                                                </div>
                                                            </div>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse_3_<?php echo $i?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                                        <div class="panel-body background-<?php echo $dep->department_id?>">
                                                            <div class="col-md-8 col-md-offset-2 service-heading">
                                                                <div class="row">
                                                                    <div class="col-sm-6" style="padding: 0;">Specialty</div>
                                                                    <div class="col-sm-4" style="">Level</div>
                                                                    <div class="col-sm-2" style="padding: 0;">Rate / h</div>
                                                                </div>
                                                            </div>
                                                            <?php if($spec):?>
                                                                <?php foreach ($spec as $s):?>
                                                                    <div class="col-md-8 col-md-offset-2 service-wrapper" style="margin-bottom: 10px;">
                                                                        <div class="row">
                                                                            <div class="col-sm-6" style="padding: 0;">
                                                                            <?php echo $s->dname?>
                                                                            </div>
                                                                            <div class="col-sm-4">
                                                                            <?php echo ($s->skillname)?$s->skillname:'-'?>
                                                                            </div>
                                                                            <div class="col-sm-2" style="padding-left: 0;">
                                                                                <?php if($s->rate!=null){echo "$ ".$s->rate;}else{ echo " - ";} ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach;?>
                                                            <?php endif;?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                    <?php endforeach;?>
                            <?php endif;?>


                    </div>
                </section>
                <section id="about">
                    <?php if($model->about):?>
                    <div class="title">ABOUT ME</div>
                    <div class="text">
                        <p><?php echo $model->about?></p>
                    </div>
                    <?php endif;?>
                </section>

                <section class="contacts">
                    <div class="title">GET IN TOUCH</div>
                    <div class="content">
                        <div class="big">
                            <?php if(($model->phone) && $model->phone != ''):?>
                                <?php if($model->show_phone == 1):?>
                                    <a tabindex="0" role="button" class="tel" data-toggle="popover" data-content="<?php echo ($model->phone)?$model->phone:'' ?>"></a>
                                <?php else:?>
                                    <a tabindex="0" role="button" class="tel no_hover" data-toggle="popover" data-content="User has hidden this information"></a>
                                <?php endif; ?>

                            <?php endif;?>
                            <?php if(($model->skype) && $model->skype != ''):?>
                                <?php if($model->show_skype == 1):?>
                                    <a role="button" data-toggle="popover" data-content="<?php echo ($model->skype)?$model->skype:'' ?> <a class='callskype' href='skype:sdasdasda?call'><img src='/images/phone.png'></a>" class="skype" ></a>
                                <?php else:?>
                                    <a role="button" data-toggle="popover" data-content="User has hidden this information" class="skype no_hover" ></a>
                                <?php endif; ?>

                            <?php endif;?>

                            <?php if(($model->email) && $model->email != ''):?>
                                <?php if($model->show_mail == 1):?>
                                    <a tabindex="1" role="button" data-toggle="popover" data-content="<?php echo ($model->email)?$model->email:'' ?>" class="mail" ></a>
                                <?php else:?>
                                    <a tabindex="1" role="button" data-toggle="popover" data-content="User has hidden this information" class="mail no_hover" ></a>
                                <?php endif; ?>

                            <?php endif;?>


                        </div>
                        <div class="small">
                            <?php if(($model->social_tw) && $model->social_tw != ''):?>
                                <?php if($model->show_tw == 1):?>
                                    <a href="<?php echo $model->social_tw?>" class="tw"></a>
                                <?php else: ?>
                                    <a onclick="return false" role="button" data-trigger="hover" data-toggle="popover" data-content="User has hidden this information" href="<?php echo $model->social_tw?>" class="tw no_hover"></a>
                                <?php endif;?>
                            <?php endif;?>
                            <?php if(($model->social_fb) && $model->social_fb != ''):?>
                                <?php if($model->show_fb == 1):?>
                                    <a href="<?php echo $model->social_fb?>" class="fb"></a>
                                <?php else: ?>
                                    <a onclick="return false" role="button" data-trigger="hover" data-toggle="popover" data-content="User has hidden this information" href="<?php echo $model->social_fb?>" class="fb no_hover"></a>
                                <?php endif;?>
                            <?php endif;?>
                            <?php if(($model->social_gg) && $model->social_gg != ''):?>

                                <?php if($model->show_gg == 1):?>
                                    <a href="<?php echo $model->social_gg?>" class="gp"></a>
                                <?php else: ?>
                                    <a onclick="return false" role="button" data-trigger="hover" data-toggle="popover" data-content="User has hidden this information" href="<?php echo $model->social_gg?>" class="gp no_hover"></a>
                                <?php endif;?>
                            <?php endif;?>
                            <?php if(($model->social_in) && $model->social_in != ''):?>

                                <?php if($model->show_in == 1):?>
                                    <a href="<?php echo $model->social_in?>" class="inst"></a>
                                <?php else: ?>
                                    <a onclick="return false" role="button" data-trigger="hover" data-toggle="popover" data-content="User has hidden this information" href="<?php echo $model->social_in?>" class="inst no_hover"></a>
                                <?php endif;?>
                            <?php endif;?>
                            <?php if(($model->social_ln) && $model->social_ln):?>

                                <?php if($model->show_ln == 1):?>
                                    <a href="<?php echo $model->social_ln?>" class="lin"></a>
                                <?php else: ?>
                                    <a onclick="return false" role="button" data-trigger="hover" data-toggle="popover" data-content="User has hidden this information" href="<?php echo $model->social_in?>" class="lin no_hover"></a>
                                <?php endif;?>
                            <?php endif;?>
                            <div></div>
                        </div>
                    </div>
                </section>
                <section id="comments">
                    <textarea placeholder="Place your comment" name="" id="comment-area" cols="30" rows="10"></textarea>
                    <div style="text-align:justify;">
                        <label for="" id="comments-count" style="display:inline-block;"><span class="count"><?php echo $count?></span> Comments</label> <button style="display:inline-block;width:100px;background: transparent;" class="btn btn-primary" id="send-btn">Send</button>
                        <div style="display:inline-block;width:100%;"></div>
                    </div>
                    <div class="dinamic_comments">
                    <?php echo $comments?>

                    </div>
                    <span style="cursor:pointer" class="more"><i class="fa fa-angle-down"></i></span>
                </section>
            </div>
            <div class="page-footer">
                <div class="text-center">
                    <div class="contacts">
                        <label for="">Share on</label>
                        <div class="small">
                            <?php $link = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>
                            <?php $fblink =$_SERVER['REQUEST_URI'];?>
                            <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $link?>" class="tw active"></a>
                            <a style="position: relative; bottom: 11px;" href="#" class="fb active share_fb"><div class="fb-share-button" data-href="<?php echo $fblink?>" data-layout="button_count"></div></a>

                        </div>
                    </div>
                    <span> <?php echo date('Y');?> © BSB</span> <span>All rights reserved</span>
                    <!-- <a href="/core/profile" class="btn btn-primary" style="position:absolute;right:30px;top:25px;">Close</a> -->
                </div>
            </div>
        </div>
    </div>
<script>
    $(document).ready(function(){
        $(".contacts .no_hover").popover({
            placement:"top",
            html: true,
            trigger:"click",
            content:"User has hidden this information"
        });
        // $(".contacts .skype").not(".no_hover").popover({
        //     placement:"top",
        //     html: true,
        //     trigger:"manual",
        // });
        $(".contacts .big .tel, .contacts .big .mail,.contacts .skype").not(".no_hover").popover({
            placement:"top",
            html: true,
            trigger:"manual"
        }).click(function(){
            if($(".contacts .big .tel, .contacts .big .mail,.contacts .skype").not($(this)).next("div").hasClass('popover')){
                $(".contacts .big .tel, .contacts .big .mail,.contacts .skype").not($(this)).popover("hide");
            }
            $(this).popover('toggle');
        });

        $(".contacts .big a").on('show.bs.popover',function(){
            $("body").on("click", function(e){
                $('.contacts .big a').each(function () {
                    //the 'is' for buttons that trigger popups
                    //the 'has' for icons within a button that triggers a popup
                    if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.contacts .big .popover').has(e.target).length === 0) {
                        $(this).popover('hide');
                    }
                });
            });
        });


        $("body").animate({"opacity":1},1000);
        $('.fb-share-button').css('opacity', 0);

       /* $(document).on('click', '.share_fb', function(e){
            e.preventDefault();
            $('.fb-share-button').trigger('click');
        })*/

    });

    $(document).on('click', '.go-page', function(){
        if($(this).parent('li').hasClass('disabled')){
            return false;
        }
        var id = $(this).attr('data-page-id');
        var data = {
            _csrf: $("meta[name=csrf-token]").attr("content"),
            page: id,
            user_id: <?php echo $_GET['id']?>
        }
        $.ajax({
            'url': '/user/social/pagination',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response){
                $('.dinamic_comments').hide().html(response.html).fadeIn(500);
                $(".dinamic_comments .item:nth-child(4),.comments .item:nth-child(5), .pagination").show();
            }
        })
    })
   var toggledComms = $(".comments .item:nth-child(4),.comments .item:nth-child(5), .pagination");
   var flag=0;
   $(document).on('click', '.more', function(e){
       var toggledComms = $(".comments .item:nth-child(4),.comments .item:nth-child(5), .pagination");
       console.log(flag);
       if (flag==0){
           $(this).find('.fa').removeClass('fa-angle-down').addClass('fa-angle-up');
           toggledComms.fadeIn(300);
           flag=1;
       }else {
           $(this).find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
           toggledComms.fadeOut(300);
           flag=0;
       }
   });

</script>

<script>
    $(function(){
        $('body').mCustomScrollbar({
            theme:"dark"
        });
        $(document).on('click', '#send-btn', function(e){
            e.preventDefault();
            var text = $('#comment-area').val();
            var data = {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                text: text,
                user_id: <?php echo $_GET['id']?>
            }
            if(text == ''){
                alert('Cannot be empty'); //Stylize alert
                return false;
            }else{
                $.ajax({
                    url:'/user/social/add-comment',
                    type: 'post',
                    dataType: 'json',
                    data: data,
                    success: function(response){
                       $('.dinamic_comments').html(response.html);
                        $('.count').text(response.count);
                        $('#comment-area').val('');
                    }
                })
            }
        })


    })
</script>

</body>
</html>
