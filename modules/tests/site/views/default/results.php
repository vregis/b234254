<?php

//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Url;
//use yii\widgets\Pjax;

/**
 * @var modules\core\site\base\View $this
 */

$this->registerCssFile("/css/test_result.css");

$this->registerJsFile("/js/global/test_result.js");

$this->title = 'Your role in business';

//var_dump($test_result_inform); die();
?>
<?php $user = \modules\user\models\User::find()->where(['id' => Yii::$app->user->id])->one();?>
<?php if($user):?>
<?php if($user->user_type == 0):?>
    <!-- <div id="side_road"> -->
        <?php //require Yii::getAlias('@modules').'/departments/site/views/default/blocks/task_custom/roadmap_side.php'; ?>
    <!-- </div> -->
<?php endif;?>
<?php endif;?>
<div class="well" style="max-width: 1170px;margin: 0 auto;padding:0 70px !important;">
    <div class="test-body">
    <div class="header text-center" style="font-size:20px;color:#777879;line-height:70px;">Your business roles</div>
    <div class="portlet box">
        <div class="portlet-body">
            <? for($i = 0;$i< count($test_result_inform); $i++) : ?>
            <?php $progressWidth = (($test_result_inform[$i]['user_result']->points-$min_points)/($max_points-$min_points))*100;
                   if($progressWidth <= 35){
                       $progressWidth = 35;
                   } 
            ?>
                <?php //$test_result_inform[$i]['user_result']['points']; - это число поинтов?>
            <?php if($i == 0):?>

                    <?php $ud = new \modules\departments\models\UserDo();?>
                    <?php $ud->user_id = Yii::$app->user->id;?>
                    <?php $ud->department_id = $test_result_inform[$i]['result']->department_id?>
                    <?php $user = \modules\user\models\User::find()->where(['id' => Yii::$app->user->id])->one();?>
                    <?php if($user->user_type == 0):?>
                        <?php $ud->status_do = 1;?>
                    <?php else:?>
                        <?php $ud->status_sell = 1;?>
                        <?php $ud->status_show = 1;?>
                        <?php $user->user_status = 3;?>
                        <?php $user->save();?>
                    <?php endif;?>
                    <?php //$ud->save();?>


            <div class="test-line">
                <div class="test-result" id="<?=$i?>" data="<?= (($test_result_inform[$i]['user_result']->points-$min_points)/($max_points-$min_points)) ?>">
                    <div class="name-table progress " style="background-color: <?= $test_result_inform[$i]['result']->color ?>;width:0%;">
                        <div class="name-cell progress-bar" 
                        role="progressbar" aria-valuenow="<?= $progressWidth; ?>" 
                        aria-valuemin="0" aria-valuemax="100" 
                        style="background-color: <?= $test_result_inform[$i]['result']->color ?>;width:100%;">
                        <div class="icon"><i class="ico-<?php echo $test_result_inform[$i]['result']->icons?>"></i></div>
                        <div class="text">
                                <div class="hui1">
                            <?
                            if($i == 0) {
                                echo $test_result_inform[$i]['result']->title_high;
                            }elseif($i > 0 && $i < 6){
                                echo preg_replace('/\\s*\\([^()]*\\)\\s*/', '', $test_result_inform[$i]['result']->title_medium);
                            }else{
                                echo preg_replace('/\\s*\\([^()]*\\)\\s*/', '', $test_result_inform[$i]['result']->title_low);
                            }
                            ?>
                                </div>
                                <div class="hui2"><?php echo $test_result_inform[$i]['result']->name?></div>
                            </div>
                            <div class="result-integer"><?php echo floor($test_result_inform[$i]['user_result']->points*(100/$max_points))?>%<? //=$test_result_inform[$i]['user_result']['points']?></div>
                            <i class="fa fa-angle-up"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div id="collapse<?=$i?>" class="collapse <? if($i==0) echo 'in'; ?>">
                <div class="test-description background-<?php echo $test_result_inform[$i]['result']->department_id?>">
                    <?
                    if($i == 0) {
                        echo $test_result_inform[$i]['result']->description_high;
                    }elseif($i > 0 && $i < 6) {
                        echo $test_result_inform[$i]['result']->description_medium;
                    }else{
                        echo $test_result_inform[$i]['result']->description_low;
                    }
                    ?>
                </div>
            </div>
            <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>


    
    <div class="portlet box">
        <div class="portlet-body">
            <? for($i = 0;$i< count($test_result_inform); $i++) : ?>



            <?php $progressWidth = (($test_result_inform[$i]['user_result']->points-$min_points)/($max_points-$min_points))*100;
                   if($progressWidth <= 35){
                       $progressWidth = 35;
                   } 
            ?>
            <?php if($i >= 1 && $i <= 5):?>
            <div class="test-line">
                <div class="test-result" id="<?=$i?>">
                    <div class="name-table progress " style="background-color: <?= $test_result_inform[$i]['result']->color ?>;width:0%;">
                        <div class="name-cell progress-bar" 
                        role="progressbar" aria-valuenow="<?= $progressWidth; ?>" 
                        aria-valuemin="0" aria-valuemax="100" 
                        style="background-color: <?= $test_result_inform[$i]['result']->color ?>;width:100%;">
                        <div class="icon"><i class="ico-<?php echo $test_result_inform[$i]['result']->icons?>"></i></div>
                        <div class="text">
                                <div class="hui1">
                            <?
                            if($i == 0) {
                                echo $test_result_inform[$i]['result']->title_high;
                            }elseif($i > 0 && $i < 6){
                                echo preg_replace('/\\s*\\([^()]*\\)\\s*/', '', $test_result_inform[$i]['result']->title_medium);
                            }else{
                                echo preg_replace('/\\s*\\([^()]*\\)\\s*/', '', $test_result_inform[$i]['result']->title_low);
                            }
                            ?>
                                </div>
                                <div class="hui2"><?php echo $test_result_inform[$i]['result']->name?></div>
                            </div>
                            <div class="result-integer"><?php echo floor($test_result_inform[$i]['user_result']->points*(100/$max_points))?>%<? //=$test_result_inform[$i]['user_result']['points']?></div>
                            <i class="fa fa-angle-down"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div id="collapse<?=$i?>" class="collapse <? if($i==0) echo 'in'; ?>">
                <div class="test-description background-<?php echo $test_result_inform[$i]['result']->department_id?>">
                    <?
                    if($i == 0){
                        echo $test_result_inform[$i]['result']->description_high;
                    }elseif($i > 0 && $i < 6){
                        echo $test_result_inform[$i]['result']->description_medium;
                    }else{
                        echo $test_result_inform[$i]['result']->description_low;
                    }
                    ?>
                </div>
            </div>
            <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    
    
    <div class="portlet box">
        <div class="portlet-body">
            <? for($i = 0;$i< count($test_result_inform); $i++) : ?>
            <?php $progressWidth = (($test_result_inform[$i]['user_result']->points-$min_points)/($max_points-$min_points))*100;
                   if($progressWidth <= 35){
                       $progressWidth = 35;
                   } 
            ?>
            <?php if($i >= 6 && $i <= 7):?>
            <div class="test-line">
                <div class="test-result" id="<?=$i?>">
                    <div class="name-table progress " style="background-color: <?= $test_result_inform[$i]['result']->color ?>;width:0%;">
                         <div class="name-cell progress-bar" 
                        role="progressbar" aria-valuenow="<?= $progressWidth; ?>" 
                        aria-valuemin="30" aria-valuemax="100" 
                        style="background-color: <?= $test_result_inform[$i]['result']->color ?>;width:100%;">
                        <div class="icon"><i class="ico-<?php echo $test_result_inform[$i]['result']->icons?>"></i></div>
                        <div class="text">
                                <div class="hui1">
                            <?
                            if($i == 0) {
                                echo $test_result_inform[$i]['result']->title_high;
                            }elseif($i > 0 && $i < 6){
                                echo preg_replace('/\\s*\\([^()]*\\)\\s*/', '', $test_result_inform[$i]['result']->title_medium);
                            }else{
                                echo preg_replace('/\\s*\\([^()]*\\)\\s*/', '', $test_result_inform[$i]['result']->title_low);
                            }
                            ?>
                                </div>
                                <div class="hui2"><?php echo $test_result_inform[$i]['result']->name?></div>
                            </div>
                            <div class="result-integer"><?php echo floor($test_result_inform[$i]['user_result']->points*(100/$max_points))?>%<? //=$test_result_inform[$i]['user_result']['points']?></div>
                            <i class="fa fa-angle-down"></i>
                        </div>

                    </div>
                </div>
            </div>
            <div id="collapse<?=$i?>" class="collapse <? if($i==0) echo 'in'; ?>">
                <div class="test-description background-<?php echo $test_result_inform[$i]['result']->department_id?>">
                    <?
                    if($i == 0) {
                        echo $test_result_inform[$i]['result']->description_high;
                    }elseif($i > 0 && $i < 6){
                        echo $test_result_inform[$i]['result']->description_medium;
                    }else{
                        echo $test_result_inform[$i]['result']->description_low;
                    }
                    ?>
                </div>
            </div>
            <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    

        <div class="row">
            <div class="col-sm-12" style="overflow: hidden;">
                <div class="text-center" style="margin:30px auto;">
                    <a style="width:130px;" href="<?= $redirect_url ?>" class="btn btn-success get-started">Continue</a>
                </div>  
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function(){
        console.log($('.page-content').height() / 2);
        console.log($('.well').height() / 2);
        var offs = $('.page-content').height() / 2 - $('.well').height() / 2;
        if(offs < 32){
            offs = 32;
        }
        console.log(offs);
        $('.well').css({
            'margin-top': offs - 2,
            'margin-bottom': offs - 2
        });
    });
