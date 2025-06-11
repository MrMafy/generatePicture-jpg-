<?php
/*
 * Скрипт генерации кэшированных уменьшенных копий изображений по запросу
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Src\Config;
use Src\ImageSizeRepository;
use Src\ImageResizer;

ini_set('display_errors', '1');
error_reporting(E_ALL);

try {
    [$name, $sizeCode] = validateRequest($_GET);
    header('Cache-Control: public, max-age=31536000');

    $sourcePath = getImagePath($name);
    $cachePath = Config::CACHE_PATH . "/{$name}_{$sizeCode}.jpg";

    if (!file_exists($cachePath)) {
        resizeImage($sourcePath, $cachePath, $sizeCode);
    }

    header('Content-type: image/jpeg');
    readfile($cachePath);
    exit;

} catch (Throwable $e) {
    $code = $e->getCode();

    http_response_code($code);
    echo "Ошибка: " . $e->getMessage() . "\n";
    exit;
}

/**
 * Данная функция проверяет наличие обязательных GET-параметров: name и size.
 *
 * @param array $params
 * @return array
 */
function validateRequest(array $params): array
{
    $name = $params['name'] ?? null;
    $sizeCode = $params['size'] ?? null;

    if (!$name || !$sizeCode) {
        throw new InvalidArgumentException("Отсутствует 'name' или 'size'", 400);
    }

    return [$name, $sizeCode];
}

/**
 * Данная функция формирует путь к изображению и проверяет его существование.
 *
 * @param string $name
 * @return string
 */
function getImagePath(string $name): string
{
    $sourcePath = Config::GALLERY_PATH . "/$name.jpg";

    if (!file_exists($sourcePath)) {
        throw new RuntimeException("Картинка не найдена: $name", 404);
    }

    return $sourcePath;
}

/**
 * Данная функция изменяет размер изображения и сохраняет его в кэш.
 *
 * @param string $sourcePath
 * @param string $cachePath
 * @param string $sizeCode
 * @return void
 */
function resizeImage(string $sourcePath, string $cachePath, string $sizeCode): void
{
    $repository = new ImageSizeRepository();
    $size = $repository->getSizeByCode($sizeCode);

    if (!$size || !isset($size['width'], $size['height'])) {
        throw new RuntimeException("Неправильный размер: $sizeCode", 404);
    }

    $resizer = new ImageResizer();
    $success = $resizer->resize($sourcePath, $cachePath, $size['width'], $size['height']);

    if (!$success) {
        throw new RuntimeException("Не удалось изменить размер изображения", 500);
    }
}