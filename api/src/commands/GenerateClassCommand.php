<?php

namespace App\Commands;

class GenerateClassCommand {
    public static function execute($name) {
        self::generateClass($name);
        self::generateModel($name);
    }

    private static function generateClass($name) {
        $className = ucfirst($name);
        $filename = "{$className}.php";
        $template = <<<EOT
<?php

namespace App\Classes;

class {$className} {
    // Implementação da classe
}

EOT;

        $path = __DIR__ . "/../Class/{$filename}";
        file_put_contents($path, $template);
        showSuccessLog("Classe criada: {$filename}.");
    }

    private static function generateModel($name) {
        $className = ucfirst($name) . 'DAO';
        $filename = "{$className}.php";
        $template = <<<EOT
<?php

namespace App\Models;

use App\Models\Database;

class {$className} extends Database{
    protected \$db;

    public function __construct(Database \$db) {
        \$this->db = self::getConnection();
    }

    public function create(\$data) {
        // Implementação do método de criação
    }

    public function read(\$id) {
        // Implementação do método de leitura
    }

    public function update(\$data) {
        // Implementação do método de atualização
    }

    public function delete(\$id) {
        // Implementação do método de deleção
    }
}

EOT;

        $path = __DIR__ . "/../Models/{$filename}";
        file_put_contents($path, $template);
        showSuccessLog("Model criada: {$filename}");
    }
}
