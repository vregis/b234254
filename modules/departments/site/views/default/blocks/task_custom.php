<?php

use modules\tasks\models\Task;
use modules\departments\models\Specialization;


$this->registerCssFile("/plugins/datetimepicker/jquery.datetimepicker.css");
// $this->registerCssFile("/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.min.css");

// $this->registerJsFile("/plugins/datetimepicker/build/jquery.datetimepicker.full.js");
// $this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js");

// $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.js");
$this->registerJsFile("/js/readmore.min.js");

$this->registerJsFile("/js/global/task.js");

$this->registerCssFile("/fonts/Open Sans/OpenSans-Bold.css");
// $this->registerCssFile("/css/page_test.css");
//$this->registerCssFile("/css/task.css");

$this->title = 'Главная страница';

$specialization = null;
if($task->specialization_id > 0) {
    $specialization = Specialization::find()->where(['id' => $task->specialization_id])->one();
}

?>
<?php $this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css");?>
<?php $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"); ?>
<?php $this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js");?>
<?php $this->registerCssFile("/metronic/theme/assets/global/plugins/select2/css/select2.min.css"); ?>
<?php $this->registerCssFile("/metronic/theme/assets/global/plugins/select2/css/select2-bootstrap.min.css"); ?>
<?php /*$form = ActiveForm::begin(
    [
        'id' => 'task-form',
    ]
) */?>
<link rel="stylesheet" type="text/css" href="/css/task.css">
<link rel="stylesheet" type="text/css" href="/css/task-custom.css">
<?php $tool = \modules\tasks\models\UserTool::find()->where(['user_id' => Yii::$app->user->id])->all();?>
<?php $user = \modules\user\models\User::find()->where(['id' => Yii::$app->user->id])->one();?>
<?php if(isset($_GET['first']) || count($tool) < 3):?>
    <?php if($_SERVER['REQUEST_URI'] != '/departments/task?id=37'):?>
    <?php if($user):?>
        <?php if($user->user_type == 0):?>
            <div id="side_road">
                <?php require Yii::getAlias('@modules').'/departments/site/views/default/blocks/task_custom/roadmap_side.php'; ?>
            </div>
        <?php endif;?>
            <?php endif;?>
    <?php endif;?>
<?php endif;?>
<div class="task task-custom well well-sm" style="margin:30px auto;max-width:1024px;">
    <div class="hidden-task-id" style="display:none"><?php echo $task->id?></div>
    <div class="row">
        <div class="col-sm-12">
            <div class="task-bg">
                 <?= $custom ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("body").animate({"opacity":1},1000);
    $(document).ready(function(){
        $(".page-content-wrapper").mCustomScrollbar("destroy");
        $('.page-content-wrapper').mCustomScrollbar({
            setHeight: $('.page-content').css('minHeight'),
            theme:"dark"
        });
        var offs;
        if($('.well').height() > ($(window).height() - $('.page-header').height() - $(".page-footer").height())){
            offs = 30;
        }else{
            offs = $(".page-content").height() / 2 - $('.well').height() / 2 - 32;
        }
        // var offs = 32;
         // if
        $('.well').css({
            'margin-top': offs,
            'margin-bottom': offs
        });
        // $('.task-custom').css({'margin-top': $('.page-content').height() / 2 - $('.task-custom').height() / 2});
        // $(".task-custom .personal-fields .form-control[name='goal']").inputmask('999,999,999.99', {
        //     // numericInput: true,
        //     // rightAlignNumerics: false,
        //     // greedy: false
        // });
        $(".task-custom .personal-fields [data-toggle='popover']").popover({
            container: '#task',
            placement: "bottom",
            html: true,
            content : $("#datepicker")
        });
        $(".task-custom .personal-fields [data-toggle='popover']").on('shown.bs.popover', function () {
            $("#datepicker").show();
        });
        $("#datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0,
            showWeek: false,
            numberOfMonths: 1,
            onSelect : function(dateText, inst){
                $(".task-custom .personal-fields .form-control[name='date']").val(dateText);
                $(".task-custom .personal-fields [data-toggle='popover']").popover('hide');
            }
            // selectOtherMonths: true,

        });
        $(".task-title .btn-success").click(function(e){
            if($('.task-custom .personal-fields .form-control[name="goal"]').val() != '' && $('.task-custom .personal-fields .form-control[name="date"]').val() != ''){
                $(this).removeClass('static');
            }else{
                e.preventDefault();
                $(this).addClass('static');
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
                toastr.warning("Please, fill all fields", "Attention");
            }
        });
    });
</script>