</script>
<?php $user = \modules\user\models\User::find()->where(['id' => Yii::$app->user->id])->one();?>
<?php if($user):?>
    <?php if($user->user_type == 0 && isset($_GET['first'])):?>
        <div id="side_road">
            <?php require Yii::getAlias('@modules').'/departments/site/views/default/blocks/task_custom/roadmap_side.php'; ?>
        </div>
    <?php endif;?>
<?php endif;?>
<script>
    $(document).ready(function(){
        $(".b-page-checkbox-wrap .md-radio:nth-child(3)").addClass('active');
        $("#side_road .item-2").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover top-fix item-2" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(282);?>'
        });
        $("#side_road .item-3").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover top-fix item-3" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(283);?>'
        });
        $("#side_road .item-4").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-4" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(37);?>'
        });
        $("#side_road .item-5").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-5" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(38);?>'
        });
        $("#side_road .item-6").popover({
            placement:"right auto",
            html:true,
            trigger:'hover',
            container:$("#side_road .wrapper"),
            template:'<div class="popover bottom-fix item-6" role="tooltip"><div class="arrow"></div><div class="popover-title"></div><div class="popover-content"></div></div>',
            content:'<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(39);?>'
        });
    });
</script>
<style>
    #side_road .progress{
        height:20%;
    }
/*  .b-page-checkbox-wrap .md-radio:nth-child(2) label > .box,.b-page-checkbox-wrap .md-radio:nth-child(3) label > .box{
        border-color: #26C281 !important;
    }*/
</style>