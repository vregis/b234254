<? use yii\helpers\Url; ?>
<div class="container-fluid">
<div class="row task-title" style="margin-bottom: 8px;">
	<div class="text-center" style="font-size:40px;font-weight: bold;color: rgba(90,90,90,0.50);">GO</div>
	<div class="name text-center" style="margin:15px auto 30px;"><?= $task->description ?></div>
	<div class="clearfix"></div>

	<div class="row task-body">
		<a href="<?= Url::toRoute(['/core/profile?first=1']) ?>" class="btn btn-primary btn-lg">Go to profile</a>
	</div>
</div>
</div>
<style>
    .well{
        width:675px !important;
    }
	.progress{
	    width:100%;
	}
	.b-page-checkbox-wrap .md-radio label > .box{
	    border-color: #26C281 !important;
	}
</style>