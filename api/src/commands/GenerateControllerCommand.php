<?php

namespace App\Commands;

class GenerateControllerCommand {
    public static function execute($name) {
        $className = ucfirst($name) . 'Controller';
        $filename = "{$className}.php";
        $template = <<<EOT
<?php

namespace App\Controllers;

class {$className} {
    public function index() {
        // Código para listar recursos
    }

    public function show(\$id) {
        // Código para mostrar um recurso específico
    }

    public function create() {
        // Código para criar um novo recurso
    }

    public function update(\$id) {
        // Código para atualizar um recurso específico
    }

    public function delete(\$id) {
        // Código para deletar um recurso específico
    }
}

EOT;

        $path = __DIR__ . "/../Controllers/{$filename}";
        file_put_contents($path, $template);
        showSuccessLog("Controller criado: {$filename}");
    }
}
