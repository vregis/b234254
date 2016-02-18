<?php

namespace modules\core\base;

use Yii;
use yii\base\Module as YiiModule;
use yii\web\GroupUrlRule;

/**
 * Базовый модуль для всех модулей фронтенда и бэкенда
 *
 * Наследование: FrontendModuleName -> CommonModuleName -> CommonModuleBase -> YiiModule
 *
 * @property string $version
 * @property string $dependencies
 * @property string $category
 * @property string $title
 * @property string $icon
 * @property string $navigation
 * @property string $paramsLabels
 * @property string $editableParams
 * @property string $editableParamsGroups
 * @property string $editableParamsKey
 * @property string $rulesForParam
 *
 * @property array $rating
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Module extends YiiModule
{
    /** @var int порядок следования модуля в меню панели управления (сортировка) */
    public $menuOrder = 0;
    /** @var int Время хранения кеша по умолчанию */
    public $coreCacheTime = 3600;

    /**
     * @var array Настройки рейтинга
     *
     * Структура:
     * [
     *      model_name => [
     *          param_name => param_value
     *      ]
     * ]
     *
     * Параметры:
     * @param $type int Тип рейтинга
     * @param $logTable string Таблица логов
     * @param $jsCounters bool JS обновление количества лайков/дислайков после голосования
     * @param $jsSummary bool JS обновление суммарного рейтинга после голосования
     * @param $allowRevote bool Разрешить менять голос
     */
    public $rating = [];

    /** @inheritdoc */
    public function init()
    {
        parent::init();

    }

    /**
     * Текущая версия модуля
     *
     * @return string
     */
    public function getVersion()
    {
        return null;
    }

    /**
     * Массив с именами модулей, от которых зависит работа данного модуля
     *
     * @return array
     */
    public function getDependencies()
    {
        return [];
    }

    /**
     * Работоспособность модуля может зависеть от разных факторов: версия php, версия Yii, наличие определенных модулей и т.д.
     * В этом методе необходимо выполнить все проверки.
     *
     * @return array или false
     * @example
     *   if (!$this->uploadPath)
     *        return array[
     *            'type' => WebModule::CHECK_ERROR,
     *            'message' => Yii::t('core', 'Пожалуйста, укажите директорию для загрузки изображений! {link}', [
     *                '{link}' => CHtml::link(Yii::t('core', 'Изменить настройки модуля'), ['/core/backend/modulesettings/', 'module' => $this->id])
     *            ])
     *        ];
     *   Данные сообщения выводятся на главной странице панели управления
     *
     */
    public function checkSelf()
    {
        return true;
    }

    /**
     * Категория модуля
     *
     * @return string
     */
    public function getCategory()
    {
        return null;
    }

    /**
     * Название модуля
     *
     * @return string
     */
    public function getTitle()
    {
        return null;
    }

    /**
     * Класс иконки модуля из font-awesome
     *
     * Только часть {NAME} из "fa fa-{NAME}"
     *
     * @return string
     */
    public function getIcon()
    {
        return null;
    }

    /**
     * Массив элементов для панели навигации по модулю
     *
     * @return array
     */
    public function getNavigation()
    {
        return [];
    }

    /**
     * Массив лейблов для параметров (свойств) модуля.
     * Используется на странице настроек модуля в панели управления.
     *
     * @return array
     */
    public function getParamsLabels()
    {
        return [];
    }

    /**
     * Массив параметров модуля, которые можно редактировать через панель управления (GUI)
     *
     * @return array
     */
    public function getEditableParams()
    {
        return [];
    }

    /**
     * Массив параметров модуля, для группировки на странице настроек
     *
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [];
    }

    /**
     * Массив правил валидации для модуля
     *
     * Пример использования возвращаемого массива:
     * <pre>
     * [
     *     ['adminMenuOrder', 'required'],
     *     ['someEditableParam1, someEditableParam2', 'length', 'min'=>3, 'max'=>12],
     *     ['anotherEditableParam', 'compare', 'compareAttribute'=>'password2', 'on'=>'register']
     * ];
     * </pre>
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Получение имен параметров из getEditableParams()
     *
     * @return array
     */
    public function getEditableParamsKey()
    {
        $keyParams = [];
        foreach ($this->getEditableParams() as $key => $value) {
            $keyParams[] = is_int($key) ? $value : $key;
        }
        return $keyParams;
    }

    /**
     * Метод формирующий из массива "правил валидации для модуля" правила для указаного параметра
     *
     * @param string $param Параметр для которого необходимо сформировать правила валидации
     * @return array Массив с правилами валидации для $param
     */
    public function getRulesForParam($param)
    {
        $rules = $this->rules();
        $rulesFromParam = [];
        if (count($rules)) {
            foreach ($rules as $rule) {
                $params = preg_split('/[\s,]+/', $rule[0], -1, PREG_SPLIT_NO_EMPTY);
                if (in_array($param, $params)) {
                    $rule[0] = 'param_value';
                    $rulesFromParam[] = $rule;
                }
            }
        }
        return $rulesFromParam;
    }

    /**
     * Правила маршрутизации для модулей
     *
     * @return GroupUrlRule
     */
    public function getUrlRules()
    {
        return new GroupUrlRule([]);
    }
}