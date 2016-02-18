<?php

namespace modules\core\behaviors;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Inflector;

/**
 * Обертка для yii\behaviors\SluggableBehavior
 *
 * Меняем параметры по умолчанию
 * Применяем Inflector::slug() только если поле с алиасом пустое
 *
 * @author MrArthur
 * @since 1.0.0
 */
class TransliterateBehavior extends SluggableBehavior
{
    /** @inheritdoc */
    public $slugAttribute = 'alias';
    /** @inheritdoc */
    public $attribute = 'title_ru';

    /** @inheritdoc */
    protected function getValue($event)
    {
        Inflector::$transliterator = 'Russian-Latin/BGN; NFKD';

        if ($this->attribute !== null) {
            if (empty($this->owner->{$this->slugAttribute})) {
                $this->value = Inflector::slug($this->owner->{$this->attribute});
            } else {
                $this->value = Inflector::slug($this->owner->{$this->slugAttribute});
            }
        }
        return $this->value;
    }
}