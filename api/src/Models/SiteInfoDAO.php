<?php

namespace App\Models;

use App\Class\SiteInfo;
use App\Models\Database;
use App\Utils\Logger;
use Exception;
use PDO;
use PDOException;

class SiteInfoDAO extends Database {
    private static $databaseTable = "siteInfo";

    public static function save(SiteInfo $siteInfo) {
        try {
            $pdo = self::getConnection();

            $columns = [];
            $placeholders = [];
            $values = [];

            $ignoredColumns = ["createdAt", "updatedAt"];

            foreach ($siteInfo as $key => $value) {
                if(!property_exists($siteInfo, $key)) {
                    continue;
                }

                if(in_array($key, $ignoredColumns)) {
                    continue;
                }

                $columns[] = $key;
                $placeholders[] = "?";
                $values[] = $value;
            }

            $columns = implode(", ", $columns);
            $placeholders = implode(", ", $placeholders);

            $sql = "INSERT INTO ". self::$databaseTable ." ($columns) VALUES ($placeholders)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($values);

            return $pdo->lastInsertId();

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            throw new Exception("Falha ao salvar as informações do site");
        }
    }

    public static function update(SiteInfo $siteInfo) {
        try {
            $pdo = self::getConnection();

            $columns = [];
            $values = [];

            $ignoredColumns = ["id", "createdAt", "updatedAt"];

            foreach ($siteInfo as $key => $value) {
                if(!property_exists($siteInfo, $key)) {
                    continue;
                }

                if(in_array($key, $ignoredColumns)) {
                    continue;
                }

                $columns[] = "$key = ?";
                $values[] = $value;
            }

            $columns = implode(", ", $columns);
            $values[] = $siteInfo->getId();

            $sql = "UPDATE ". self::$databaseTable ." SET $columns WHERE id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($values);

            return $stmt->rowCount();

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            throw new Exception("Falha ao atualizar as informações do site");
        }
    }

    public static function fetchAll() {
        try {
            $pdo = self::getConnection();

            $sql = "SELECT * FROM ". self::$databaseTable ."";
            $stmt = $pdo->prepare($sql);

            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            throw new Exception("Falha ao buscas as informações do site");
        }
    }
}