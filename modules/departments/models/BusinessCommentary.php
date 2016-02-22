<?php

namespace modules\departments\models;

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
class BusinessCommentary extends ActiveRecord
{

    public $fn;
    public $ln;
    public $ava;
    public $uid;

    /** @inheritdoc */
    public static function tableName()
    {
        return 'business_commentary';
    }


    /**
     * @return \yii\db\ActiveQuery
     */

}