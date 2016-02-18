<?php

namespace modules\user\rbac;

use modules\user\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\rbac\Rule;

/**
 * Class UserRoleRule
 *
 * @author MrArthur
 * @since 1.0.0
 */
class UserRoleRule extends Rule
{
    /** @inheritdoc */
    public $name = 'userRole';

    /** @inheritdoc */
    public function execute($user, $item, $params)
    {
        // получаем массив пользователя из базы
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {
            $role = $user->role; // значение из поля role базы данных
            if ($item->name === 'admin') {
                return $role == User::ROLE_ADMIN;
            } elseif ($item->name === 'tester') {
                return $role == User::ROLE_ADMIN || $role == User::ROLE_TESTER;
            } elseif ($item->name === 'moder') {
                // moder является потомком admin, который получает его права
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODERATOR;
            } elseif ($item->name === 'user') {
                return $role == User::ROLE_ADMIN || $role == User::ROLE_MODERATOR || $role == User::ROLE_USER;
            }
        }
        return false;
    }
}