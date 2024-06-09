<?php

namespace App\Models;

use App\Class\Product;
use App\Models\Database;
use App\Utils\Logger;
use Exception;
use PDO;
use PDOException;

class ProductDAO extends Database {

    private static $databaseTable = "products";

    public static function save(Product $product) {
        try {
            $pdo = self::getConnection();

            $columns = [];
            $placeholders = [];
            $values = [];

            $ignoredColumns = ["createdAt", "updatedAt"];

            foreach ($product as $key => $value) {
                if(!property_exists($product, $key)) {
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
            throw new Exception("Falha ao salvar o produto");
        }
    }

    public static function update(Product $product) {
        try {
            $pdo = self::getConnection();

            $columns = [];
            $values = [];

            $ignoredColumns = ["id", "photo", "createdAt", "updatedAt"];

            foreach ($product as $key => $value) {
                if(!property_exists($product, $key)) {
                    continue;
                }

                if(in_array($key, $ignoredColumns)) {
                    continue;
                }

                $columns[] = "$key = ?";
                $values[] = $value;
            }

            $columns = implode(", ", $columns);
            $values[] = $product->getId();

            $sql = "UPDATE ". self::$databaseTable ." SET $columns WHERE id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($values);

            return $stmt->rowCount();

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            throw new Exception("Falha ao editar o produto");
        }
    }

    public static function updatePhoto($fileName, $productId) {
        try {
            $pdo = self::getConnection();

            $sql = "UPDATE ". self::$databaseTable ." SET photo = ? WHERE id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$fileName, $productId]);

            return $stmt->rowCount();

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            throw new Exception("Falha ao atualizar a foto o produto");
        }
    }

    public static function delete($id) {
        try {
            $pdo = self::getConnection();

            $sql = "DELETE FROM ". self::$databaseTable ." WHERE id = ?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->rowCount();

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            throw new Exception("Falha ao deletar o produto");
        }
    }

    public static function fetchAll($filters) {
        try {
            $pdo = self::getConnection();

            $sql = "SELECT * FROM ". self::$databaseTable ."";
            $stmt = $pdo->prepare($sql);

            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            throw new Exception("Falha ao buscas os produtos");
        }
    }

    public static function fetchById($id) {
        try {
            $pdo = self::getConnection();

            $sql = "SELECT * FROM ". self::$databaseTable ." WHERE id = ? LIMIT 1";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            throw new Exception("Falha ao buscar o produto por id.");
        }
    }
}