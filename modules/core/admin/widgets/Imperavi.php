<?php

namespace modules\core\admin\widgets;

use modules\core\base\ActiveRecord;
use Yii;
use yii\imperavi\Widget as ImperaviWidget;

/**
 * Обертка для редактора Imperavi
 *
 * Заменяем тут дефолтные настройки, что бы не прописывать каждый раз
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Imperavi extends ImperaviWidget
{
    /** @var string Текст лейбла для textarea */
    public $label;
    /** @var ActiveRecord */
    public $model = null;

    /** @inheritdoc */
    public function init()
    {
        parent::init();

        /**
         * Устанавливаем дефолтные настройки для всей админки
         *
         * @see http://imperavi.com/redactor/docs/settings/
         */
        $this->options = [
            'minHeight' => 150,
            'buttonSource' => true,
            //'pastePlainText' => true,
        ];
    }
}