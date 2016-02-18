<?php

namespace modules\user\helpers;

use Yii;

/**
 * Вспомогательные методы для работы с паролями
 *
 * @author MrArthur
 * @since 1.0.0
 */
class PasswordHelper
{
    /**
     * Обертка для Yii::$app->security->generatePasswordHash
     *
     * @param $password
     * @return string
     */
    public static function hash($password)
    {
        /** @var \common\modules\user\Module $userMod */
        $userMod = Yii::$app->getModule('user');
        return Yii::$app->security->generatePasswordHash($password, $userMod->cost);
    }

    /**
     * Обертка для Yii::$app->security->validatePassword
     *
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function validate($password, $hash)
    {
        return Yii::$app->security->validatePassword($password, $hash);
    }

    /**
     * Генерирует пароль
     *
     * Пароль содержит хотя бы одну букву в нижнем регистре, одну букву в верхнем регистре и одну цифру.
     *
     * @see https://gist.github.com/tylerhall/521810     *
     * @param $length
     * @return string
     */
    public static function generate($length)
    {
        $sets = [
            'abcdefghjkmnpqrstuvwxyz',
            'ABCDEFGHJKMNPQRSTUVWXYZ',
            '23456789'
        ];
        $all = $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }

        $password = str_shuffle($password);

        return $password;
    }
}