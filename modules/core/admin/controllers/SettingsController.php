<?php

namespace modules\core\admin\controllers;

use modules\core\admin\base\Controller;
use modules\core\base\Module;
use modules\core\models\Settings;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/**
 * Контроллер для управления настройками модулей
 *
 * @author MrArthur
 * @since 1.0.0
 */
class SettingsController extends Controller
{
    /**
     * Форма редактирования настроек модуля
     *
     * @param $module Module
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionEdit($module)
    {
        // проверяем модуль на существование
        /** @var \common\modules\core\base\Module $module */
        if (!($module = Yii::$app->getModule($module))) {
            throw new NotFoundHttpException(Yii::t('core', 'Модуль не найден'));
        }

        // проверяем, есть ли методы настройки в файле модуля
        if (
            !method_exists($module, 'getEditableParams') ||
            !method_exists($module, 'getParamsLabels') ||
            !method_exists($module, 'getEditableParamsGroups')
        ) {
            throw new NotFoundHttpException(Yii::t('core', 'У модуля нет настроек'));
        }

        $editableParams = $module->getEditableParams();
        $moduleParamsLabels = $module->getParamsLabels();
        $paramGroups = $module->getEditableParamsGroups();

        // разберем элементы по группам
        $mainParams = $elements = [];

        foreach ($paramGroups as $name => $group) {

            $layout = isset($group['items']) ? array_fill_keys($group['items'], $name) : [];
            $label = isset($group['label']) ? $group['label'] : $name;

            if ($name === 'main') {
                if ($label !== $name) {
                    $mainParams['paramsgroup_' . $name] = Html::tag('h4', $label, ['class' => 'alert alert-mrarthur']);
                }
                $mainParams = ArrayHelper::merge($mainParams, $layout);
            } else {
                $elements['paramsgroup_' . $name] = Html::tag('h4', $label, ['class' => 'alert alert-mrarthur']);
                $elements = ArrayHelper::merge($elements, $layout);
            }
        }

        foreach ($module as $paramName => $paramValue) {

            if (array_key_exists($paramName, $editableParams)) {
                $element = Html::label($moduleParamsLabels[$paramName], $paramName);
                $element .= Html::dropDownList(
                    $paramName,
                    $paramValue,
                    $editableParams[$paramName],
                    [
                        'empty' => '',
                        'class' => 'form-control'
                    ]
                );
            } else {
                if (in_array($paramName, $editableParams)) {
                    $input_label = isset($moduleParamsLabels[$paramName]) ? $moduleParamsLabels[$paramName] : $paramName;
                    $element = Html::label($input_label, $paramName, ['class' => 'control-label']);
                    $element .= Html::textInput(
                        $paramName,
                        $paramValue,
                        ['maxlength' => 255, 'class' => 'form-control']
                    );

                } else {
                    unset($element);
                }
            }
            if (isset($element)) {
                if (array_key_exists($paramName, $elements)) {
                    $elements[$paramName] = $element;
                } else {
                    $mainParams[$paramName] = $element;
                }
            }
        }

        // разместим в начале основные параметры
        $elements = ArrayHelper::merge($mainParams, $elements);

        return $this->render(
            'edit',
            [
                'module' => $module,
                'elements' => $elements,
                'moduleParamsLabels' => $moduleParamsLabels,
            ]
        );
    }

    /**
     * Сохранение настроек модуля в БД
     *
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSave()
    {
        // проверяем тип запроса и передан ли ID модуля
        if (!Yii::$app->request->isPost || !($moduleId = Yii::$app->request->post('module_id'))) {
            throw new NotFoundHttpException(Yii::t('core', 'Страница не найдена'));
        }

        // проверяем сам модуль
        /** @var \common\modules\core\base\Module $module */
        if (!($module = Yii::$app->getModule($moduleId))) {
            throw new NotFoundHttpException(Yii::t('core', 'Модуль не найден'));
        }

        // сохраняем настройки
        $saveSettings = $this->saveParamsSetting($moduleId, $module->getEditableParamsKey());
        if ($saveSettings) {
            Yii::$app->session->setFlash(
                'success',
                Yii::t('core', 'Настройки для модуля "{module}" успешно сохранены!', ['module' => $module->title])
            );
            $this->getSettings(true);
        } else {
            Yii::$app->session->setFlash(
                'error',
                Yii::t(
                    'core',
                    'Произошла ошибка при сохранении настроек. Возможно вы ввели недопустимые значения для полей (строку заместо числа).'
                )
            );
        }

        $this->redirect(['/core/settings/edit', 'module' => $moduleId]);
    }

    /**
     * Метод сохранения настроек модуля:
     *
     * @param string $moduleId - идетификтор метода
     * @param array $params - массив настроек
     * @return bool
     **/
    public function saveParamsSetting($moduleId, $params)
    {
        $model = new Settings();

        $settings = $model->getModuleSettings($moduleId, $params);

        foreach ($params as $param) {
            $param_value = Yii::$app->request->post($param);
            // Если параметр уже был - обновим, иначе надо создать новый
            if (isset($settings[$param])) {

                /** @var Settings $settingsParam */
                $settingsParam = $settings[$param];

                // Если действительно изменили настройку
                if ($settingsParam->param_value !== $param_value) {
                    $settingsParam->param_value = $param_value;
                    // Добавляем для параметра его правила валидации
                    /** @var \common\modules\core\base\Module $module */
                    $module = Yii::$app->getModule($moduleId);
                    $settingsParam->rulesFromModule = $module->getRulesForParam($param);
                    if (!$settingsParam->save()) {
                        return $settingsParam->getErrors();
                    }
                }
            } else {
                $settingsParam = new Settings();
                $settingsParam->setAttributes(
                    [
                        'module_id' => $moduleId,
                        'param_name' => $param,
                        'param_value' => $param_value,
                    ]
                );
                if (!$settingsParam->save()) {
                    return $settingsParam->getErrors();
                }
            }
        }
        return true;
    }
}