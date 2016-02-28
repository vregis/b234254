<?php use modules\departments\models\Specialization;?>
<?php use modules\tasks\models\DelegateTask;
use modules\user\models\Profile;?>
<?php use modules\tasks\models\Task;?>
<?php use modules\tasks\models\UserTool;?>
<?php use yii\helpers\Url;?>
<?php use \modules\departments\models\Department;?>

<?php
$this->registerCssFile("/plugins/datetimepicker/jquery.datetimepicker.css");
$this->registerCssFile("/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.min.css");

$this->registerJsFile("/plugins/datetimepicker/build/jquery.datetimepicker.full.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js");
// $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.min.js");
$this->registerJsFile("/js/readmore.min.js");
$this->registerJsFile("/js/global/task.js");


$this->registerCssFile("/fonts/Open Sans/OpenSans-Bold.css");
// $this->registerCssFile("/css/page_test.css");
//$this->registerCssFile("/css/task.css");
?>


<script>
    $(document).on('click', '.unset_session', function(){
        $.ajax({
            url: '/departments/unsetsession',
            type: 'post',
            success: function(){
                console.log('session is empty');
            }
        })
    })
</script>
<?php $this->registerJsFile("/plugins/gantt/assets/js/custom/gantt_chart.js");
$this->registerJsFile("/plugins/gantt/assets/js/pages/plugins_gantt_chart.js");?>
<?php $jj = 0; ?>
<?php foreach($milestones as $ml):?>

    <?php $user = \modules\user\models\User::find()->where(['id'=>Yii::$app->user->id])->one();?>
    <?php if($user->role==6 || $user->role == 10):?>
        <?php $ml->is_pay = 0;?>
    <?php endif;?>
    <?php
    $response = Yii::$app->controller->sort($ml, false, $userTool, $avatar);
    if($userTool->user_id != Yii::$app->user->id && count($response['tasks']) == 0) {
        continue;
    }
    ?>
    <?php $jj++; ?>

    <?php $table = $response['table'];?>
    <?php $gant = $response['gant'];?>
    <?php $tasks = $response['tasks'];?>
    <?php $delegate_tasks = $response['delegate_tasks']; ?>
    <?php $delegate_tasks = $response['delegate_tasks']; ?>
    <?php $specializations = $response['specializations']; ?>
    <?php $milestones_users = $response['milestones_users'] ?>
    <?php //if(count($tasks) > 0):?>

    <? $key = $ml->id!=-1 ? $ml->id : 'All'?>

