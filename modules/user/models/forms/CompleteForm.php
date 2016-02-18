<?php

namespace modules\user\models\forms;

use modules\core\helpers\DateHelper;
use modules\user\models\ModuleTrait;
use modules\user\models\User;
use Yii;
use yii\base\Model;

/**
 * Класс модели для формы завершения регистрации
 *
 * @author MrArthur
 * @since 1.0.0
 */
class CompleteForm extends Model
{
    use ModuleTrait;

    /** @var string Дата рождения */
    public $birth_date;
    /** @var int День рождения */
    public $birth_day;
    /** @var int Месяц рождения */
    public $birth_month;
    /** @var int Год рождения */
    public $birth_year;
    /** @var int ID страны */
    public $country_id;
    /** @var string Название страны */
    public $country_title;
    /** @var int ID города */
    public $city_id;
    /** @var string Название города */
    public $city_title;
    /** @var string E-mail */
    public $email;
    /** @var bool Согласен с условиями */
    public $agree;
    /** @var bool Мне есть 18 лет */
    public $im18years;

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'birth_date' => Yii::t('user', 'Дата рождения'),
            'birth_day' => Yii::t('user', 'День'),
            'birth_month' => Yii::t('user', 'Месяц'),
            'birth_year' => Yii::t('user', 'Год'),
            'city_id' => Yii::t('user', 'Город'),
            'city_title' => Yii::t('user', 'Город'),
            'country_id' => Yii::t('user', 'Страна'),
            'country_title' => Yii::t('user', 'Страна'),
            'email' => Yii::t('user', 'E-mail'),
        ];
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // birth_date
            [['birth_date'], 'required'],
            [['birth_date'], 'date', 'format' => 'Y-m-d'],
            // birth_day
            [['birth_day'], 'required'],
            [['birth_day'], 'integer'],
            [['birth_day'], 'in', 'range' => DateHelper::getDayArray()],
            // birth_month
            [['birth_month'], 'required'],
            [['birth_month'], 'integer'],
            [['birth_month'], 'in', 'range' => array_keys(DateHelper::getMonthArray())],
            // birth_year
            [['birth_year'], 'required'],
            [['birth_year'], 'integer'],
            [['birth_year'], 'in', 'range' => DateHelper::getYearArray()],
            // city_id
            [['city_id'], 'required'],
            [['city_id'], 'integer'],
            [['city_id'], 'exist', 'targetClass' => City::className(), 'targetAttribute' => 'id'],
            // city_title
            [['city_title'], 'trim'],
            [['city_title'], 'string', 'max' => 64],
            // country_id
            [['country_id'], 'required'],
            [['country_id'], 'integer'],
            [['country_id'], 'exist', 'targetClass' => Country::className(), 'targetAttribute' => 'id'],
            // country_title
            [['country_title'], 'trim'],
            [['country_title'], 'string', 'max' => 64],
            // email
            ['email', 'required', 'on' => ['steam']],
            ['email', 'trim'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            // agree
            ['agree', 'required'],
            ['agree', 'boolean'],
            // im18years
            ['im18years', 'required'],
            ['im18years', 'boolean'],
        ];
    }

    /** @inheritdoc */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->birth_month = preg_replace('/[^0-9.]+/', '', $this->birth_month);
            $this->birth_day = preg_replace('/[^0-9.]+/', '', $this->birth_day);
            $this->birth_date = (int)$this->birth_year . '-' . $this->birth_month . '-' . $this->birth_day;
            return true;
        } else {
            return false;
        }
    }

    /** @inheritdoc */
    public function afterValidate()
    {
        // добавляем название страны
        if (!empty($this->country_id)) {
            $countryModel = Country::findOne($this->country_id);
            if ($countryModel !== null) {
                $this->country_title = $countryModel->title;
            }
        } else {
            $this->country_id = $this->country_title = null;
        }

        // добавляем название города
        if (!empty($this->city_id)) {
            $cityModel = City::findOne($this->city_id);
            if ($cityModel !== null) {
                $this->city_title = $cityModel->title;
            }
        } else {
            $this->city_id = $this->city_title = null;
        }

        parent::afterValidate();
    }
}