<?php

namespace app\App\core;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    public PDO $pdo;

    public function connect_db(): PDO
    {
        $host = '127.0.0.1';
        $db   = 'task_manager';
        $user = 'admin';
        $pass = 'qwerty';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }

        return $this->pdo;
    }

    public function prepare($sql): PDOStatement
    {
        return $this->pdo->prepare($sql);
    }
}