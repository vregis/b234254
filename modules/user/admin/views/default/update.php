<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullName, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$userMod = Yii::$app->getModule('user');

?>

<h2><i class="glyphicon glyphicon-user"></i> <?= $model->fullName ?>

    <?php if (!$model->getIsConfirmed()): ?>
        <?=
        Html::a(
            'Активировать',
            ['confirm', 'id' => $model->id],
            ['class' => 'btn btn-success btn-xs', 'data-method' => 'post']
        ) ?>
    <?php endif ?>

    <?php if (!$model->getIsAdmin()): ?>

        <?php if ($model->getIsBlocked()): ?>
            <?=
            Html::a(
                'Разблокировать',
                [
                    'block',
                    'id' => $model->id
                ],
                [
                    'class' => 'btn btn-success btn-xs',
                    'data-method' => 'post',
                    'data-confirm_message' => 'Вы уверены, что хотите разблокировать пользователя?'
                ]
            ) ?>
        <?php else: ?>
            <?=
            Html::a(
                'Заблокировать',
                [
                    'block',
                    'id' => $model->id
                ],
                [
                    'class' => 'btn btn-danger btn-xs',
                    'data-method' => 'post',
                    'data-confirm_message' => 'Вы уверены, что хотите заблокировать пользователя?'
                ]
            ) ?>
        <?php endif ?>

    <?php endif ?>

</h2>

<?php if (Yii::$app->session->hasFlash('admin_user')): ?>
    <div class="alert alert-success">
        <p><?= Yii::$app->session->getFlash('admin_user') ?></p>
    </div>
<?php endif ?>

<div class="panel panel-info">
    <div class="panel-heading"><?= 'Информация' ?></div>
    <div class="panel-body">
        <?=
        Yii::t('core', 'Зарегистрирован: {0, date,  dd MMMM YYYY HH:mm} с {1}',
            [$model->created_at, is_null($model->registration_ip) ? 'N/D' : long2ip($model->registration_ip)]) ?>
        <br/>
        <?php if ($userMod->enableConfirmation && $model->getIsConfirmed()): ?>
            <?= Yii::t('core', 'Активирован: {0, date, dd MMMM YYYY HH:mm}', [$model->created_at]) ?>
            <br/>
        <?php endif ?>
        <?php if ($model->getIsBlocked()): ?>
            <?= Yii::t('core', 'Заблокирован  {0, date, MMMM dd, YYYY HH:mm}', [$model->blocked_at]) ?>
        <?php endif ?>
    </div>
</div>

<?php
if(Yii::$app->user->id != 1): // если супер админ , то ему все можно
if ($model->getIsAdmin() || $model->id == $model::SYSTEM_USER_ID || $model->getIsSuperAdmin()): ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?= $this->title ?>
        </div>
        <div class="panel-body">

            <?= 'Редактирование данного пользователя запрещено' ?>

        </div>
    </div>

    <?php return ?>

<?php endif;  ?>
<?php endif;  ?>



<?php $form = ActiveForm::begin() ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= $this->title ?>
    </div>
    <div class="panel-body">

        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'role')->dropDownList($model::getRolesArray()) ?>

    </div>
</div>

<?= Html::submitButton('Подтвердить',['class' => 'btn btn-success btn-xs']) ?>

<?php ActiveForm::end() ?>
