<?php

class DB
{
    private static $instance;
    private $pdo;

    private function __construct($host, $user, $password, $db_name)
    {
        $this->pdo = new PDO("mysql: host={$host}; dbname={$db_name}", $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function __clone() {}

    private function __wakeUp() {}

    public function getPDO()
    {
        return $this->pdo;
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new DB(
                Config::get('db.host'),
                Config::get('db.user'),
                Config::get('db.password'),
                Config::get('db.db_name')
            );
        }

        return self::$instance;
    }
}