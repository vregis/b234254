<?php

namespace modules\core\base;

use Yii;
use yii\db\ActiveRecord as YiiActiveRecord;

/**
 * Базовый класс ActiveRecord для бэкенда и фронтенда
 *
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $description
 * @property string $description_ru
 * @property string $description_en
 * @property string $content
 * @property string $content_ru
 * @property string $content_en
 * @property string $statusArray
 * @property string $boolArray
 * @property string $boolTitle
 * @property int $status
 *
 * @property \common\modules\core\base\ActiveRecord $owner
 *
 * @author MrArthur
 * @since 1.0.0
 */
class ActiveRecord extends YiiActiveRecord
{
    /** Статусы */
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        // дефолтные значения из БД
        $this->loadDefaultValues();
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        // установка незаполненных полей в null
        foreach ($this->getTableSchema()->columns as $column) {
            if ($column->allowNull && empty($this->{$column->name})) {
                $this->{$column->name} = $column->defaultValue;
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * Получение $model->title в зависимости от текущего языка
     *
     * @return string
     */
    public function getTitle()
    {
        if ($this->hasAttribute('title_ru') || $this->hasAttribute('title_en')) {
            $data = Yii::$app->language == 'en' ? $this->title_en : $this->title_ru;
            return empty($data) ? $this->title_ru : $data;
        }
        return $this->title;
    }

    /**
     * Получение $model->description в зависимости от текущего языка
     *
     * @return string
     */
    public function getDescription()
    {
        if ($this->hasAttribute('description_en') || $this->hasAttribute('description_ru')) {
            $data = Yii::$app->language == 'en' ? $this->description_en : $this->description_ru;
            return empty($data) ? $this->description_ru : $data;
        }
        return $this->description;
    }

    /**
     * Получение $model->content в зависимости от текущего языка
     *
     * @return string
     */
    public function getContent()
    {
        if ($this->hasAttribute('content_en') || $this->hasAttribute('content_ru')) {
            $data = Yii::$app->language == 'en' ? $this->content_en : $this->content_ru;
            return empty($data) ? $this->content_ru : $data;
        }
        return $this->content;
    }

    /**
     * Массив со статусами по умолчанию
     *
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('core', 'Опубликовано'),
            self::STATUS_INACTIVE => Yii::t('core', 'Не опубликовано')
        ];
    }
}