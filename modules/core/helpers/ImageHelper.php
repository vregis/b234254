<?php

namespace modules\core\helpers;

use Imagine\Image\ManipulatorInterface;
use yii\imagine\Image;

/**
 * Методы для работы с изображениями
 *
 * @author MrArthur
 * @since 1.0.0
 */
class ImageHelper
{
    /**
     * Возвращает длину изображения
     *
     * @param $path string Полный путь к изображению
     * @return int Длина изображения в пикселях
     */
    public static function getWidth($path)
    {
        return (int)getimagesize($path)[0];
    }

    /**
     * Возвращает ширину изображения
     *
     * @param $path string Полный путь к изображению
     * @return int Ширина изображения в пикселях
     */
    public static function getHeight($path)
    {
        return (int)getimagesize($path)[1];
    }

    /**
     * Обертка для yii\imagine\thumbnail
     *
     * @param $filename
     * @param $width
     * @param $height
     * @param $mode
     * @return \Imagine\Image\ImageInterface
     */
    public static function thumbnail($filename, $width, $height, $mode = ManipulatorInterface::THUMBNAIL_OUTBOUND)
    {
        return Image::thumbnail($filename, $width, $height, $mode);
    }
}