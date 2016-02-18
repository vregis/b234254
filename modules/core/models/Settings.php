<?php

namespace modules\core\models;

use modules\core\base\ActiveRecord;
use modules\core\behaviors\PurifierBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Модель для таблицы "{{%core_settings}}"
 *
 * @property string $id
 * @property string $module_id
 * @property string $param_name
 * @property string $param_value
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Settings extends ActiveRecord
{
    use ModuleTrait;

    /** @var string Модуль */
    protected static $moduleName = 'core';
    /** @var array Массив с правилами валидации для определенного параметра модуля */
    public $rulesFromModule = [];

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // PurifierBehavior
            'purifierBehavior' => [
                'class' => PurifierBehavior::className(),
                'htmlAttributes' => ['module_id', 'param_name', 'param_value'],
            ],
        ];
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return 'core_settings';
    }

    /** @inheritdoc */
    public function rules()
    {
        // объединяем общие правила с правилами для конкретного параметра из настроек модуля
        return ArrayHelper::merge(
            [
                // module_id
                [['module_id'], 'required'],
                [['module_id'], 'trim'],
                [['module_id'], 'string', 'max' => 255],
                // param_name
                [['param_name'], 'required'],
                [['param_name'], 'trim'],
                [['param_name'], 'string', 'max' => 255],
                // param_value
                [['param_value'], 'trim'],
                [['param_value'], 'string', 'max' => 255],
            ],
            $this->rulesFromModule
        );
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('core', 'ID'),
            'module_id' => Yii::t('core', 'ID модуля'),
            'param_name' => Yii::t('core', 'Параметр'),
            'param_value' => Yii::t('core', 'Значение'),
        ];
    }

    /**
     * Получает настройки модуля из базы данных
     *
     * @param $modId
     * @param array $params
     * @return array
     */
    public function getModuleSettings($modId, array $params = null)
    {
        $settings = [];

        if ($modId) {

            $query = self::find()->where(['module_id' => $modId]);

            // если нужно выбрать только нонкретные параметры, добавляем IN (...)
            if (!empty($params)) {
                $query->andWhere(['param_name' => $params]);
            }

            $models = $query->all();

            if (count($models)) {
                /** @var Settings $setting */
                foreach ($models as $setting) {
                    $settings[$setting->param_name] = $setting;
                }
            } elseif (count($params)) {
                foreach ($params as $param) {
                    $settings[$param] = null;
                }
            }
        }

        return $settings;
    }

    // Веренет значение параметра
    public static function getCoreSettingsByOption($param = null){
        //vd(1);
        $model = self::find()->where(['module_id' => 'core','param_name'=>$param])->one();
        if($model){
            return $model->param_value;
        }else{
            return false;
        }
    }
}