<?php

use App\Models\Database;

class Migration_20240623003324_table_site_info extends Database{
    protected $db;

    public function __construct() {
        try {
            $this->db = self::getConnection();
        } catch (PDOException $e) {
            showAlertLog("ERROR: ". $e->getMessage());
            throw $e;
        }
    }

    public function up() {
        // Migration implementation (up)
        try {
            $sql = "CREATE TABLE IF NOT EXISTS siteInfo (
                id INT AUTO_INCREMENT PRIMARY KEY,
                webSiteName VARCHAR(250),
                email VARCHAR(100),
                phone VARCHAR(100),
                city VARCHAR(100),
                state VARCHAR(100),
                address VARCHAR(250),
                workSchedule VARCHAR(250),
                instagram VARCHAR(250),
                facebook VARCHAR(250),
                description LONGTEXT,
                keywords LONGTEXT,
                createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
                updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            showAlertLog("ERROR: ". $e->getMessage());
            throw $e;
        }
    }

    public function down() {
        // Migration implementation (rollback)
    }
}
