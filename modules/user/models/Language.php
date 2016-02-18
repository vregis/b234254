<?php

namespace modules\user\models;

use Yii;
use modules\core\base\ActiveRecord as ActiveRecord;

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
class Language extends ActiveRecord
{


    /** @inheritdoc */
    public static function tableName()
    {
        return 'user_language';
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // title_ru
            [['user_id'], 'integer'],
            [['language'], 'string'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

}