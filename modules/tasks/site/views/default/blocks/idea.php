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
$this->registerJsFile("/js/min/underscore-min.js");
?>

<div id="idea" class="col-md-12">

    <?=
    $form->field($idea, 'name')->textInput(
        [
            'class' => 'form-control placeholder-no-fix',
        ]

    ) ?>
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
    <?= $form->field($idea, 'industry_id')
        ->dropDownList(
            ArrayHelper::merge (['' => ''],$industries),           // Flat array ('id'=>'label')
            ['class'=>'form-control select2']    // options
        );
    ?>

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
