<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/loadConfig.php';

use App\Commands\GenerateMigrationCommand;
use App\Commands\GenerateControllerCommand;
use App\Commands\GenerateClassCommand;
use App\Commands\MigrateCommand;

// Verifica se um comando foi passado via linha de comando
if (isset($argv[1])) {
    $command = $argv[1];

    switch ($command) {
        case 'generate:migration': 
            if (isset($argv[2])) {
                GenerateMigrationCommand::execute($argv[2]);
            } else {
                showLog("Usage: php console.php generate:migration DESCRIPTIVE_NAME");
            }
            break;

        case 'generate:controller':
            if (isset($argv[2])) {
                GenerateControllerCommand::execute($argv[2]);
            } else {
                showLog("Usage: php console.php generate:controller NAME");
            }
            break;

        case 'generate:class':
            if (isset($argv[2])) {
                GenerateClassCommand::execute($argv[2]);
            } else {
                showLog("Usage: php console.php generate:class NAME");
            }
            break;

        case 'migrate':
            MigrateCommand::execute("migrate");
            break;

        case 'rollback':
            $command = $argv[2] ?? null;
            MigrateCommand::execute("rollback", $command);
            break;

        default:
           showCommands();
            break;
    }
} else {
    showCommands();
}

function showCommands() {
    showLog("Command not found!");
    echo PHP_EOL;
    showLog(" php console.php generate:migration DESCRIPTIVE_NAME - To generate a new migration");
    showLog(" php console.php generate:controller NAME - To generate a new controller");
    showLog(" php console.php Generate:class NAME - To generate a new class");
    showLog(" php console.php migrate - To run migrations");
    showLog(" php console.php rollback - To rollback the last migration");
    showLog(" php console.php rollback --name:NAME_MIGRATION to rollback a specific migration. ");
    showLog(" php console.php rollback --order:N to roll back the last N migrations.");
}