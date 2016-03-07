<? use yii\helpers\Url; ?>
<div class="container-fluid">
<div class="row task-title" style="margin-bottom: 0px;">
	<div class="text-center" style="font-size:40px;font-weight: bold;color: rgba(90,90,90,0.50);">Discover</div>
	<div class="name text-center" style="margin:15px auto 30px;"><?= $task->description ?></div>
	<div class="clearfix"></div>
	<div class="task-body">
		<a href="<?= Url::toRoute(['/tests/progress']) ?>" class="btn btn-primary btn-lg">Take a test</a>
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
            container:$("#side_road .wrapper"),
            template:'<div class="popover top-fix" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(282);?>"
        });
        $("#side_road .item-3").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover top-fix item-3" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(283);?>"
        });
        $("#side_road .item-4").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-4" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content: "<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(37);?>"
        });
        $("#side_road .item-5").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-5" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(38);?>"
        });
        $("#side_road .item-6").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-6" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:"<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(39);?>"
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