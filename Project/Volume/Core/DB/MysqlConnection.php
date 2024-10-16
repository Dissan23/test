<?php

namespace Core\DB;

use PDO;
use Core\DB\Interfaces\DbInterface;
use Exception;

final class MysqlConnection implements DbInterface
{
    private static ?MysqlConnection $instance = null;

    private PDO $connection;

    public function __construct()
    {
        $this->connection = new PDO("mysql:host=$_ENV[DB_HOST];port=$_ENV[DB_PORT];dbname=$_ENV[DB_NAME]", "$_ENV[DB_USER]", "$_ENV[DB_PASSWORD]");
    }

    public static function getInstance(): MysqlConnection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): object
    {
        return $this->connection;
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}
