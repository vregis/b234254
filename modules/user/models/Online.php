<?php

namespace modules\user\models;

use modules\core\base\ActiveRecord;
use Yii;

/**
 * Модель для таблицы "{{%user_online}}"
 *
 * @property string $id
 * @property string $user_id
 * @property string $last_visit
 *
 * @property User $user
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Online extends ActiveRecord
{
    use ModuleTrait;

    /** @inheritdoc */
    public static function tableName()
    {
        return 'user_online';
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // user_id
            [['user_id'], 'integer'],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            // last_visit
            [['last_visit'], 'integer'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'user_id' => Yii::t('user', 'ID пользователя'),
            'last_visit' => Yii::t('user', 'Последний визит'),
        ];
    }

    /** @return \yii\db\ActiveQuery */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Устанавливает статус пользователя "онлайн"
     *
     * Время последнего обновления сохраняется в сессию
     * Запрос выполняется только если нет значения в сессии,
     * либо с момента записи сессии прошло больше 60 секунд
     *
     * @return bool
     */
    public static function setOnline()
    {
        // только для пользователей
        if (Yii::$app->user->isGuest) {
            return true;
        }

        // получаем из сессии время последнего обновления статуса "онлайн"
        $lastUpdate = Yii::$app->session->get('last_online_update');

        // если нет значения в сессии или еще не прошло N секунд с момента последнего обновления
        if (empty($lastUpdate) || ($lastUpdate + 120) < time()) {
            // обновляем значение в БД
            /** @var Online $online */
            $online = self::find()
                ->where('user_id=:user_id')
                ->addParams([':user_id' => Yii::$app->user->id])
                ->one();

            // если пользователя нет в таблице онлайна, добавляем
            if ($online === null) {
                $online = new Online();
                $online->user_id = Yii::$app->user->id;
            }

            $online->last_visit = time();

            if ($online->save()) {
                // устанавливаем время последнего обновления статуса "онлайн" сессии в текущее время
                Yii::$app->session->set('last_online_update', time());
            }
        }
        return true;
    }

    /**
     * Удаляет устаревшие записи из таблицы "{{%user_online}}"
     *
     * @return mixed
     */
    public static function cronRemoveOld()
    {
        // Время в секундах, по истечении которого записи устаревают и удаляются
        $expireTime = 60 * 30; // 30 минут
        $sql = "DELETE FROM {{%user_online}} WHERE last_visit < (UNIX_TIMESTAMP() - :expireTime)";
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(':expireTime', $expireTime, \PDO::PARAM_INT);
        return $command->execute();
    }

    /**
     * Возвращает true - online или false - offline
     *
     * @param $id
     * @return bool
     */
    public static function getStatus($id)
    {
        /** @var Online $online */
        $online = self::find()
            ->where('user_id=:user_id')
            ->addParams([':user_id' => $id])
            ->one();

        if ($online === null) {
            return false;
        }

        $difference = (int)(time() - $online->last_visit);
        if (empty($difference)) {
            return false;
        }

        /** @var \common\modules\user\Module $userMod */
        $userMod = Yii::$app->getModule('user');

        return $difference <= (int)$userMod->onlineTime ? true : false;
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getOne($id)
    {
        return self::find()
            ->where('user_id=:user_id')
            ->addParams([':user_id' => $id])
            ->one();
    }

    /**
     * Возвращает количество пользователей онлайн
     *
     * @return int
     */
    public static function getTotalOnline()
    {
        return self::find()->count();
    }

    /**
     * Возвращает общее количество пользователей
     *
     * @return int
     */
    public static function getTotalUsers()
    {
        return User::find()->count();
    }
}