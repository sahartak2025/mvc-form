<?php

namespace app\components;

use Exception;
use PDO;

class DB
{
    private static ?DB $instance = null;

    private ?PDO $connection = null;

    private string $host = 'localhost';
    private string $user = 'root';
    private string $password = '';
    private string $dbName = 'test_db';

    private function __construct()
    {
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $this->connection = new PDO(
            "mysql:host={$this->host};dbname={$this->dbName}",
            $this->user,
            $this->password,
            $options
        );
    }

    public static function getInstance(): DB
    {
        if (self::$instance === null) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    private function __clone() {}

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception('Cannot unserialize a singleton.');
    }

    public function getConnection(): ?PDO
    {
        return $this->connection;
    }
}