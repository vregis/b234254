<?php

namespace modules\core\behaviors;

use modules\core\base\ActiveRecord;
use Yii;
use yii\base\Behavior;
use yii\helpers\HtmlPurifier;

/**
 * Class PurifierBehavior
 *
 * Данное поведение очищает от небезопастного кода указаные в настройках атрибуты
 *
 * Пример использования:
 *
 * ```php
 * use common\modules\core\behaviors\PurifierBehavior;
 * [
 *     'class' => PurifierBehavior::className(),
 *     'htmlAttributes' => ['content', 'about'],
 *     'textAttributes' => ['title', 'alias']
 * ]
 * ```
 *
 * @property array $htmlAttributes массив атрибутов, которые необходимо очистить полностью (удалить весь html)
 * @property array $textAttributes массив атрибутов, которые необходимо очистить от небезопасных элементов
 *
 * @author MrArthur
 * @since 1.0.0
 */
class PurifierBehavior extends Behavior
{
    /** @var array Массив атрибутов, которые необходимо очистить полностью (удалить весь html) */
    public $htmlAttributes = [];
    /** @var array Массив атрибутов, которые необходимо очистить от небезопасных элементов */
    public $textAttributes = [];

    /**
     * Конфиг HtmlPurifier для очистки только от небезопасных элементов
     *
     * @return array Настройки для htmlAttributes
     */
    public static function purifierOptionsHtml()
    {
        return [
            'AutoFormat.RemoveEmpty' => true,
            'AutoFormat.RemoveEmpty.RemoveNbsp' => true,
            'AutoFormat.Linkify' => true,
            'HTML.Nofollow' => true,
            //'HTML.AllowedElements' => 'p,span,strong,ul,ol,li,em,u,strike,br,hr,img,a',
        ];
    }

    /**
     * Конфиг HtmlPurifier для полной очистки
     *
     * @return array Настройки для textAttributes
     */
    public static function purifierOptionsText()
    {
        return [
            'HTML.AllowedElements' => '', // запрещает использование HTML
            'AutoFormat.RemoveEmpty' => true,
            'AutoFormat.RemoveEmpty.RemoveNbsp' => true,
        ];
    }

    /** @inheritdoc */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'applyFilter',
        ];
    }

    /**
     * Выполняет очистку всех указанных аттрибутов
     */
    public function applyFilter()
    {
        $this->purifyHtml();
        $this->purifyText();
    }

    /**
     * Очищает атрибуты от небезопасных элементов
     */
    public function purifyHtml()
    {
        if (!empty($this->htmlAttributes)) {

            $purifier = new HtmlPurifier;
            $options = $this->purifierOptionsHtml();

            foreach ($this->htmlAttributes as $attribute) {

                $this->owner->$attribute = $purifier->process($this->owner->$attribute, $options);

                // null
                if (empty($this->owner->{$attribute})) {
                    $this->owner->{$attribute} = null;
                }
            }
        }
    }

    /**
     * Полностью очищает атрибуты, включая HTML код
     */
    public function purifyText()
    {
        if (!empty($this->textAttributes)) {

            $purifier = new HtmlPurifier;
            $options = $this->purifierOptionsText();

            foreach ($this->textAttributes as $attribute) {

                $this->owner->{$attribute} = $purifier->process($this->owner->$attribute, $options);

                // null
                if (empty($this->owner->{$attribute})) {
                    $this->owner->{$attribute} = null;
                }
            }
        }
    }
}