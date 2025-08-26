<?php
// Em: config/Database.php

namespace Config;

use Dotenv\Dotenv;
use PDO;
use PDOException;

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} else {
    die("❌ Autoloader do Composer não encontrado. Execute 'composer install' na raiz do projeto.");
}

class Database {
    private static $pdo = null;

    public static function connect(): PDO {
        if (self::$pdo === null) {
            try {
                $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
                $dotenv->load();

                $required_vars = ['DB_HOST', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD', 'DB_PORT'];
                foreach ($required_vars as $var) {
                    if (empty($_ENV[$var])) {
                        throw new \Exception("Variável de ambiente '{$var}' não está definida no seu ficheiro .env");
                    }
                }

                $host = $_ENV['DB_HOST'];
                $db   = $_ENV['DB_DATABASE'];
                $user = $_ENV['DB_USERNAME'];
                $pass = $_ENV['DB_PASSWORD'];
                $port = $_ENV['DB_PORT'];

                $dsn = "pgsql:host={$host};port={$port};dbname={$db}";

                self::$pdo = new PDO($dsn, $user, $pass);

                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                error_log("❌ Erro de conexão com o banco de dados: " . $e->getMessage());
                die("Ocorreu um problema ao conectar-se ao serviço. Por favor, tente mais tarde.");
            } catch (\Exception $e) {
                error_log("❌ Erro de configuração: " . $e->getMessage());
                die("Ocorreu um problema de configuração no sistema. Contacte o suporte.");
            }
        }
        
        return self::$pdo;
    }
}
