<?php

namespace modules\mail\models;

use modules\core\base\ActiveRecord;
use modules\core\behaviors\PurifierBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * Модель для таблицы "{{%mail_queue}}"
 *
 * @property string $id
 * @property string $created_at
 * @property string $date_send
 * @property string $sender
 * @property string $receiver
 * @property string $subject
 * @property string $body
 * @property string $viewPath
 * @property string $view
 * @property string $params
 * @property int $status
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Queue extends ActiveRecord
{
    /**
     * Статусы
     */
    const STATUS_IN_QUEUE = 0;
    const STATUS_SENT = 1;
    const STATUS_ERROR = 2;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            // TimestampBehavior
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
            // PurifierBehavior
            [
                'class' => PurifierBehavior::className(),
                'htmlAttributes' => ['body'],
                'textAttributes' => ['sender', 'receiver', 'subject', 'viewPath', 'view'],
            ],
        ];
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return 'mail_queue';
    }

    /** @inheritdoc */
    public function rules()
    {
        return [
            // sender
            [['sender'], 'required'],
            [['sender'], 'trim'],
            [['sender'], 'string', 'max' => 255],
            [['sender'], 'email'],
            // receiver
            [['receiver'], 'required'],
            [['receiver'], 'trim'],
            [['receiver'], 'string', 'max' => 255],
            [['receiver'], 'email'],
            // subject
            [['subject'], 'required'],
            [['subject'], 'trim'],
            [['subject'], 'string', 'max' => 255],
            // body
            //[['body'], 'required'],
            [['body'], 'trim'],
            [['body'], 'string'],
            // viewPath
            [['viewPath'], 'trim'],
            [['viewPath'], 'string'],
            // view
            [['view'], 'trim'],
            [['view'], 'string'],
            // params
            [
                'params',
                'filter',
                'filter' => function ($params) {
                        return empty($params) ? null : Json::encode($params);
                    }
            ],
            // status
            [['status'], 'required'],
            [['status'], 'integer'],
            [['status'], 'in', 'range' => array_keys(self::getStatusArray())],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('mail', 'ID'),
            'created_at' => Yii::t('mail', 'Дата создания'),
            'date_send' => Yii::t('mail', 'Дата отправки'),
            'sender' => Yii::t('mail', 'Отправитель'),
            'receiver' => Yii::t('mail', 'Получатель'),
            'subject' => Yii::t('mail', 'Тема'),
            'body' => Yii::t('mail', 'Содержимое'),
            'viewPath' => Yii::t('mail', 'Путь к шаблону'),
            'view' => Yii::t('mail', 'Шаблон'),
            'params' => Yii::t('mail', 'Параметры для шаблона'),
            'status' => Yii::t('mail', 'Статус'),
        ];
    }

    /**
     * Статусы
     *
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_IN_QUEUE => Yii::t('user', 'В очереди'),
            self::STATUS_SENT => Yii::t('user', 'Отправлено'),
            self::STATUS_ERROR => Yii::t('user', 'Ошибка'),
        ];
    }

    /**
     * Возвращает модели писем из БД для отправки по крону
     *
     * @param int $limit
     * @return array|Queue
     */
    public static function cronGetLetters($limit = 10)
    {
        return self::find()
            ->where('status!=:status', [':status' => self::STATUS_SENT])
            ->orderBy(['id' => SORT_ASC])
            ->limit($limit)
            ->all();
    }

    /**
     * Установка необходимых значений в NULL (временное решение)
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        // если есть содержимое сообщения, убираем путь к шаблону
        if (!empty($this->body)) {
            $this->viewPath = $this->view = null;
        }

        // если есть шаблон, убираем содержимое
        if (!empty($this->view)) {
            $this->body = null;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Возвращает количество писем в очереди
     *
     * @return int
     */
    public static function getMailsInQueue()
    {
        return self::find()
            ->where(['status' => self::STATUS_IN_QUEUE])
            ->orWhere(['status' => self::STATUS_ERROR])
            ->count();
    }
}