<? use yii\helpers\Url; ?>
<div class="container-fluid">
<div class="row task-title" style="margin-bottom: 0px;">
	<div class="text-center" style="font-size:40px;font-weight: bold;color: rgba(90,90,90,0.50);">DISCOVER</div>
	<div class="name text-center" style="margin:15px auto 30px;"><?= $task->description ?></div>
	<div class="clearfix"></div>
	<div class="task-body">
		<a href="<?= Url::toRoute(['/tests/progress']) ?>" class="btn btn-primary btn-lg">Take test</a>
	</div>
</div>
</div>
<script>
	$(document).ready(function(){
		$(".b-page-checkbox-wrap .md-radio:nth-child(3)").addClass('active');
		$("#side_road .item-2").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            template:'<div class="popover top-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ullam, laboriosam non ea quos accusamus accusantium repellendus porro tempore quis esse in eius vero, mollitia nihil? Ipsa voluptates, dicta magnam."
        });
        $("#side_road .item-3").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            template:'<div class="popover top-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ullam, laboriosam non ea quos accusamus accusantium repellendus porro tempore quis esse in eius vero, mollitia nihil? Ipsa voluptates, dicta magnam."
        });
        $("#side_road .item-4").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            template:'<div class="popover bottom-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ullam, laboriosam non ea quos accusamus accusantium repellendus porro tempore quis esse in eius vero, mollitia nihil? Ipsa voluptates, dicta magnam."
        });
        $("#side_road .item-5").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            template:'<div class="popover bottom-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ullam, laboriosam non ea quos accusamus accusantium repellendus porro tempore quis esse in eius vero, mollitia nihil? Ipsa voluptates, dicta magnam."
        });
        $("#side_road .item-6").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            template:'<div class="popover bottom-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ullam, laboriosam non ea quos accusamus accusantium repellendus porro tempore quis esse in eius vero, mollitia nihil? Ipsa voluptates, dicta magnam."
        });
	});
</script>
<style>
    .well{
        width:675px !important;
    }
    #side_road .progress{
        height:20%;
    }
/*	.b-page-checkbox-wrap .md-radio:nth-child(2) label > .box,.b-page-checkbox-wrap .md-radio:nth-child(3) label > .box{
	    border-color: #26C281 !important;
	}*/
</style>