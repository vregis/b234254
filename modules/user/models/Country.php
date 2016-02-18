<?php

namespace modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
use modules\core\base\ActiveRecord as ActiveRecord;
use modules\core\behaviors\PurifierBehavior;
use modules\core\helpers\DateHelper;
use modules\user\site\helpers\SocialHelper;

/**
 * Модель для таблицы "{{%geo_country}}"
 *
 * @property int $id
 * @property string $title_ru
 * @property string $title_en
 *
 * @property City[] $cities
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Country extends ActiveRecord
{
    use ModuleTrait;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // PurifierBehavior
            'purifierBehavior' => [
                'class' => PurifierBehavior::className(),
                'textAttributes' => ['title_ru', 'title_en'],
            ],
        ];
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return 'geo_country';
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // title_ru
            [['title_ru'], 'required'],
            [['title_ru'], 'trim'],
            [['title_ru'], 'string', 'max' => 64],
            // title_en
            [['title_en'], 'trim'],
            [['title_en'], 'string', 'max' => 64],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('geo', 'ID'),
            'title' => Yii::t('geo', 'Название'),
            'title_ru' => Yii::t('geo', 'Название (RU)'),
            'title_en' => Yii::t('geo', 'Название (EN)'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['country_id' => 'id']);
    }

    /**
     * Массив стран для dropDownList (id=>title)
     *
     * @return array
     */
    public static function getCountryArray()
    {
        $title_lang = 'title_' . Yii::$app->language;
        $countries = self::find()
            ->select('id, ' . $title_lang)
            ->orderBy($title_lang)
            ->asArray()
            ->all();
        return (array)ArrayHelper::map($countries, 'id', $title_lang);
    }

    /**
     * Массив стран для dropDownList (id=>title) Только СНГ
     *
     * @return array
     */
    public static function getCountryArrayOnlyRU()
    {
        $title_lang = 'title_' . Yii::$app->language;
        $countries = self::find()
            ->select('id, ' . $title_lang)
            ->where(['id' => ['20','16','112','113','126','135','138','140','144','152','153','210']])
            ->orderBy($title_lang)
            ->asArray()
            ->all();
        return (array)ArrayHelper::map($countries, 'id', $title_lang);
    }
    
    /**
     *
     * @return string
     */
    public static function getNameById($id)
    {
        $model= self::find()->where(['id'=>$id])->one();
        if($model){
            return $model->title_ru;
        }else{
            return false;
        }
        
    }
}