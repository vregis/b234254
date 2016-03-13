<? use yii\helpers\Url; ?>
<div class="container-fluid">
<div class="row task-title" style="margin-bottom: 8px;">
	<div class="row task-body" style="margin-top:40px;">
		<div class="desc" style="padding:0 15px;">
			<div class="step">
				<div class="progress"></div>
				<div class="form-md-radios md-radio-inline b-page-checkbox-wrap">
					<? $name[0] = 'Start'; ?>
					<? $name[1] = 'Discover'; ?>
					<? $name[2] = 'Go'; ?>
					<? for($i = 0; $i < 3; $i++) : ?>
						<div class="md-radio even has-test b-page-checkbox">
							<div class="task-name">
								<?= $name[$i] ?>
							</div>
							<input type="radio" id="Roadmap[<?= $i ?>]" name="Roadmap" class="md-radiobtn" value="<?= $i ?>">
							<label for="Roadmap[<?= $i ?>]">
								<span></span>
								<span class="check"></span>
								<span class="box" style="cursor: default" onclick="return false;"><?=$i==0 || $i==1 ? '<i class="fa fa-check font-green-jungle"></i>' : $i + 1?></span>
							</label>
							<div class="text-desc-task" style="display: none">
								<?= $task->description ?>
							</div>
						</div>
					<? endfor; ?>
					<div style="display:inline-block;width:100%;">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="name text-center"><?= $task->description ?></div>
	<div class="clearfix"></div>

	<div class="row task-body">
		<a href="<?= Url::toRoute(['/core/profile?user=spec&first=1']) ?>" class="btn btn-primary btn-lg">Continue</a>
	</div>
</div>
</div>
<style>
    .well{
        width:675px !important;
    }
	.well .progress{
	    width:100%;
	}
	.well .b-page-checkbox-wrap .md-radio label > .box{
	    border-color: #26C281 !important;
	    color: #26C281 !important;
	}
</style>

<script>
	$(function(){
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
		window.onhashchange=function(){window.location.hash="no-back-button";}
	})

</script>
