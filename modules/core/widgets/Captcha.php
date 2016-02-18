<?php

namespace modules\core\widgets;

use yii\captcha\Captcha as YiiCaptcha;

/**
 * Обертка для yii\captcha\Captcha
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Captcha extends YiiCaptcha
{
    /** @inheritdoc */
    public $template = '{image}';
    /** @inheritdoc */
    public $captchaAction = '/core/default/captcha';
    /** @var int Ширина по умолчанию */
    public $defaultWidth = 120;
    /** @var int Высота по умолчанию */
    public $defaultHeight = 40;

    /** @inheritdoc */
    public function init()
    {
        // переопределяем дефолтные настройки
        $o = $this->imageOptions;
        $this->imageOptions['width'] = isset($o['width']) ? $o['width'] : $this->defaultWidth;
        $this->imageOptions['height'] = isset($o['height']) ? $o['height'] : $this->defaultHeight;
        $this->imageOptions['class'] = isset($o['class']) ? $o['class'] . ' captcha_image' : ' captcha_image';

        parent::init();
    }
}