<?php

namespace Src;

use PDO;

/**
 * Класс предназначен для взаимодействия с таблицей 'image_sizes' в БД MySQL.
 */
class ImageSizeRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new PDO(Config::getDSN(), Config::DB_USER, Config::DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    /**
     * Метод получает размеры изображения по коду
     *
     * @param string $code
     * @return array
     */
    public function getSizeByCode(string $code): array
    {
        $stmt = $this->db->prepare('SELECT width, height FROM image_sizes WHERE code = :code');
        $stmt->execute(['code' => $code]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}