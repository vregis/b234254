<?php

namespace modules\core\admin\controllers;

use modules\core\base\Controller;
use Yii;
use yii\helpers\FileHelper;

/**
 * Класс CacheController
 *
 * @author Konstantin Sychev
 * @author MrArthur
 * @since 1.0.0
 */
class CacheController extends Controller
{
    /**
     * Очистка кеша по $type
     *
     * @param $type
     * @return \yii\web\Response
     */
    public function actionClean($type)
    {
        switch ($type) {
            case 'frontend':
                // найти и удалить содержимое папки frontend/web/assets
                self::deleteFrontendAsests();
                break;

            case 'backend':
                // найти и удалить содержимое папки backend/web/assets
                self::deleteBackendAsests();
                break;

            case 'frontend-runtime':
                // найти и удалить содержимое папки frontend/runtime
                self::deleteFrontendRuntime();
                break;

            case 'backend-runtime':
                //удалить содержимое папки backend/runtime
                self::deleteBackendRuntime();
                break;

            case 'option':
                //удалить файл настроек    
                self::deleteSetupFile();
                break;

            case 'all':
                // удалить содержимое папки backend/web/assets  и frontend/web/assets а так-же все frontend/runtime и backend/runtime
                self::deleteFrontendAsests();
                self::deleteBackendAsests();
                self::deleteFrontendRuntime();
                self::deleteBackendRuntime();
                self::deleteSetupFile();
                self::deleteYiiCache();
                Yii::$app->session->setFlash('success', Yii::t('core', 'Кеш успешно удален'));
                break;
        }
        return $this->goHome();
    }

    /**
     * Удаление кеш-файла настроек
     */
    public static function deleteSetupFile()
    {
        $file = Yii::getAlias('@cache') . '/settings.php';
        if (is_file($file)) {
            @unlink($file);
        }
        Yii::$app->session->setFlash('success', Yii::t('core', 'Настройки успешно сброшены'));
    }

    /**
     * Очистка frontend/assets
     */
    public static function deleteFrontendAsests()
    {
    /*    $dirs = glob(Yii::getAlias('@frontend') . '/web/assets/*', GLOB_ONLYDIR);
        foreach ($dirs as $dir) {
            FileHelper::removeDirectory($dir);
        }
        Yii::$app->session->setFlash('success', Yii::t('core', 'Кеш успешно удален'));*/
    }

    /**
     * Очистка backend/assets
     */
    public static function deleteBackendAsests()
    {
        $dirs = glob(Yii::getAlias('@backend') . '/web/assets/*', GLOB_ONLYDIR);
        foreach ($dirs as $dir) {
            FileHelper::removeDirectory($dir);
        }
        Yii::$app->session->setFlash('success', Yii::t('core', 'Кеш успешно удален'));
    }

    /**
     * Очистка frontend/runtime
     */
    public static function deleteFrontendRuntime()
    {
    /*    $dirs = glob(Yii::getAlias('@frontend') . '/runtime/*', GLOB_ONLYDIR);
        foreach ($dirs as $dir) {
            FileHelper::removeDirectory($dir);
        }
        Yii::$app->session->setFlash('success', Yii::t('core', 'Кеш успешно удален'));*/
    }

    /**
     * Очистка backend/runtime
     */
    public static function deleteBackendRuntime()
    {
        $dirs = glob(Yii::getAlias('@backend') . '/runtime/*', GLOB_ONLYDIR);
        foreach ($dirs as $dir) {
            FileHelper::removeDirectory($dir);
        }
        Yii::$app->session->setFlash('success', Yii::t('core', 'Кеш успешно удален'));
    }

    /**
     * Очистка @root/cache/yii
     */
    public static function deleteYiiCache()
    {
        $files = glob(Yii::getAlias('@cache') . '/yi/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
        Yii::$app->session->setFlash('success', Yii::t('core', 'Кеш успешно удален'));
    }
}