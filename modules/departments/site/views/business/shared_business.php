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
    <script type="text/javascript" src="/web/metronic/theme/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.js"></script>



    <script type="text/javascript" src='/js/lib/jquery.tooltipster.min.js'></script>

    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/plugins/switchery/dist/switchery.js"></script>
    <link rel="stylesheet" type="text/css" href="/plugins/switchery/dist/switchery.css">
    <script type="text/javascript" src="/metronic/theme/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/metronic/theme/assets/global/plugins/bootstrap-toastr/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="/plugins/custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <script type="text/javascript" src="/plugins/custom-scrollbar-plugin/jquery.mCustomScrollbar.js"></script>
    <link href="/fonts/Open Sans/OpenSans.css" rel="stylesheet">
    <!-- <link rel='stylesheet' href='/css/mainpage/bootstrap.min.css'> -->
    <link rel='stylesheet' href='/metronic/theme/assets/global/plugins/simple-line-icons/simple-line-icons.css'>





    <?php
    $this->registerJsFile("/js/global/index.js");
    $this->registerJsFile("/js/bootbox.min.js");
    // $this->registerJsFile("/js/jquery.blockui.min.js");
    $this->registerJsFile("/js/app.js");
    $this->registerCssFile("/plugins/venobox/venobox.css");
    $this->registerJsFile("/plugins/venobox/venobox.min.js");
    ?>
    <!-- <link rel='stylesheet' href='/css/mainpage/style.css'> -->
    <link rel='stylesheet' href='/css/mainpage/color.css'>
    <link rel='stylesheet' href='/css/mainpage/vendor.css'>
    <!-- <link rel='stylesheet' href='/css/mainpage/title-size.css'> -->
    <link rel='stylesheet' href='/css/mainpage/custom.css'>
        <!-- script -->
<!--[if lte IE 9]><!-->
<script src='/js/mainpage/vendor/html5shiv.min.js'></script>
<!--<![endif]-->
<!-- <script src='/js/mainpage/vendor/bootstrap.min.js'></script> -->
<script src='/js/mainpage/vendor/vendor.js'></script>
<script src='/js/mainpage/variable.js'></script>
<script src='/js/mainpage/main.js'></script>
<!-- /script -->
    <link rel="stylesheet" type="text/css" href="/plugins/bsb-icons/style.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/shared_business.css">

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js"></script>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/favicon.ico"/>
    <sctipt src="/js/comments.js"></sctipt>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body style="opacity:1">
<div id="bg">
    <div id="img"></div>
    <div id="video"></div>
    <div id="overlay"></div>
    <div id="effect">
        <img src="/images/mainpage/bg/cloud-01.png" alt="" id="cloud1">
        <img src="/images/mainpage/bg/cloud-02.png" alt="" id="cloud2">
        <img src="/images/mainpage/bg/cloud-03.png" alt="" id="cloud3">
        <img src="/images/mainpage/bg/cloud-04.png" alt="" id="cloud4">
    </div>
    <canvas id="js-canvas"></canvas>
