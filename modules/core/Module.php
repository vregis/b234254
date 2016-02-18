<?php

namespace modules\core;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\GroupUrlRule;
use modules\core\models\CoreScenario;

/**
 * Модуль [[core]] - common
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Module extends \modules\core\base\Module
{
    /** @inheritdoc */
    const VERSION = '1.0.0';

    /**@var ??? */
    public $cache;
    /** @var string Название сайта */
    public $siteName;
    /** @var string Описание сайта */
    public $siteDescription;
    /** @var string Ключевые слова */
    public $siteKeywords;
    /** @var int Время жизни кеша в секундах */
    public $cacheTime = 3600;
    /** @var string E-mail администратора */
    public $adminEmail;
    /** @var int Максимальная длина сообщения в чате */
    public $chatMessageMaxLength = 512;
    /** @var int Лимит сообщений, отображаемых в чате */
    public $chatMessagesLimit = 32;

    public $inMenu = true;
    public function getTitle()
    {
        return 'Core';
    }

    public function getUrlRules()
    {
    /*    if(Yii::$app->params['id'] == 'app-site') {
            $scenario = CoreScenario::findOne(['is_active' => true]);
            return new GroupUrlRule([
                    'prefix' => 'core',
                    'rules' => [
                        '<_a:[\w\-]+>' => $scenario->controller.'/<_a>',
                    ]
                ]);
        }*/
        return new GroupUrlRule([
                'prefix' => 'core',
                'rules' => [
                    '<_a:[\w\-]+>' => 'default/<_a>',
                    '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
                ]
            ]);
    }
    /**
     * Проверяет зависимости у включенных модулей
     *
     * @return array
     */
  /*  public function checkDependencies()
    {
        $enabledMods = ArrayHelper::merge(
            require('@root/config/admin/modules.php'),
            require('@root/config/site/modules.php')
        );
        $enabledMods = array_keys($enabledMods);

        $errors = [];

        foreach ($enabledMods as $moduleName) {
            $module = Yii::$app->getModule($moduleName);
            if ($module !== null && method_exists($module, 'getDependencies')) {
                $dependencies = $module->getDependencies();
                foreach ($dependencies as $dep) {
                    if (!in_array($dep, $enabledMods)) {
                        $errors[] = Yii::t(
                            'core',
                            'Для работы модуля <b>{moduleName}</b> необходимо включить модуль <b>{dep}</b>',
                            [
                                'moduleName' => $moduleName,
                                'dep' => $dep
                            ]
                        );
                    }
                }
            }
        }
        return $errors;
    }*/
}