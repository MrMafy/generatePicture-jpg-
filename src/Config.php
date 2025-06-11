<?php

namespace Src;

/**
 * Данный класс хранит конфигурационные параметры.
 */
final class Config
{
    public static string $host = "localhost"; //Меняется на своё
    public static string $dbname = "gallery2"; //Меняется на своё
    public const string DB_USER = 'Admin'; //Меняется на своё
    public const string DB_PASSWORD = 'secret'; //Меняется на своё

    public const string GALLERY_PATH = __DIR__ . '/../gallery';
    public const string CACHE_PATH = __DIR__ . '/../cache';

    public static function getDSN(): string
    {
        return 'mysql:host=' . self::$host . ';dbname=' . self::$dbname . ';charset=utf8mb4';
    }
}