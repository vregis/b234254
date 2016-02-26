<?php

//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Url;
//use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var modules\core\site\base\View $this
 */

$this->registerCssFile("/css/test.css");
$this->registerCssFile("/css/page_test.css");

$this->registerJsFile("/js/tests/main.js");

$i = 0;
/*foreach($test_options as $test_option) {
    $initJs = 'noUiSlider.create($("#slider-range-'.$i.'"),
        {
            start: '.intval((count($test_options) + 1)/2).',
            connect: "lower",
            range: {
                "min": 1,
              "max": '.count($test_options).'
            },
            change: function (event, ui) {
                var name = "#testprogress-'.$i.'-option";
                $(name).val(ui.value);
            }
        });';
    $this->registerJs($initJs);
    $i++;
}
*/

$this->title = 'Progress test';

?>
        <?php $form = ActiveForm::begin(
    [
        'id' => 'task-form'
    ]
) ?>
    <input type="text" name="_csrf" value="<?= Yii::$app->getRequest()->getCsrfToken() ?>" hidden>
    <input type="text" name="step" value="<?= $step ?>" hidden>
    <? $i=0; ?>
    <? foreach($test_category as $category) : ?>
        <? $questions = $test_questions[$i]; ?>

        <div class="col-md-6 task-form-wrapper">
        <div class="well">
         <h3><? echo (($step + $i)*count($test_options) + 1).'-'.(($step + $i)*count($test_options) + count($test_options)).' of '.($count*count($questions)); ?></h3>
           

            <? $j=0; ?>
            <? foreach($questions as $question) : ?>
                <? $name = Yii::$app->controller->getQuestionName($question->name) ?>
                <div class="question-name">
                    <? if(is_array($name)) : ?>
                        <h4 class="text-center"><? if($j == 0) echo $category->name; ?></h4>
                        <h4 class="left pull-left"><?= $name[0] ?></h4>
                        <h4 class="right pull-left"><?= $name[1] ?></h4>
                    <? else: ?>
                        <h4 class="text-center"><?= $name ?></h4>
                        <h4 class="left pull-left">No</h4>
                        <h4 class="right pull-right">Yes</h4>
                    <? endif; ?>
                </div>

                        <? $k=0; ?>
                        <? $items = []; ?>
                        <? foreach($test_options as $test_option) : ?>
                            <? $items[''+$k]= 'option';  ?>
                            <? $k++; ?>
                        <? endforeach; ?>
                        <? Yii::$app->params['items_progress'] = $items; ?>
                        <div class="step">
                            <?= $form->field($progress_model, 'option['.$i.']'.'['.$j.']',[
                                    'options'=>
                                        [
                                            'tag'=>'div',
                                            'class'=>'form-md-radios md-radio-inline b-page-checkbox-wrap'
                                        ]
                                ]
                            )
                            ->radioList($items, [
                                'unselect' => null, // remove hidden field
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    $checked_str = $checked ? 'checked' : '';
                                    return '<div class="md-radio has-test b-page-checkbox">
                                                <input type="radio" id="'.$name.'['.$index.']" name="'.$name.'" class="md-radiobtn" '.$checked_str.' value="'.$value.'">
                                                <label for="'.$name.'['.$index.']">
                                                    <span></span>
                                                    <span class="check"></span>
                                                    <span class="box"></span>
                                                </label>
                                            </div>'.($index == count(Yii::$app->params['items_progress']) - 1 ? '<div style="display:inline-block;width:100%;"></div>' : '');
                                }
                            ])->label(false) ?>
                        </div>
                <? $j++; ?>
            <? endforeach; ?>
                <div class="action-btn">
                    <div class="col-md-12 col-sm-12 col-xs-12">      
                        <div class="text-center">
                            <?php if($i == 1):?>
                        <?=
                        Html::a(
                        'Next',
                        Url::toRoute(['']),
                        [
                            'class' => 'btn btn-success',
                            'data-method' => 'post'
                            ]
                        )?>
                            <?php endif;?>
                        <? if($step != 0) : ?>
                            <?php if($i == 0):?>
                                <a href="<?= Url::toRoute(['/tests/progress','step' => $step - 2]) ?>" class="btn btn-primary">Back</a>
                            <?php else:?>
                            <? endif; ?>

                            <?php else:?>
                            <?php if($i == 0):?>
                            <a style="opacity:0" href="<?= Url::toRoute(['/tests/progress','step' => $step - 2]) ?>" class="btn btn-primary">Back</a>
                                <?php endif;?>
                        <? endif; ?>
                        </div>  
                    </div>
                    <div class="clearfix"></div>
                </div>
           
        </div>
        </div>

        <? $i++; ?>
    <? endforeach; ?>
<div class="clearfix"></div>
<?php $user = \modules\user\models\User::find()->where(['id' => Yii::$app->user->id])->one();?>
<?php if($user):?>
<?php if($user->user_type == 0):?>
    <div id="side_road">
        <?php require Yii::getAlias('@modules').'/departments/site/views/default/blocks/task_custom/roadmap_side.php'; ?>
    </div>
<?php endif;?>
<?php endif;?>
<script>
    $(document).ready(function(){
        // console.log("page-content: "+parseInt($('.page-content').css('min-height')) / 2);
        // console.log($('#task-form').height() /2);
        var offsetHor = (($(window).width() - $('.well').width() * 2) / 3);
        console.log(offsetHor);
        $('.task-form-wrapper').first().css({
            'padding-left':offsetHor + 50,
            'padding-right':(offsetHor+50) / 2
        });
        $('.task-form-wrapper').last().css({
            'padding-left':(offsetHor+50) / 2,
            'padding-right':offsetHor + 50
        });
        $('#task-form').css({'margin-top': parseInt($('.page-content').css('min-height')) / 2 - $('#task-form').height() / 2});
        $('#task-form').animate({'opacity':1},1000);
        console.log($('.well').width());

        // $('.task-form-wrapper').first().find('.well').width()
    });
</script>
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
            content: '<?php echo \modules\departments\tool\TaskComponent::getTaskDesc(39);?>'
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
<?php ActiveForm::end() ?>


