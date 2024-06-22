<?php

namespace App\Commands;

class GenerateMigrationCommand {
    public static function execute($description) {
        $timestamp = date('YmdHis');
        $className = ucfirst($description);
        $filename = "Migration_{$timestamp}_{$description}.php";
        $template = <<<EOT
<?php

use App\Models\Database;

class Migration_{$timestamp}_{$description} extends Database{
    protected \$db;

    public function __construct() {
        \$this->db = self::getConnection();
    }

    public function up() {
        // Migration implementation (up)
        //\$sql = "";

        //\$stmt = \$this->db->prepare(\$sql);
        //\$stmt->execute();
    }

    public function down() {
        // Migration implementation (rollback)
    }
}

EOT;

        $path = __DIR__ . "/../../migrations/{$filename}";
        file_put_contents($path, $template);
        showSuccessLog("Migration created: {$filename}");
    }
}
