<?php
/*
 * Скрипт для создания базы данных MySQL, если она ещё не существует.
 */

require_once __DIR__ . '/src/Config.php';

use Src\Config;

try {
    $pdo = new PDO(
        'mysql:host=' . Config::$host,
        Config::DB_USER,
        Config::DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $dbName = Config::$dbname;

    $stmt = $pdo->query("SHOW DATABASES LIKE " . $pdo->quote($dbName));
    if ($stmt->rowCount() > 0) {
        echo "База данных '$dbName' уже существует.\n";
    } else {
        // Создание базы данных
        $pdo->exec("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        echo "База данных '$dbName' успешно создана.\n";
    }

} catch (PDOException $e) {
    echo "Ошибка создания базы данных: " . $e->getMessage() . "\n";
    exit(1);
}