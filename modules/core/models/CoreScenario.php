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
class CoreScenario extends ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 255],
            ['controller', 'string', 'max' => 120],

            [['name','controller','is_active'], 'required'],
        ];
    }
    /** @inheritdoc */
    public static function tableName()
    {
        return 'core_scenario';
    }
}