</div>
<div id="site-main">
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.5&appId=1558782291101766";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


    <div class="b-page-wrap">
        <div class="well">
            <div class="header text-center">
                <a href="/" class="logo-wrap"><img src="/images/logo_new.png" alt="logo" class="logo-default"></a>
                <div class="site-name">My business without busyness</div>
                <button id="btn-save" class="btn btn-primary btn-empty circle" style="display:none;"><i class="fa fa-floppy-o"></i></button>
                <button id="btn-edit" class="btn btn-primary btn-empty circle"><i class="ico-edit"></i></button>
            </div>
            <div class="page-content">
            	<section id="about">
            		<div class="title">
                        <div class="edit-block">
                            <div class="value"><?php echo $model->idea_name?></div>
                            <div class="editor"><input maxlength="150" type="text" id="idea-name" value="<?php echo $model->idea_name?>" class="form-control"></div>
                        </div>
                    </div>
            		<div class="subtitle">
                        <div class="edit-block">
                            <div class="value"><?php echo $model->industry_name?></div>
                            <div class="editor">
                            <select name="" id="idea-industry" class="selectpicker">
                                <option value="<?php echo $model->industry_name?>"><?php echo $model->industry_name?></option>
                                <option value="Bar/Restaurant">Bar/Restaurant</option>
                                <option value="Animals">Animals</option>
                            </select>
                            </div>
                        </div> 
                    </div>
            		<table class="text">
            			<tr>
            				<td style="width:50%;border-right:1px solid rgba(90, 90, 90, 0.6);vertical-align: top;padding-right:20px;">
                                <div class="edit-block">
                                    <div class="value"><?php echo $model->idea_description_like?></div>
                                    <div class="editor"><textarea maxlength="300" name="" id="idea-desc_like" cols="30" rows="10" class="form-control"><?php echo $model->idea_description_like?></textarea></div>
                                </div>
                            </td>
            				<td style="width:50%;vertical-align: top;padding-left:20px;">
                                <div class="edit-block">
                                    <div class="value"><?php echo $model->idea_description_problem?></div>
                                    <div class="editor"><textarea maxlength="300" name="" id="idea-desc_problem" cols="30" rows="10" class="form-control"><?php echo $model->idea_description_problem?></textarea></div>
                                </div>
                            </td>
            			</tr>
            		</table>
            		<div data-tool-id = '<?php echo $model->id?>' class="step">
        				<?php echo $idea?>
                    </div>
            	</section>
	            <section id="benefits">
	            	<div class="title" style="font-weight:bold;">Benefits</div>
	            	<div class="content">
		            	<table>
		            		<tr>
		            			<td><div class="digit">1</div></td>
		            			<td><div class="digit">2</div></td>
		            			<td><div class="digit">3</div></td>
		            		</tr>
		            		<tr>
		            			<td><div class="desc">
                                    <div class="edit-block">
                                        <div class="value"><?php echo $model->benefit_first?></div>
                                        <div class="editor"><textarea maxlength="200" id="benefit-first" class="form-control"><?php echo $model->benefit_first?></textarea></div>
                                    </div>
                                </div></td>
		            			<td><div class="desc">
                                    <div class="edit-block">
                                        <div class="value"><?php echo $model->benefit_second?></div>
                                        <div class="editor"><textarea maxlength="200" id="benefit-second" class="form-control"><?php echo $model->benefit_second?></textarea></div>
                                    </div>               
                                </div></td>
								<td><div class="desc">
                                    <div class="edit-block">
                                        <div class="value"><?php echo $model->benefit_third?></div>
                                        <div class="editor"><textarea maxlength="200" id="benefit-third" class="form-control"><?php echo $model->benefit_third?></textarea></div>
                                    </div>                        
                                </div></td>
		            		</tr>
		            		<tr class="like-block" data-user-tool-id = '<?php echo $model->id ?>'>
		            			<?php echo $likes?>
		            		</tr>
		            	</table>
	            	</div>
	            </section>
                <section id="user">
                	<div class="title" style="font-weight:bold;">Team</div>
                	<div class="status" style="color:rgba(90,90,90,0.75);">Founder</div>
                    <img  onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" src="<?php echo $profile->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$profile->avatar:'/images/avatar/nophoto.png'?>" height="125" width="125" alt="" class="avatar">
                    <div class="name"><?php echo $profile->first_name?$profile->first_name:''?> <?php echo $profile->last_name?$profile->last_name:''?></div>
                    <div class="adres" style="color:rgba(90,90,90,0.75);"><i class="ico-location"></i> USA <?php echo $profile->city_title?' ,'.$profile->city_title:''?></div>
                	 <div class="title" style="margin:25px auto;font-size:24px;">Vacancy</div>
                    <div class="deps-wrap">
                    	<div class="roww action">
                            <?php foreach($departments as $dep):?>
                    		<div class="item">
                                <?php $do = \modules\departments\site\controllers\BusinessController::checkDoDepartment($dep->id);?>
                                <?php if($do):?>
                                <a target="_blank" href="/user/social/shared-profile?id=<?php echo $do->idd?>">
                                    <img width="30" onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" data-toggle="popover" class="gant_avatar active mCS_img_loaded" data-id="0" src="<?php echo $do->ava != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$do->ava:'/images/avatar/nophoto.png'?>" data-original-title="" title="">
                                </a>
                                <?php else:?>
                    			<button data-toggle="popover" class="btn btn-primary circle"><i class="ico-add"></i></button>
                                <?php endif;?>
                    		</div>
                            <?php endforeach; ?>
                    	</div>
                    	<div class="roww deps">
                    		<a href="javascript:;" class="item background-1">Idea</a>
                    		<a href="javascript:;" class="item background-2">Strategy</a>
                    		<a href="javascript:;" class="item background-3">Customers</a>
                    		<a href="javascript:;" class="item background-4">Documents</a>
                    		<a href="javascript:;" class="item background-5">Products</a>
                    		<a href="javascript:;" class="item background-6">Numbers</a>
                    		<a href="javascript:;" class="item background-7">IT</a>
                    		<a href="javascript:;" class="item background-8">Team</a>
                    	</div>
                    </div>
                    <a href="javascript:;" class="btn btn-lg btn-primary join-us" style="width:185px;border-radius: 30px;background: transparent;">JOIN US</a>
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
                    <span> <?php echo date('Y');?> © BSB</span> <span>All rights reserved</span> <a style="display:inline-block;width:100px;background: transparent;position: absolute;top: 21px;right: 0;" class="btn btn-primary" href="/departments/business">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#site-main').mCustomScrollbar({
            theme:"dark"
        });
        $("#benefits .content table tr td .btn.left-circle").hover(function(){
            $(this).find('i').removeClass('ico-dislike').addClass('ico-dislike1');
        },function(){
            $(this).find('i').removeClass('ico-dislike1').addClass('ico-dislike');
        });
        $("#benefits .content table tr td .btn.right-circle").hover(function(){
            $(this).find('i').removeClass('ico-like').addClass('ico-like1');
        },function(){
            $(this).find('i').removeClass('ico-like1').addClass('ico-like');
        });
        $("#btn-edit").click(function(){
            $(".edit-block > .value").fadeOut(500);
            setTimeout(function(){$(".editor").fadeIn(500);},500);
            $(this).fadeOut(500);
            setTimeout(function(){$("#btn-save").fadeIn(500);},500);
            $('[maxlength]').maxlength({
                alwaysShow: true,
                appendToParent: true,
                limitReachedClass: "label label-danger",
            });
        });
        $("#btn-save").click(function(){
            $.each($(".edit-block"),function(){
                $(this).find('.value').html($(this).find('.form-control').val());
                $(this).find('.value').html($(this).find('select').val());
            });
            $(".editor").fadeOut(500);
            setTimeout(function(){$(".edit-block > .value").fadeIn(500);},500);
            $(this).fadeOut(500);
            setTimeout(function(){$("#btn-edit").fadeIn(500);},500);
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
                    url:'/departments/business/add-comment',
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
        });

        $(".selectpicker").selectpicker({});
        setTimeout(function(){
            // $.each($('.dropdown-menu.inner'),function(){
            //     var els = $(this).find('li');
            //     console.log(els.length);
            //     if(els.length > 8){
            //         $(this).mCustomScrollbar({
            //             setHeight: 252,
            //             theme:"dark",
            //             scrollbarPosition:"outside"
            //         });  
            //     }else{
            //         $(this).mCustomScrollbar({
            //             theme:"dark",
            //             scrollbarPosition:"outside"
            //         });  
            //     }
            // });
        },400);
        $(".contacts .no_hover").popover({
            placement:"top",
            html: true,
            trigger:"click",
            content:"User has hidden this information"
        });
        $(".deps-wrap .action .item .btn, .join-us").popover({
            placement: "top",
            content : 'Will be available in the next version',
            html: true,
            trigger:"manual",
        }).click(function(){
            if($(".deps-wrap .action .item .btn, .join-us").not($(this)).next("div").hasClass('popover')){
                $(".deps-wrap .action .item .btn, .join-us").not($(this)).popover("hide");
            }
            $(this).popover('toggle');
        });
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

        $(".contacts .big a,.deps-wrap .action .item .btn, .join-us").on('show.bs.popover',function(){
            $("body").on("click", function(e){
                $('.contacts .big a,.deps-wrap .action .item .btn, .join-us').each(function () {
                    //the 'is' for buttons that trigger popups
                    //the 'has' for icons within a button that triggers a popup
                    if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.join-us, .deps-wrap .action .item .btn, .contacts .big .popover').has(e.target).length === 0) {
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
            'url': '/departments/business/pagination',
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

    $(document).on('click', '.add-thumb', function(){
        var tool = $(this).closest('.like-block').attr('data-user-tool-id');
        var benefit = $(this).closest('.benefit').attr('data-benefit-id');
        if($(this).hasClass('like')){
            var like = 1;
        }else{
            var like = 0;
        }

        var data = {
            tool:tool,
            benefit: benefit,
            like:like
        }
        $.ajax({
            url: '/departments/business/add-like',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response){
                $('.like-block').html(response.html);
            }
        })
    })

    $(document).on('click', '.idea-like', function(){
        if($(this).hasClass('not')){
            return false;
        }
        var point = $(this).val();
        var tool = $(this).closest('.step').attr('data-tool-id');
        var data = {
            point:point,
            tool:tool
        }

        $.ajax({
            url: '/departments/business/add-like-idea',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response){
                $('.step').html(response.html);
            }
        })
    })
</script>

</body>
</html>
