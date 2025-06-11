<?php

namespace Src;

use PDO;
use PDOException;


/**
 * Класс предназначен для инициализации БД, проверяя наличие таблицы
 */
class DatabaseInitializer
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new PDO(Config::getDSN(), Config::DB_USER, Config::DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    /**
     * Данный метод проверяет наличие таблицы image_sizes в БД MySQL,
     * и при её отсутствии создаёт таблицу и заполняет данными.
     *
     * @return void
     */
    public function initialize(): void
    {
        try {
            $check = $this->db->query("SHOW TABLES LIKE 'image_sizes'");

            if ($check->rowCount() === 0) {
                $this->db->exec("
                    CREATE TABLE IF NOT EXISTS image_sizes (
                        code VARCHAR(10) PRIMARY KEY,
                        width INT NOT NULL,
                        height INT NOT NULL
                    );
                    INSERT INTO image_sizes (code, width, height) VALUES
                        ('big', 800, 600),
                        ('min', 300, 200);
                ");
            }
        } catch (PDOException $e) {
            throw new PDOException("Ошибка инициализации базы данных: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}