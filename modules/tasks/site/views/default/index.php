<?php

//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Url;
//use yii\widgets\Pjax;
use modules\departments\models\Department;
use modules\departments\models\Specialization;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use modules\tasks\models\TaskUserLog;
use modules\user\models\Profile;
use modules\tasks\models\UserTool;

/**
 * @var modules\core\site\base\View $this
 */

$this->registerCssFile("/plugins/datetimepicker/jquery.datetimepicker.css");
$this->registerCssFile("/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.min.css");

$this->registerJsFile("/plugins/datetimepicker/build/jquery.datetimepicker.full.min.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js");
$this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-ui/jquery-ui.min.js");
$this->registerJsFile("/js/readmore.min.js");
$this->registerJsFile("/js/global/task.js");


$this->registerCssFile("/fonts/Open Sans/OpenSans-Bold.css");
// $this->registerCssFile("/css/page_test.css");
$this->registerCssFile("/css/task.css");

$this->title = 'Главная страница';

function getMonth($number) {
    $month = '';
    switch ($number) {
        case 1:
            $month = 'Jan';
            break;
        case 2:
            $month = 'Feb';
            break;
        case 3:
            $month = 'Mar';
            break;
        case 4:
            $month = 'Apr';
            break;
        case 5:index
            $month = 'May';
            break;
        case 6:
            $month = 'June';
            break;
        case 7:
            $month = 'July';
            break;
        case 8:
            $month = 'Aug';
            break;
        case 9:index
            $month = 'Sept';
            break;
        case 10:
            $month = 'Oct';
            break;
        case 11:
            $month = 'Nov';
            break;
        case 12:
            $month = 'Dec';
            break;
    }index
    return $month;
}

$start_m = '';index
$start_d = '';
if($task_user->start != '') {
    preg_match("#(\d+)-(\d+)-(\d+)#", $task_user->start,$mathces);
    $start_m = getMonth($mathces[2]);
    $start_d = intval($mathces[3]);
}
$end_m = '';
$end_d = '';
if($task_user->end != '') {
    preg_match("#(\d+)-(\d+)-(\d+)#", $task_user->end,$mathces);
    $end_m = getMonth($mathces[2]);
    $end_d = intval($mathces[3]);
}

$specialization = null;
if($task->specialization_id > 0) {
    $specialization = Specialization::find()->where(['id' => $task->specialization_id])->one();
}

?>
<?php $form = ActiveForm::begin(
    [
        'id' => 'task-form',
    ]
) ?>
<div class="task">
    <div class="row">
        <div class="col-sm-12">
            <div class="well well-sm task-bg">
                <div class="row">
                    <div class="col-sm-12">
                        <?=$form->field($task_user, 'end')->hiddenInput()->label(false) ?>
                        <?=$form->field($task_user, 'start',
                            [
                                'template' => '{input}{error}',
                                'errorOptions'=>['class'=>'help-block alert alert-danger']
                            ]
                        )->hiddenInput()->label(false) ?>
                    </div>
                </div>

                    <div class="row task-title">
                        <div class="name pull-left"><?= $task->name ?></div>
                        <div class="pull-right inline">
                            <div class="item time"><i class="icon" data-toggle="popover" data-placement="bottom" data-content="test"></i> 1 hour</div>
                            <div class="item date">
                                <div id="datepicker" class="collapse"></div>
                                <input type="hidden" id="input-href" name="href" value="none">
                                <i class="icon"></i> 4 Jan-10 Jan
                            </div>
                            <div class="item cost"><i class="icon" data-toggle="popover" data-placement="bottom" data-content="test"></i> 100</div>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#delegateModal">Delegate</button>
                            <input type="hidden" id="taskuser-status" name="TaskUser[status]" value="<?= $task_user->status ?>">
                            <button class="btn btn-success">Perform</button>
                            <a class="href-black task-close"></a>
                        </div>
                    </div>
                    <div class="row task-body">
                        <div class="col1">
                            <div class="title">Speciality:  Speciality name</div>
                            <div class="block desc">
                                <div class="content">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam condimentum at nisi et maximus. Quisque sed erat lacinia, posuere nulla sit amet, malesuada nunc. Curabitur quis molestie diam. Vivamus id luctus leo. Proin rutrum porta egestas. Aenean a neque sed leo posuere dictum. Pellentesque sit amet diam augue. Curabitur dapibus enim id faucibus aliquet. Nullam viverra porttitor rutrum. Vestibulum sem risus, ultrices cursus sapien at, placerat viverra odio. Vestibulum vitae nulla ut diam rhoncus cursus eget et eros. Integer vel ex velit. Pellentesque leo leo, bibendum quis massa lobortis, semper aliquet orci. Quisque consectetur et urna vel aliquet. Phasellus tempor cursus varius. Maecenas facilisis vel arcu eget laoreet.
                                </div>
                                <div class="footer">
                                    <div>
                                        <div class="btn-group btn-group-justified">
                                            <div class="btn" data-toggle="popover" data-placement="bottom" data-content="test">
                                                <i class="icon-camcorder"></i>
                                                <span class="text">Video</span>
                                                <span class="label">4</span>
                                            </div>
                                            <div class="btn" data-toggle="popover" data-placement="bottom" data-content="test">
                                                <i class="icon-music-tone-alt"></i>
                                                <span class="text">Sound</span>
                                                <span class="label">4</span>
                                            </div>
                                            <div class="btn" data-toggle="popover" data-placement="bottom" data-content="test">
                                                <i class="icon-doc"></i>
                                                <span class="text">Doc</span>
                                            </div>
                                            <div class="btn" data-toggle="popover" data-placement="bottom" data-content="test">
                                                <i class="icon-drawer"></i>
                                                <span class="text">Archive</span>
                                                <span class="label">14</span>
                                            </div>
                                            <div class="btn" data-toggle="popover" data-placement="bottom" data-content="test">
                                                <i class="icon-link"></i>
                                                <span class="text">Link</span>
                                            </div>
                                            <div class="btn" data-toggle="popover" data-placement="bottom" data-content="test">
                                                <i class="icon-note"></i>
                                                <span class="text">Notes</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="title">Is this task was helpful to you?</div>
                            <div class="step">
                                <div class="question-name">
                                        <h4 class="left pull-left">No</h4>
                                        <h4 class="right pull-right">Yes</h4>
                                        <div class="clearfix"></div>
                                </div>
                                <div class="form-md-radios md-radio-inline b-page-checkbox-wrap field-testprogressform-option-0-1 required">

