<?php

namespace modules\mail;

use modules\core\base\Module as CommonModule;
use modules\mail\models\Queue;
use Yii;

/**
 * Модуль [[mail]] - common
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Module extends CommonModule
{
    /** @inheritdoc */
    const VERSION = '1.0.0';

    /** @inheritdoc */
    public function getDependencies()
    {
        return ['core', 'user'];
    }

    /**
     * Добавляет письмо в таблицу очереди на отправку писем в БД
     *
     * @param string $sender E-mail отправителя
     * @param string $receiver E-mail получателя
     * @param string $subject Тема письма
     * @param string $body Текстовое содержимое письма
     * @param string $view Название файла вьюшки с контентом письма (activationEmail)
     * @param string $viewPath Путь к директории с вьюшкой (@common/emails)
     * @param array $params Массив с параметрами для вьюшки
     * @return bool
     */
    public function toQueue($sender, $receiver, $subject, $body = null, $view = null, $params = null, $viewPath = null)
    {
        $sender = empty($sender) ? Yii::$app->params['robotEmail'] : $sender;

        // добавляем письмо в очередь
        $model = new Queue();
        $model->sender = $sender;
        $model->receiver = $receiver;
        $model->subject = $subject;
        $model->body = $body;
        $model->viewPath = $viewPath;
        $model->view = $view;
        $model->params = $params;

        return $model->save();
    }
    
    public $inMenu = true;

    /** @inheritdoc */
    public function getCategory()
    {
        return Yii::t('mail', 'Пользователи');
    }

    /** @inheritdoc */
    public function getTitle()
    {
        return Yii::t('mail', 'Почта');
    }

    /** @inheritdoc */
    public function getIcon()
    {
        return 'envelope';
    }
}