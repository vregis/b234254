<?php

namespace modules\core\site\widgets;

use yii\base\Widget;

/**
 * Class Chat
 *
 * @author MrArthur
 * @since 1.0.0
 */
class IndexChat extends Widget
{
    /** @inheritdoc */
    public function run()
    {
        return $this->render('@frontend_theme/core/widgets/chat');
    }
}