<div id="testprogressform-option-0-1"><div class="md-radio has-test b-page-checkbox">
                                                <input type="radio" id="TestProgressForm[option][0][1][0]" name="TestProgressForm[option][0][1]" class="md-radiobtn" value="0">
                                                <label for="TestProgressForm[option][0][1][0]">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
<div class="md-radio has-test b-page-checkbox">
                                                <input type="radio" id="TestProgressForm[option][0][1][1]" name="TestProgressForm[option][0][1]" class="md-radiobtn" value="1">
                                                <label for="TestProgressForm[option][0][1][1]">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
<div class="md-radio has-test b-page-checkbox">
                                                <input type="radio" id="TestProgressForm[option][0][1][2]" name="TestProgressForm[option][0][1]" class="md-radiobtn" value="2">
                                                <label for="TestProgressForm[option][0][1][2]">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>
<div class="md-radio has-test b-page-checkbox">
                                                <input type="radio" id="TestProgressForm[option][0][1][3]" name="TestProgressForm[option][0][1]" class="md-radiobtn" value="3">
                                                <label for="TestProgressForm[option][0][1][3]">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div></div>
</div>
                            </div>
                        </div>
                        <div class="col2">
                            <div class="milestones-users">
                                <? foreach($delegate_tasks as $d_task) : ?>
                                    <a href="<?= Url::toRoute(['/tasks', 'id' => $task->id, 'task_user_id' => $task_user->id, 'delegate_task_id' => $d_task->id]) ?>">
                                        <img data-toggle="popover" class="active gant_avatar" src="<?php echo $d_task->delegate_avatar ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$d_task->delegate_avatar:'/images/avatar/nophoto.png'?>">
                                    </a>
                                <? endforeach; ?>
                                <button class="btn btn-success" style="margin-left:10px;">Accept</button>
                                <button class="btn btn-primary">Reject</button>
                            </div>
                            <div class="block chat">
                                <div class="content">
                                    <div class="ajax-content">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="portlet_tab1">
                                                <div class="scroller" style="height: 200px;">
                                                    <ol id="taskUserNotes">
                                                        <?= $taskUserNotes ?>
                                                    </ol>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="portlet_tab2">
                                                <div class="scroller" style="height: 200px;">
                                                    <ol id="taskUserMessages">
                                                    </ol>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="portlet_tab3">
                                                <div class="scroller" style="height: 200px;">
                                                    <ol>
                                                        <? foreach($taskUserLogs as $taskUserLog) : ?>
                                                            <li>
                                                                <?= $taskUserLog->log ?>
                                                                &nbsp;<?= $taskUserLog->date ?>
                                                            </li>
                                                        <? endforeach; ?>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="actions">
                                        <ul class="nav nav-tabs pull-right">
                                            <li class="active">
                                                <a href="#portlet_tab1" data-toggle="tab" id="btn-tab-note"> <span class="icon-pencil"></span></a>
                                            </li>
                                            <li>
                                                <a href="#portlet_tab2" data-toggle="tab" id="btn-tab-message"> <span class="icon-bubble"></span></a>
                                            </li>
                                            <li>
                                                <a href="#portlet_tab3" data-toggle="tab" id="btn-tab-log"> <span class="icon-book-open"></span></a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="footer">
                                   <div id="message-input">
                                       <input type="text" id="textarea-task" class="form-control" placeholder="Put your message here...">
                                       <button id="btn-note" type="submit" class="btn btn-primary"  data-delegate_task_id="<?= $delegate_task ? $delegate_task->id : 0 ?>" data-task_user_id="<?= $task_user->id ?>">Send</button>
                                   </div>
                                </div>
                            </div>
                            <div class="title">Feedback</div>
                            <div class="block feedback">

                                <div class="footer">
                                    <div>
                                        <input type="text" class="form-control" placeholder="Put your message here...">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="delegateModal" tabindex="-1" role="dialog" aria-labelledby="delegateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <? require __DIR__ . '/blocks/delegate.php' ?>
                </div>
            </div>
        </div>
    </div>
</div>
