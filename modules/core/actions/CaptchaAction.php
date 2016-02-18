<?php

namespace modules\core\actions;

use yii\captcha\CaptchaAction as YiiCaptchaAction;

/**
 * Класс CaptchaAction
 *
 * Обертка для yii\captcha\CaptchaAction
 *
 * @author MrArthur
 * @since 1.0.0
 */
class CaptchaAction extends YiiCaptchaAction
{
    /** @inheritdoc */
    public $backColor = 0xEEEEEE;
    /** @inheritdoc */
    public $foreColor = 0x444444;
    /**
     * @var bool Использовать в коде только цифры
     */
    public $onlyNumbers = false;

    /** @inheritdoc */
    public function init()
    {
        if (!$this->fixedVerifyCode) {
            $this->fixedVerifyCode = YII_ENV_TEST ? 'testme' : null;
        }

        parent::init();
    }

    /** @inheritdoc */
    protected function generateVerifyCode()
    {
        if ($this->minLength > $this->maxLength) {
            $this->maxLength = $this->minLength;
        }
        if ($this->minLength < 3) {
            $this->minLength = 3;
        }
        if ($this->maxLength > 20) {
            $this->maxLength = 20;
        }
        $length = mt_rand($this->minLength, $this->maxLength);

        if ($this->onlyNumbers) {
            $letters = '1234567890';
            $code = '';
            for ($i = 0; $i < $length; ++$i) {
                $code .= $letters[rand(0, strlen($letters) - 1)];
            }
        } else {
            $letters = 'bcdfghjklmnpqrstvwxyz';
            $vowels = 'aeiou';
            $code = '';
            for ($i = 0; $i < $length; ++$i) {
                if ($i % 2 && mt_rand(0, 10) > 2 || !($i % 2) && mt_rand(0, 10) > 9) {
                    $code .= $vowels[mt_rand(0, 4)];
                } else {
                    $code .= $letters[mt_rand(0, 20)];
                }
            }
        }
        return $code;
    }
}