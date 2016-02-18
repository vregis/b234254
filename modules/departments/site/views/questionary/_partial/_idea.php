<?php

//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use modules\departments\models\Industry;
use yii\helpers\ArrayHelper;

/**
 * @var modules\core\site\base\View $this
 */
$this->registerCssFile("/css/page_idea.css");

$this->registerJsFile("/js/global/idea-constructor.js");

?>
<h3 class="form-title col-md-12 b-idea-title">Creating ideas</h3>
<div class="col-md-6 b-ideablock-wrapper">
    <div class="b-ideablock">
        <div class="b-ideablock-head" id="ideablock-name"><?= $idea->name ?></div>
        <p class="b-ideablock-text" id="ideablock-like"><?= $idea->description_like ?></p>
        <p class="b-ideablock-text" id="ideablock-problem"><?= $idea->description_problem ?></p>
        <p class="b-ideablock-text" id="ideablock-planning"><?= $idea->description_planning ?></p>
        <p class="b-ideablock-text font-blue-steel" id="ideablock-industry"><? if($idea->industry_id > 0): ?><?= $industries[$idea->industry_id] ?> industry<? endif; ?></p>
        <?= Html::a('No idea? No problem!', '/departments/questionary/next',['class' => 'btn btn-lg green b-btn-no-idea']) ?>
    </div>
    <div class="clearfix"></div>
</div>
<div class="col-md-6">
    <div id="idea" class="col-md-12">
        <?php $form = ActiveForm::begin(
            [
                'id' => 'idea-form'
            ]
        ) ?>

        <div class="col-md-6   nopadding">
            <?=
            $form->field($idea, 'name')->textInput(
                [
                    'class' => 'form-control placeholder-no-fix',
                ]

            ) ?>
        </div>
        <div class="col-md-6  nopadding col-md-right">


            <?= $form->field($idea, 'industry_id')
                ->dropDownList(
                    ArrayHelper::merge (['' => ''],$industries),           // Flat array ('id'=>'label')
                    ['class'=>'form-control select2']    // options
                );
            ?>
        </div>
        <div class="clearfix"></div>
        <?=
        $form->field($idea, 'description_like')->textarea(
            [
                'class' => 'form-control b-form-textarea',
                'style' => 'resize: vertical'
            ]
        ) ?>
        <?=
        $form->field($idea, 'description_problem')->textarea(
            [
                'class' => 'form-control b-form-textarea',
                'style' => 'resize: vertical'
            ]
        ) ?>
        <?=
        $form->field($idea, 'description_planning')->textarea(
            [
                'class' => 'form-control b-form-textarea',
                'style' => 'resize: vertical'
            ]
        ) ?>


        <?= Html::submitButton('Save <i class="fa fa-download"></i>', ['class' => 'btn btn-lg btn-primary b-btn-save']) ?>
        <?php ActiveForm::end() ?>

    </div>
</div>


    <script>
        $( document ).ready(function() {
            $("#idea-form .select2").click(function()
            {
                $(this).toggleClass("select2-active");
            }                            );
            jQuery(function($){
                $(document).mouseup(function (e){
                    var div = $("#idea-form .select2");
                    if (!div.is(e.target)
                        && div.has(e.target).length === 0) {
                        div.removeClass("select2-active");
                    }
                });
            });
        });
    </script>
