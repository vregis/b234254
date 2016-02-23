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
    <link rel="stylesheet" type="text/css" href="/css/shared_business.css">


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


    <div class="b-page-wrap">
        <div class="well">
            <div class="header text-center">
                <a href="/" class="logo-wrap"><img src="/images/logo_new.png" alt="logo" class="logo-default"></a>
                <div class="site-name">My business without busyness</div>
            </div>
            <div class="page-content">
            	<section id="about">
            		<div class="title"><?php echo $model->idea_name?></div>
            		<div class="subtitle"><?php echo $model->industry_name?></div>
            		<table class="text">
            			<tr>
            				<td style="width:50%;border-right:1px solid #5a5a5a;vertical-align: top;padding-right:40px;"><?php echo $model->idea_description_like?></td>
            				<td style="width:50%;vertical-align: top;padding-left:40px;"><?php echo $model->idea_description_problem?></td>
            			</tr>
            		</table>
            		<div data-tool-id = '<?php echo $model->id?>' class="step">
        				<?php echo $idea?>
                    </div>
            	</section>
	            <section id="benefits">
	            	<div class="title">our benefits</div>
	            	<div class="content">
		            	<table>
		            		<tr>
		            			<td><div class="digit">1</div></td>
		            			<td><div class="digit">2</div></td>
		            			<td><div class="digit">3</div></td>
		            		</tr>
		            		<tr>
		            			<td><div class="desc"><?php echo $model->benefit_first?></div></td>
		            			<td><div class="desc"><?php echo $model->benefit_second?></div></td>
								<td><div class="desc"><?php echo $model->benefit_third?></div></td>
		            		</tr>
		            		<tr class="like-block" data-user-tool-id = '<?php echo $model->id ?>'>
		            			<?php echo $likes?>
		            		</tr>
		            	</table>
	            	</div>
	            </section>
                <section id="user">
                	<div class="title">Our team</div>
                	<div class="status">Founder</div>
                    <img src="/images/avatar/nophoto.png" height="125" width="125" alt="" class="avatar">
                    <div class="name">Tony Bulletooth</div>
                    <div class="adres"><i class="ico-location"></i> USA, New York, 10001</div>
                    <div class="title" style="margin:25px auto;">Vacancy</div>
                    <div class="deps-wrap">
                    	<div class="roww action">
                    		<div class="item">
                    			<button class="btn btn-primary circle"><i class="ico-add"></i></button>
                    		</div>
                    		<div class="item">
                    			<button class="btn btn-primary circle"><i class="ico-add"></i></button>
                    		</div>
                			<div class="item">
                    			<button class="btn btn-primary circle"><i class="ico-add"></i></button>
                    		</div>
                			<div class="item">
                    			<button class="btn btn-primary circle"><i class="ico-add"></i></button>
                    		</div>
                    		<div class="item">
                    			<button class="btn btn-primary circle"><i class="ico-add"></i></button>
                    		</div>
                    		<div class="item">
                    			<button class="btn btn-primary circle"><i class="ico-add"></i></button>
                    		</div>
                    		<div class="item">
                    			<button class="btn btn-primary circle"><i class="ico-add"></i></button>
                    		</div>
                    		<div class="item">
                    			<button class="btn btn-primary circle"><i class="ico-add"></i></button>
                    		</div>
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
                    <a href="javascript:;" class="btn btn-lg btn-primary" style="width:185px;border-radius: 30px;background: transparent;">JOIN US</a>
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
                    <span> <?php echo date('Y');?> © BSB</span> <span>All rights reserved</span>
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
        })


    })

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