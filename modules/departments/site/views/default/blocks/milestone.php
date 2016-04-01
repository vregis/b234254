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
<?php $chj = 0;?>

<?php if($userTool->user_id == Yii::$app->user->id):?>
    <?php $is_my = true;?>
<?php else:?>
    <?php $is_my = false;?>
<?php endif;?>

<?php foreach($milestones as $ml):?>

    <?php $user = \modules\user\models\User::find()->where(['id'=>Yii::$app->user->id])->one();?>
    <?php $user_p = \modules\user\models\Profile::find()->where(['user_id'=>Yii::$app->user->id])->one();?>

    <?php
    $response = Yii::$app->controller->sort($ml, false, $userTool, $avatar, 1);
    if($userTool->user_id != Yii::$app->user->id && count($response['tasks']) == 0) {
        $chj++;
        continue;
    }
    ?>
    <?php if(count($response['tasks']) > 0):?>
        <?php $ml->is_pay = 0;?>
    <?php else:?>
        <?php $ml->is_pay = 1;?>
    <?php endif; ?>
    <?php $jj++; ?>

    <?php $table = $response['table'];?>
    <?php $gant = $response['gant'];?>
    <?php $tasks = $response['tasks'];?>
    <?php $delegate_tasks = $response['delegate_tasks']; ?>
    <?php $delegate_tasks = $response['delegate_tasks']; ?>
    <?php $specializations = $response['specializations']; ?>
    <?php $milestones_users = $response['milestones_users'] ?>
    <?php //if(count($tasks) > 0):?>

    <?php $kk = 0;?>
    <?php foreach($tasks as $ts):?>
        <?php if($ts->status == 2):?>
            <?php $kk++;?>
        <?php endif; ?>
    <?php endforeach; ?>

    <? $key = $ml->id!=-1 ? $ml->id : 'All'?>

