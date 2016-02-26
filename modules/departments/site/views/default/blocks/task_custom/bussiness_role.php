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
<style>
    .well{
        width:675px !important;
    }
	.progress{
	    width:50%;
	}
	.b-page-checkbox-wrap .md-radio:nth-child(1) label > .box,.b-page-checkbox-wrap .md-radio:nth-child(2) label > .box{
	    border-color: #26C281 !important;
	}
</style>