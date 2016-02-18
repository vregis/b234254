<?php

namespace modules\core\widgets;

use Yii;
use yii\base\Widget as YiiWidget;

/**
 * Виджет для вывода Flash сообщений (Yii::$app->request->setFlash())
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Flash extends YiiWidget
{
    /** @var array Настройки виджета */
    public $options = [];
    /** @var string Вьюшка виджета */
    public $view = '@modules/core/widgets/views/default';

    /** @inheritdoc */
    public function run()
    {
        echo $this->render($this->view, ['options' => $this->options]);
    }
}