<div style="display:none" class="panel-group milestones start<?php echo $jj?>" data-milestone_id = "<?php echo $key?>" id="accordion<?php echo $key?>">
    <div class="panel panel-default gant">
        <div class="panel-heading" role="tab" id="headingOne2">
            <div class="info">
                <div class="pull-left <?php echo $ml->is_pay == 1? 'pay':''?>" data-parent=".milestones" data-placement="top" data-toggle="collapse"<?php echo $ml->is_pay == 1? 'href = "#collapse"':'href = "#collapseOne'.$key.'"'?> aria-expanded="false" aria-controls="collapseOne2" data-content="Will be available in the next version">
                    <button class="panel-toggle btn-empty unset_session" ><i class="fa fa-angle-down"></i></button>
                    <h4 class="panel-title" <?php if(strlen($ml->name) >12):?> data-toggle="popover" data-trigger="hover" data-content="<?= $ml->name ?>"<?php endif;?>><?php echo $ml->name?> <span class="c_count"></span></h4>
                </div>
                <div class="btns pull-right">
                    <button class="btn-empty btn-info" data-toggle="popover" data-content="<?= $ml->description ?>">i</button>
                    <?php if($ml->id!=-1):?>
                    <button class="btn-empty btn btn-primary delegate" style="height: 30px;width: 30px;line-height: 34px;" data-toggle="popover"><i class="ico-delegate"></i></button>
                    <?php endif; ?>
                    <div class="typeSwitch hide">
                        <!--<label class="live off">L</a>-->
                        <input data-color="#53d769" type="checkbox" id="typeSwitch<?php echo $key?>" checked class="js-switch js-check-change" name="view">
                        <!--<label class="control-label bus">G</label>-->
                    </div>
                    <span class="label label-lg"><?php //echo count($tasks) == 0?'<img src="/images/galka-2.png" alt="" class="check">':''; ?>  <?php echo count($tasks)!=0?count($tasks):''?> <span style="display:none" class="label2 label-danger circle">3</span></span>
                </div>
            </div>
            <div class="menu">
                <div class="hor-menu">
                    <div class="btn-group btn-group-justified">
                        <?php foreach($departments as $dep):?>

                            <?php if(isset($_POST['departments']) && !empty($_POST['departments']) && isset($_POST['milestone_id']) && $_POST['milestone_id'] == $ml->id):?>
                                <?php if(in_array($dep->id, $_POST['departments'])):?>
                                    <?php $class = 'on';?>
                                <?php else:?>
                                    <?php $class = 'off';?>
                                <?php endif;?>
                            <?php else:?>
                                <?php $class = 'on';?>
                            <?php endif;?>

                            <?php if($dep->id != 9):?>
                                <div data-id='<?php echo $dep->id?>' class="btn-group department open btn-idea dep <?php echo $class?> dep-color-<?php echo $dep->id?>">
                                    <div data-id='<?php echo $dep->id?>' class="btn">
                                    <?php if($ml->id==-1):?>
                                        <a data-toggle="popover" class="btn btn-empty circle"><i class="ico-delegate"></i></a>
                                    <?php endif; ?>
                                        <span class="text show568-"><?php echo $dep->name?></span>
                                    </div>

                                    <button class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                        <i class="fa fa-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right spec_list" role="menu">
                                        <?php $i = 0;?>

                                        <?php foreach(isset($specializations[$dep->id]) ? $specializations[$dep->id] : [] as $s):?>
                                            <?php $i++;?>
                                            <?php if(isset($_POST['spec']) && !empty($_POST['spec']) && isset($_POST['milestone_id']) && $_POST['milestone_id'] == $ml->id):?>
                                                <?php if(in_array($s->id, $_POST['spec'])):?>
                                                    <?php $cl = 'specon';?>
                                                <?php else:?>
                                                    <?php $cl = 'specoff';?>
                                                <?php endif;?>
                                            <?php else:?>
                                                <?php $cl = 'specon';?>
                                            <?php endif;?>
                                            <li class="<?php echo $cl?> spec-color-<?php echo $dep->id ?>"  data-id = '<?php echo $s->id?>'><?php echo $s->name?></li>
                                        <?php endforeach;?>
                                        <?php if($i == 0):?>
                                            <div class="empty"></div>
                                        <?php endif;?>
                                    </ul>
                                </div>
                            <?php endif;?>

                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div style="background:#EBEBEB;" id="collapseOne<?php echo $key?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne2">
            <div class="panel-body">
                <?= $milestones_users ?>
                <div class="wrapper list" style="position: absolute; display: none;">
                    <div class="">
                        <table id="datatable_ajax" class="table table-bordered table-striped table-condensed flip-content" style="display:none" >
                            <thead>
                            <tr role="row" class="heading no-sort">
                                <th class="no-sort" style="width:300px;">
                                </th>
                                <th class="no-sort">
                                    Specialty
                                </th>
                                <th class="no-sort">
                                    <span>Time</span>
                                </th>
                                <th class="th-status no-sort">
                                    Status
                                    <div class="btn-group">
                                        <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li class="sort_status" data-p = 'all'>All</li>
                                            <li class="sort_status" data-p = '0'>New</li>
                                            <li class="sort_status" data-p = '1'>Active</li>
                                            <li class="sort_status" data-p = '2'>
                                                Completed
                                            </li>
                                        </ul>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="ajaxbody<?php echo $key?>">
                                <?php echo $table?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="wrapper gant ganttable<?php echo $key?>">
                    <?php echo $gant?>
                </div>

            </div>
        </div>
    </div>
    <div style="display: none" id="ml<?php echo $key?>"></div>
</div>

    <script>
    
        var changeCheckbox<?php echo $key?> = document.querySelector('#typeSwitch<?php echo $key?>');
        if(changeCheckbox<?php echo $key?>){
            changeCheckbox<?php echo $key?>.onchange = function() {
                console.log(changeCheckbox<?php echo $key?>.checked);
                if(changeCheckbox<?php echo $key?>.checked == true){
                    var panel = $(changeCheckbox<?php echo $key?>).closest('.panel.panel-default');
                    panel.find(".wrapper.gant").css('position','static');
                    panel.find(".wrapper.list").css('position','absolute');
                    panel.find(".wrapper.list").fadeOut(500);
                    panel.find(".wrapper.gant").fadeIn(500);
                    panel.removeClass('list');
                    panel.addClass('gant');
                }else{
                    var panel = $(changeCheckbox<?php echo $key?>).closest('.panel.panel-default');
                    panel.find(".wrapper.list").css('position','static');
                    panel.find(".wrapper.gant").css('position','absolute');
                    panel.find(".wrapper.gant").css('bottom',0);
                    panel.find(".wrapper.gant").fadeOut(500);
                    panel.find(".wrapper.list").fadeIn(500);
                    panel.find('.flip-content').show();
                    panel.removeClass('gant');
                    panel.addClass('list');
                }
            };
        }

        $(function(){
            $('.pay').popover();
        })

    </script>

        <style>
            .panel-group {
                margin-bottom: 2px;
            }

            div.off .dropdown-toggle {
                display: none;
            }
        </style>


<?php //endif;?>
<?php endforeach;?>

<script>
    $(function(){
        $("h4.panel-title[data-toggle='popover']").popover({
            trigger:"hover",
            html:true,
            placement:"top"
        });
        for(i=1; i<=<?php echo $jj?>; i++){
            $('.start'+i+'').delay(i*50).fadeIn(500);
        }
    })
</script>
