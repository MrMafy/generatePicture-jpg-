<?php

namespace Src;

/**
 * Класс предназначен для предварительной генерации кэша изображений.
 */
class CachePreloader
{
    /**
     * Метод предварительной загрузки изображений в кэш
     *
     * @return void
     */
    public static function preload(): void
    {
        $repository = new ImageSizeRepository();
        $resizer = new ImageResizer();

        $sizes = ['min', 'big'];
        $images = glob(Config::GALLERY_PATH . '/*.jpg');

        foreach ($images as $imagePath) {
            $name = basename($imagePath, '.jpg');

            foreach ($sizes as $sizeCode) {
                $cachePath = Config::CACHE_PATH . "/{$name}_{$sizeCode}.jpg";

                if (!file_exists($cachePath)) {
                    $size = $repository->getSizeByCode($sizeCode);
                    if ($size && isset($size['width'], $size['height'])) {
                        $resizer->resize($imagePath, $cachePath, $size['width'], $size['height']);
                    }
                }
            }
        }
    }
}