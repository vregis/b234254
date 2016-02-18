<?php

namespace modules\core\site\widgets;

use modules\core\site\components\LangHelper;
use yii\base\Widget;

/**
 * Виджет переключения языка на сайте
 *
 * @author MrArthur
 * @since 1.0.0
 */
class LangSwitcher extends Widget
{
    /**
     * @var string Вьюшка
     */
    public $view = '@frontend_theme/core/widgets/langSwitcher';

    /** @inheritdoc */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'current' => LangHelper::getCurrent(),
                'langs' => LangHelper::getAvailable(),
            ]
        );
    }
}