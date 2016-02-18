<?php

namespace modules\core\admin\base;

use modules\core\base\View as CommonView;
use Yii;
use yii\helpers\Html;

/**
 * Класс View
 *
 * Базовый класс View для всех вьюшек бэкенда
 *
 * @author MrArthur
 * @since 1.0.0
 */
class View extends CommonView
{
    /**
     * Подсказка для поля с алиасом
     *
     * @return string
     */
    public function getAliasPlaceholder()
    {
        return Yii::t('core', 'Оставьте поле пустым, чтобы автоматически сгенерировать из названия');
    }

    /**
     * Название с иконкой для верхнего меню админки
     *
     * @param $icon string Название класса бутстрап иконки после "glyphicon-"
     * @param $label string Лейбл просто текстом
     * @return string
     */
    public function iconLabel($icon, $label)
    {
        return '<i class="glyphicon glyphicon-' . $icon . '"></i> ' . $this->encode($label);
    }

    /**
     * Блок с кнопкой отправки формы для бэкенда
     *
     * @param $content
     * @param array $options
     * @return string
     */
    public function submitBlock($content = null, $options = [])
    {
        $content = empty($content) ? 'Сохранить изменения' : $this->encode($content);
        $options['class'] = empty($options['class']) ? 'btn btn-lg btn-primary' : $options['class'];

        $html = Html::beginTag('div', ['class' => 'panel panel-footer']);
        $html .= Html::submitButton($content, $options);
        $html .= Html::endTag('div');
        return $html;
    }

    /**
     * Элемент radio и label - в одной строке
     *
     * @param $index
     * @param $label
     * @param $name
     * @param $checked
     * @param $value
     * @param null $class
     * @return string
     */
    public function inlineLabel($index, $label, $name, $checked, $value, $class = null)
    {
        unset($index);
        $class = $class === null ? 'radio-inline' : $class;
        return '<label class="' . $class . '">' . Html::radio(
            $name,
            $checked,
            ['value' => $value]
        ) . $label . '</label>';
    }
}