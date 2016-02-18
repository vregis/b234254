<?php

namespace modules\user\models;

use modules\core\base\ActiveRecord as ActiveRecord;
use RuntimeException;
use Yii;
use yii\db\Query;
use yii\helpers\Url;

/**
 * Модель для таблицы "{{%user_token}}"
 *
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property int $created_at
 * @property int $type
 *
 * @property User $user
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Token extends ActiveRecord
{
    use ModuleTrait;

    /** Типы токенов */
    const TYPE_CONFIRMATION = 0;
    const TYPE_RECOVERY = 1;

    /** @inheritdoc */
    public static function tableName()
    {
        return 'user_token';
    }

    /** @return \yii\db\ActiveQuery */
    public function getUser()
    {
        return $this->hasOne($this->module->manager->userClass, ['id' => 'user_id']);
    }

    /**
     * Генерирует ссылку с токеном, в зависимости от типа
     *
     * @return string
     * @throws RuntimeException
     */
    public function getUrl()
    {
        switch ($this->type) {
            case self::TYPE_CONFIRMATION:
                $route = '/user/registration/confirm';
                break;
            case self::TYPE_RECOVERY:
                $route = '/user/recovery/reset';
                break;
            default:
                throw new RuntimeException;
        }
        return Url::to([$route, 'id' => $this->user_id, 'code' => $this->code], true);
    }

    /**
     * Проверяет, не прошло ли еще время действия токена
     *
     * @return bool
     * @throws RuntimeException
     */
    public function getIsExpired()
    {
        switch ($this->type) {
            case self::TYPE_CONFIRMATION:
                $expirationTime = $this->module->confirmWithin;
                break;
            case self::TYPE_RECOVERY:
                $expirationTime = $this->module->recoverWithin;
                break;
            default:
                throw new RuntimeException;
        }
        return ($this->created_at + $expirationTime) < time();
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
            $this->code = Yii::$app->security->generateRandomString();
        }
        return parent::beforeSave($insert);
    }

    /**
     * Удаляет устаревшие токены из таблицы "{{%user_token}}"
     *
     * @return int
     */
    public static function removeExpired()
    {
        $query = (new Query())->from('user_token')->orderBy('id');
        $deleted = 0;
        /** @var Token $token */
        foreach ($query->each() as $token) {
            if ($token->getIsExpired()) {
                if ($token->delete() !== false) {
                    $deleted++;
                }
            }
        }
        return $deleted;
    }
}