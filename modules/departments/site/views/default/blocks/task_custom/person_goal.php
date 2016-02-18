<?
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div class="name pull-left"><?= $task->name ?></div>

<?= Html::submitButton('Next', ['class' => 'btn btn-success pull-right','style' => 'line-height:32px !important']) ?>
<div class="clearfix"></div>
<div class="row task-body">
    <div class="personal-fields">
        <div class="input-group pull-left">
                                <span class="input-group-addon">
                                    $
                                </span>
            <input type="text" id="mask_currency" name="Goal[count_money]" value="<?= $goal->count_money ?>" class="form-control" placeholder="My personal goal">
        </div>
        <div class="input-group pull-right">
                                <span class="input-group-addon">
                                    <i class="ico-calendar"></i>
                                </span>
            <input type="text" name="Goal[date]" value="<?= $goal->date ?>" class="form-control" placeholder="By this date">
        </div>
        <div id="datepicker" style="display:none;"></div>
        <div class="clearfix"></div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".task-custom .input-group.pull-right").popover({
            container: '#task',
            placement: "bottom",
            html: true,
            content : $("#datepicker")
        });
        $(".task-custom .input-group.pull-right").on('show.bs.popover', function () {
            $("#datepicker").show();
            $("#datepicker").datepicker('setDate',$(".task-custom .personal-fields .form-control[name='Goal[date]']").val());
        });
        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0,
            showWeek: false,
            numberOfMonths: 1,
            onSelect : function(dateText, inst){
                $(".task-custom .personal-fields .form-control[name='Goal[date]']").val(dateText);
                $(".task-custom .input-group.pull-right").popover('hide');
            }
        });
    });
</script>