<?php

namespace App\Models;

use PDO;

class Database {
    public static function getConnection() {
        $host       = $_ENV['DB_HOST'];
        $dbname     = $_ENV['DB_DATABASE'];
        $username   = $_ENV['DB_USERNAME'];
        $password   = $_ENV['DB_PASSWORD'];
        $dbType     = $_ENV['DB_TYPE'];

        $pdo = new PDO("$dbType:host=$host;dbname=$dbname", $username, $password);

        return $pdo;
    }
}