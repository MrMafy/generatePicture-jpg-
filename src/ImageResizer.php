<?php

namespace Src;

/**
 * Класс для изменения размера изображений.
 */
class ImageResizer
{
    /**
     * Данная функция изменяет размер изображения и сохраняет его в папке /cache
     *
     * @param string $sourcePath
     * @param string $cachePath
     * @param int $newWidth
     * @param int $newHeight
     * @return bool
     */
    public function resize(string $sourcePath, string $cachePath, int $newWidth, int $newHeight): bool
    {
        $src = imagecreatefromjpeg($sourcePath);
        if (!$src) {
            return false;
        }

        $srcWidth = imagesx($src);
        $srcHeight = imagesy($src);
        $scale = min($newWidth / $srcWidth, $newHeight / $srcHeight);

        $resizedWidth = ($srcWidth * $scale);
        $resizedHeight = ($srcHeight * $scale);

        $dst = imagecreatetruecolor($resizedWidth, $resizedHeight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $resizedWidth, $resizedHeight, $srcWidth, $srcHeight);

        $result = imagejpeg($dst, $cachePath, 90);

        imagedestroy($src);
        imagedestroy($dst);

        return $result;
    }
}