<div style="display:none" class="panel-group milestones start<?php echo $jj?>" data-milestone_id = "<?php echo $key?>" id="accordion<?php echo $key?>">
    <div class="panel panel-default gant">
        <div class="panel-heading" role="tab" id="headingOne2">
            <div class="info">
                <div class="pull-left <?php echo $ml->is_pay == 1? 'pay':''?>" data-parent=".milestones" data-placement="top" data-toggle="collapse"<?php echo $ml->is_pay == 1? 'href = "#collapse"':'href = "#collapseOne'.$key.'"'?> aria-expanded="false" aria-controls="collapseOne2" data-content="Will be available in the next version">
                    <button class="panel-toggle btn-empty unset_session" ><i class="fa fa-angle-down"></i></button>
                    <h4 class="panel-title" <?php if(strlen($ml->name) >18):?> data-toggle="popover" data-trigger="hover" data-content="<?= $ml->name ?>"<?php endif;?>><?php echo $ml->name?> <span class="c_count"></span></h4>
                </div>
                <div class="btns pull-right">
                    <button class="btn-empty btn-info" data-toggle="popover" data-content="<?= $ml->description ?>">i</button>
                    <div class="typeSwitch hide">
                        <!--<label class="live off">L</a>-->
                        <input data-color="#53d769" type="checkbox" id="typeSwitch<?php echo $key?>" checked class="js-switch js-check-change" name="view">
                        <!--<label class="control-label bus">G</label>-->
                    </div>
                    <?php if($kk == count($tasks) && count($tasks) != 0):?>
                        <span class="label label-lg"><?php //echo count($tasks) == 0?'<img src="/images/galka-2.png" alt="" class="check">':''; ?><img src="/images/galka-2.png" alt="" class="check"></span>
                    <?php else:?>
                    <span class="label label-lg"><?php //echo count($tasks) == 0?'<img src="/images/galka-2.png" alt="" class="check">':''; ?>  <?php echo count($tasks)!=0?count($tasks)-$kk:''?> <span style="display:none" class="label2 label-danger circle">3</span></span>
                    <?php endif;?>
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
                                    <div <?php if($ml->id==-1):?>style="padding: 0 20px 0 38px;" <?php endif; ?>data-id='<?php echo $dep->id?>' class="btn">
                                    <?php if($ml->id==-1):?>
                                        <?php if($is_my == true):?>
                                            <?php $do_dep = \modules\departments\models\UserDo::find()->where(['department_id' => $dep->id, 'user_id' => Yii::$app->user->id, 'status_do' => 1])->one();?>
                                            <?php if($do_dep):?>
                                                <a data-toggle="popover" class="btn btn-empty circle"><img style="margin:0" class="gant_avatar" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" src = '<?php echo $user_p->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$user_p->avatar:'/images/avatar/nophoto.png'?>'></a>
                                            <?php else:?>
                                                <?php $delegate_dep = \modules\departments\models\Team::find()->where(['sender_id' => Yii::$app->user->id, 'department' => $dep->id, 'status' => 1, 'user_tool_id' => $userTool->id])->one();?>
                                                <?php if($delegate_dep):?>
                                                    <?php $del_us = Profile::find()->where(['user_id' => $delegate_dep->recipient_id])->one();?>
                                                    <a data-toggle="popover" class="btn btn-empty circle"><img style="margin:0" class="gant_avatar" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" src = '<?php echo $del_us->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$del_us->avatar:'/images/avatar/nophoto.png'?>'></a>
                                                <?php else:?>
                                                <a data-toggle="popover" class="btn btn-empty circle"><i class="ico-delegate"></i></a>
                                                    <?php endif;?>
                                            <?php endif; ?>
                                                <?php else:?>
                                                    <?php $do_dep = \modules\departments\models\UserDo::find()->where(['department_id' => $dep->id, 'user_id' => $userTool->user_id, 'status_do' => 1])->one();?>
                                                        <?php $master_profile = Profile::find()->where(['user_id' => $userTool->user_id])->one();?>
                                                    <?php if($do_dep):?>
                                                        <a data-toggle="popover" class="btn btn-empty circle"><img style="margin:0" class="gant_avatar" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" src = '<?php echo $master_profile->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$master_profile->avatar:'/images/avatar/nophoto.png'?>'></a>
                                                    <?php else:?>
                                                        <?php $delegate_dep = \modules\departments\models\Team::find()->where(['sender_id' => $userTool->user_id, 'department' => $dep->id, 'status' => 1, 'user_tool_id' => $userTool->id])->one();?>
                                                        <?php if($delegate_dep):?>
                                                            <?php $del_us = Profile::find()->where(['user_id' => $delegate_dep->recipient_id])->one();?>
                                                            <a data-toggle="popover" class="btn btn-empty circle"><img style="margin:0" class="gant_avatar" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" src = '<?php echo $del_us->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$del_us->avatar:'/images/avatar/nophoto.png'?>'></a>
                                                        <?php else:?>
                                                            <a data-toggle="popover" class="btn btn-empty circle"><i class="ico-delegate"></i></a>
                                                        <?php endif;?>
                                                    <?php endif; ?>
                                            <?php endif;?>
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
        <div id="collapseOne<?php echo $key?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne2">
            <div class="panel-body">
                
                <div class="wrapper list" style="position: absolute; width:100%;height: 100%;min-height: 100%;">
                    <div class="" style="height: 100%;min-height: 100%;">
                        <table id="datatable_ajax" class="table table-bordered table-condensed flip-content" style="display:none;height: 100%;min-height: 100%;" >
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
                <?= $milestones_users ?>
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
                    
                    panel.find(".wrapper.list").animate({'opacity':0},250);
                    setTimeout(function(){panel.find(".wrapper.gant").animate({'opacity':1},250);},250);
                    // panel.find(".wrapper.list").fadeOut(500);
                    // panel.find(".wrapper.gant").fadeIn(500);
                    panel.removeClass('list');
                    panel.addClass('gant');
                    console.log("asdas");   

                }else{
                    var panel = $(changeCheckbox<?php echo $key?>).closest('.panel.panel-default');
                    panel.find(".wrapper.gant").animate({'opacity':0},250);
                    setTimeout(function(){panel.find(".wrapper.list").animate({'opacity':1},250);},250);
                    
                    // panel.find(".wrapper.gant").css('bottom',0);
                    // panel.find(".wrapper.gant").fadeOut(500);
                    // panel.find(".wrapper.list").fadeIn(500);
                    panel.find('.flip-content').show();
                    panel.removeClass('gant');
                    panel.addClass('list');
                }
                $(".milestones-users .gant_avatar").popover({
                    placement: "bottom",
                    html:true,
                    container: $("body"),
                    trigger:"hover",
                    template:'<div class="popover gant_av" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                    content : 'Steve Ballmer'
                });
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

<?php if($jj == 0):?>
    <?php header('location: /departments/business#delegated');?>
    <?php die();?>
<?php endif;?>

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
