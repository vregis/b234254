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
            <?php if($i == 0):?>
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