<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$msgJs = <<<JS
JS;
$this->registerJs($msgJs);
?>


<?php $form = ActiveForm::begin(
    [
        'id' => 'idea-form',
    ]
) ?>
    <h3 class="form-title col-md-12 b-idea-title">Edit ideas</h3>
<? require Yii::getAlias('@modules') . '/tasks/site/views/default/blocks/idea.php' ?>

<div class="col-md-12">
    <?= Html::a('Delete <i class="fa fa-trash-o"></i>',Url::toRoute(['/departments/business/delete-idea', 'id' => $idea->id]), ['class' => 'btn btn-lg btn-danger b-btn-delete pull-left']) ?>
    <?= Html::submitButton('Save <i class="fa fa-download"></i>', ['class' => 'btn btn-lg btn-primary pull-right']) ?>
</div>
<?php ActiveForm::end() ?>