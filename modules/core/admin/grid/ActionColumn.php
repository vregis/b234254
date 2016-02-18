<?php

namespace modules\core\admin\grid;

use Yii;
use yii\grid\ActionColumn as CoreActionColumn;
use yii\helpers\Html;

/**
 * Колонка с кнопками в виджете GridView
 * Обертка для \yii\grid\ActionColumn
 *
 * @author MrArthur
 * @since 1.0.0
 */
class ActionColumn extends CoreActionColumn
{
    /** @inheritdoc */
    public function init()
    {
        parent::init();

        // кнопки в одну строку
        $this->template = '<span style="white-space:nowrap;">' . $this->template . '</span>';
        // ширина колонки
        $this->options = ['style' => 'width:100px;'];
        // кастомные кнопки
        $this->buttons = [
            'view' => function ($url) {
                    return Html::a(
                        '<i class="glyphicon glyphicon-eye-open"></i>',
                        $url,
                        [
                            'class' => 'btn btn-xs btn-warning',
                            'title' => 'Look',
                        ]
                    );
                },
            'update' => function ($url) {
                    return Html::a(
                        '<i class="glyphicon glyphicon-wrench"></i>',
                        $url,
                        [
                            'class' => 'btn btn-xs btn-info',
                            'title' => 'Edit',
                        ]
                    );
                },
            'delete' => function ($url) {
                    return Html::a(
                        '<i class="glyphicon glyphicon-trash"></i>',
                        $url,
                        [
                            'title' => 'Delete',
                            'data-confirm' => Yii::t('core', 'Вы уверены, что хотите удалить этот элемент?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'class' => 'btn btn-xs btn-danger',
                        ]
                    );
                },
        ];
    }
}