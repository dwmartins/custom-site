<?php

namespace App\Models;

use App\Class\SelectedProjects;
use App\Models\Database;
use App\Utils\Logger;
use Exception;
use PDO;
use PDOException;

class SelectedProjectsDAO extends Database {
    private static $databaseTable = "selected_projects";

    public static function save(SelectedProjects $selectedProjects) {
        try {
            $pdo = self::getConnection();

            $sql = "INSERT INTO ". self::$databaseTable ." (product_id, position) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);

            $values = [$selectedProjects->getProductId(), $selectedProjects->getPosition()];

            $stmt->execute($values);

            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            throw new Exception("Falha ao salvar o projeto selecionado");
        }
    }

    public static function fetchAll() {
        try {
            $pdo = self::getConnection();

            $sql = "SELECT prod.id, prod.name, prod.type, prod.photo, proj.position
                    FROM products AS prod
                    INNER JOIN ". self::$databaseTable ." AS proj ON prod.id = proj.product_id
                    ORDER BY proj.position
            ";
            
            $stmt = $pdo->prepare($sql);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            throw new Exception("Falha ao buscas os projetos selecionados");
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
            throw new Exception("Falha ao deletar o projeto selecionado");
        }
    }
}