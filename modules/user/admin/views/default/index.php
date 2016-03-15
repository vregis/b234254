<?php

use modules\core\helpers\DateHelper;
use modules\user\models\Profile;
use modules\user\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = $this->context->module->title;
$this->params['breadcrumbs'][] = $this->title;

$this->params['control'] = [
    'brandLabel' => $this->title,
    'create' => false
];

$userMod = Yii::$app->getModule('user');

$model = '\\\modules\\\user\\\models\\\User';
$msgJs = <<<JS

JS;
$this->registerJs($msgJs);
?>



<!-- BEGIN PAGE HEADER-->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="/admin">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="#"><?=$this->title?></a>
        </li>
    </ul>
</div>
<h3 class="page-title">
    <?=$this->title?>
</h3>

<div class="user-index">
    <?=
    GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",

            'columns' => [
                [
                    'attribute' => 'username',
                    'format' => 'html',
                    'value' => function ($model) {
                        $profile = '<a class="blank" href="/user/social/shared-profile?id='.$model->id.'" target="_blank" style="float:right">P</a>';
                        $tool = \modules\tasks\models\UserTool::find()
                            ->select('user_tool.*')
                            ->join('INNER JOIN', 'benefit', 'benefit.user_tool_id = user_tool.id')
                            ->where(['user_tool.user_id' => $model->id])->all();
                        if($tool){
                            $bus = '<a class="blank" href="/departments/business/shared-business?id='.$tool[0]->id.'" target="_blank" style="float:right; margin-right:7px">B</a>';
                        }else{
                            $bus = '';
                        }
                        return Html::a(Html::encode($model->username), ['update', 'id' => $model['id']]).$profile. '&nbsp&nbsp&nbsp'.$bus;
                    }
                ],
                [
                    'attribute' => 'email',
                    'format' => 'html',
                    'value' => function ($model) {
                        return Html::a(Html::encode($model->email), ['update', 'id' => $model['id']]);
                    }
                ],
                [
                    'attribute' => 'registration_ip',
                    'value' => function ($model) {
                        return $model->registration_ip ? long2ip($model->registration_ip) : null;
                    },
                    'format' => 'html',
                ],
                [
                    'header' => 'Role',
                    'value' => function ($model) {
                        switch ($model->role) {
                            case 1:
                                return "User";
                                break;
                            case 5:
                                return "<span class='glyphicon glyphicon-pawn' style='color:#008000'></span><strong> Moderator</strong>";
                                break;
                            case 6:
                                return "<span class='fa fa-frown-o' style='color:#7f807b'></span><strong> Tester</strong>";
                                break;
                            case 10:
                                if($model->id == 1){
                                    return "<span class='glyphicon glyphicon-king' style='color:#e20000'></span><strong> Super Admin</strong>";
                                }else{
                                    return "<span class='glyphicon glyphicon-queen' style='color:#b90000'></span><strong> Admin</strong>";
                                }
                                break;
                        }
                        return '';
                    },
                    'format' => 'html',
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        return date('Y-m-d, H:i:s', $model->created_at);
                    }
                ],
                [
                    'header' => 'Activation',
                    'value' => function ($model) {
                        /** @var User $model */
                        if ($model->getIsConfirmed()) {
                            return '<div class="text-center"><span class="text-success">' . 'Activated' . '</span></div>';
                        } else {
                            return Html::a(
                                'Activate',
                                ['confirm', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-xs btn-success btn-block',
                                    'data-method' => 'post',
                                    'data-confirm_message' => 'Вы уверены, что хотите активировать аккаунт пользователя?',
                                ]
                            );
                        }
                    },
                    'format' => 'raw',
                    'visible' => $userMod->enableConfirmation
                ],
                [
                    'header' => 'Blocking',
                    'value' => function ($model) {
                        /** @var User $model */
                        if ($model->getIsBlocked()) {
                            return Html::a(
                                'Unblock',
                                ['block', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-xs btn-success btn-block',
                                    'data-method' => 'post',
                                    'data-confirm_message' => 'Вы уверены, что хотите разблокировать пользователя?'
                                ]
                            );
                        } else {
                            return Html::a(
                                'Block',
                                ['block', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-xs btn-warning btn-block',
                                    'data-method' => 'post',
                                    'data-confirm_message' => 'Вы уверены, что хотите заблокировать пользователя?'
                                ]
                            );
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'header' => 'Operations',
                    'class' => 'modules\core\admin\grid\ActionColumn',
                    'template' => '{update},{delete}',
                ],
            ],
        ]
    );
    ?>

    <script>
        $(function(){
            $('.blank').each(function(){
                $(this).attr('target', '_blank');
            })
        })
    </script>




</div>
