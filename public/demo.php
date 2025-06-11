<?php
declare(strict_types=1);

require_once  __DIR__ . '/../vendor/autoload.php';

use Src\CachePreloader;
use Src\DatabaseInitializer;

$error = null;
$images = [];

try {
    $initializer = new DatabaseInitializer();
    $initializer->initialize();

    CachePreloader::preload();

    $images = array_slice(glob(__DIR__ . '/../gallery/*.jpg'), 0, 10);
} catch (Exception $e) {
    $error = 'Ошибка: ' . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Галерея</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/css/lightbox.min.css">
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/js/lightbox.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

<h1 style="text-align: center;">Мини галерея</h1>

<?php if ($error): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>

<div class="gallery">
    <?php foreach ($images as $image):
        $name = basename($image, '.jpg');
        ?>
        <a href="generator.php?name=<?= $name ?>&size=big" data-lightbox="gallery">
            <img src="generator.php?name=<?= $name ?>&size=min" alt="<?= $name ?>">
        </a>
    <?php endforeach; ?>
</div>

</body>
</html>