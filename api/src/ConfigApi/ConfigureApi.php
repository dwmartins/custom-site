<?php

require_once __DIR__."/../../vendor/autoload.php";

$envPath = __DIR__ . "/../../.env";

if (!file_exists($envPath)) {
    echo "\033[41mArquivo (.env) não encontrado.\033[0m\n";
    exit();
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../../");
$dotenv->load();

use App\Http\JWTManager;
use App\Models\Database;
use App\Utils\Logger;

class ConfigureApi extends Database{

    private $tableUsers;
    private $tableProducts;
    private $selectedProjects;
    private $tableSiteInfo;
    private $dbname;

    public function __construct() {
        $this->dbname = $_ENV['DB_DATABASE'];

        $this->tableUsers = "users";
        $this->tableProducts = "products";
        $this->selectedProjects = "selected_projects";
        $this->tableSiteInfo = "siteInfo";
    }
    
    public function createAll() {
        try {
            $this->databaseExists();

            $this->userTable();
            $this->productsTable();
            $this->selectedProjectsTable();
            $this->siteInfoTable();
            
            $this->showSuccessLog("Inserindo dados necessários no banco.");
            $this->createAdminUser();
            $this->showSuccessLog("API Configurada com sucesso.");
        } catch (Exception $e) {
            return;
        }
    }

    public function databaseExists() {
        try {

            echo "[".date('Y-m-d H:i:s')."] Verificando se o banco de dados '{$this->dbname}' existe. \n";

            $pdo = self::getConnection();
            $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = ?");

            $stmt->execute([$this->dbname]);

            $return = $stmt->fetchColumn() !== false;
            echo $return;
        } catch (PDOException $e) {
            Logger::logError($e->getMessage());

            if($e->getCode() === 1049) {
                $this->showErrorLog("O banco de dados '{$this->dbname}' não existe.");
                throw new Exception();
                return;
            }

            $this->showErrorLog("Falha ao verificar a existência do banco de dados '{$this->dbname}'", $e);
            throw new Exception();
            return false;
        }
    }

    public function userTable() {
        try {
            echo "[".date('Y-m-d H:i:s')."] Criando a tabela '{$this->tableUsers}' \n";

            $pdo = self::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS {$this->tableUsers} (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                lastName VARCHAR(50) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                token TEXT NOT NULL,
                active ENUM('Y', 'N'),
                role VARCHAR(50) NOT NULL,
                photo VARCHAR(255),
                createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
                updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);
            ";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            $this->showErrorLog("Falha ao criar a tabela '{$this->tableUsers}'", $e);
            throw new Exception();
        }
    }

    public function productsTable() {
        try {
            echo "[".date('Y-m-d H:i:s')."] Criando a tabela '{$this->tableProducts}' \n";

            $pdo = self::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS {$this->tableProducts} (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                type VARCHAR(100) NOT NULL,
                photo VARCHAR(255),
                referenceCode VARCHAR(255) NOT NULL,
                createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
                updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);
            ";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            $this->showErrorLog("Falha ao criar a tabela '{$this->tableProducts}'", $e);
            throw new Exception();
        }
    }

    public function selectedProjectsTable() {
        try {
            echo "[".date('Y-m-d H:i:s')."] Criando a tabela '{$this->selectedProjects}' \n";

            $pdo = self::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS {$this->selectedProjects} (
                id INT AUTO_INCREMENT PRIMARY KEY,
                product_Id INT NOT NULL,
                position INT NOT NULL,
                photo VARCHAR(255),
                createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
                updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (product_Id) REFERENCES {$this->tableProducts}(id) ON DELETE CASCADE);
            ";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            $this->showErrorLog("Falha ao criar a tabela '{$this->selectedProjects}'", $e);
            throw new Exception();
        }
    }

    public function siteInfoTable() {
        try {
            echo "[".date('Y-m-d H:i:s')."] Criando a tabela '{$this->tableSiteInfo}' \n";

            $pdo = self::getConnection();

            $sql = "CREATE TABLE IF NOT EXISTS {$this->tableSiteInfo} (
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
                createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
                updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);
            ";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            $this->showErrorLog("Falha ao criar a tabela '{$this->tableSiteInfo}'", $e);
            throw new Exception();
        }
    }

    public function createAdminUser() {
        try {
            echo "[".date('Y-m-d H:i:s')."] Criando o usuário administrador do site. \n";

            $pdo = self::getConnection();

            $sql = "INSERT INTO {$this->tableUsers}  (name, email, password, token, active, role) VALUES (?, ?, ?, ?, ?, ?);";
            $stmt = $pdo->prepare($sql);

            $values = [
                "Administrador",
                $_ENV['ADMEMAIL'],
                password_hash("abc123", PASSWORD_DEFAULT),
                JWTManager::newCrypto(),
                "y",
                "admin"
            ];

            $stmt->execute($values);

            echo "\nDados do usuário administrador do site: \n";
            echo "Usuário: {$_ENV['ADMEMAIL']} \n";
            echo "Senha: abc123 \n \n";
            echo "Altere sua senha no gerenciador do site para uma de sua preferência. \n";

            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            Logger::logError($e->getMessage());
            $this->showErrorLog("Falha ao criar o usuário administrador", $e);
            throw new Exception();
        }
    }

    public function showErrorLog($message, $e = null) {
        $errorTime = date('Y-m-d H:i:s');
        $errorLog = '';

        if(!empty($e)) {
            $errorMsg = "$message: {$e->getMessage()}";
            $errorLog = "[$errorTime] $errorMsg";
        } else {
            $errorLog = "[$errorTime] $message";
        }

        echo "\033[41m{$errorLog}\033[0m\n" . PHP_EOL;
    }

    public function showSuccessLog($message) {
        echo "\n\033[42m{$message}\033[0m" . PHP_EOL . PHP_EOL;
    }
}

echo "Por favor, insira a senha para configurar a API: ". PHP_EOL;
$apiPassword = rtrim(fgets(STDIN));

if($apiPassword === $_ENV['PASSWORD_CONFIG_API']) {
    $apiConfig = new ConfigureApi();
    $apiConfig->showSuccessLog("Iniciando configuração da API.");
    $apiConfig->createAll();
    return;
} else {
    echo "\033[41mSenha invalida.". PHP_EOL ."\033[0m\n";
}


