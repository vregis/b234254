<?php

namespace modules\core\admin\base;

use modules\core\base\Controller as CommonController;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Класс Controller
 *
 * Базовый контроллер для всех контроллеров бэкенда
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Controller extends CommonController
{
    public $layout = "@modules/core/admin/views/layouts/main";
    /** @inheritdoc */
    public function init()
    {
     /*   if (!$this->getIsAdmin()) {
            //Yii::$app->user->logout();
            $this->layout = '@root/modules/core/admin/views/layouts/login.php';
        }*/
        parent::init();
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // Разрешаем доступ только админам
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }
}