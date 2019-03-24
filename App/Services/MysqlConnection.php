<?php

namespace App\Services;

use PDO;
use PDOException;

class mysqlConnection
{
    private $pdo = null;
    public static $instance;
    private function __construct()
    {
            $config = require_once ROOT_DIR . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'mysql.php';
            $dsn = 'mysql:host=' . $config['db_host'] .
                ';port=' . $config['db_port'] .
                ';dbname=' . $config['db_name'] .
                ';charset=' . $config['char_set'] . ';';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];

            try {
                $this->pdo = new PDO($dsn, $config['mysql_user'], $config['mysql_password'], $options);
            } catch (PDOException $err) {
                echo $err->getMessage();
            }
    }

    public static function instance(){
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->pdo;
    }
}