<?php
// Em: config/Database.php

namespace Config;

use Dotenv\Dotenv;
use PDO;
use PDOException;

// Carrega o autoloader do Composer.
// Se este ficheiro não for encontrado, significa que o 'composer install' não foi executado.
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} else {
    die("❌ Autoloader do Composer não encontrado. Execute 'composer install' na raiz do projeto.");
}

class Database {
    // A propriedade $pdo guarda a instância da conexão para ser reutilizada (padrão Singleton).
    private static $pdo = null;

    /**
     * Estabelece e retorna uma conexão com a base de dados.
     * @return PDO A instância da conexão PDO.
     */
    public static function connect(): PDO {
        // Se a conexão ainda não foi criada, cria uma nova.
        if (self::$pdo === null) {
            try {
                // 1. Carrega as variáveis de ambiente do ficheiro .env
                $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
                $dotenv->load();

                // 2. Valida se as variáveis essenciais foram carregadas
                $required_vars = ['DB_HOST', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD', 'DB_PORT'];
                foreach ($required_vars as $var) {
                    if (empty($_ENV[$var])) {
                        throw new \Exception("Variável de ambiente '{$var}' não está definida no seu ficheiro .env");
                    }
                }

                // 3. Atribui as variáveis
                $host = $_ENV['DB_HOST'];
                $db   = $_ENV['DB_DATABASE'];
                $user = $_ENV['DB_USERNAME'];
                $pass = $_ENV['DB_PASSWORD'];
                $port = $_ENV['DB_PORT'];

                // 4. Monta a string de conexão (DSN) para PostgreSQL
                $dsn = "pgsql:host={$host};port={$port};dbname={$db}";

                // 5. Tenta a conexão
                self::$pdo = new PDO($dsn, $user, $pass);

                // Configura o PDO para lançar exceções em caso de erro.
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                // Captura erros específicos de conexão (ex: senha errada)
                error_log("❌ Erro de conexão com o banco de dados: " . $e->getMessage());
                die("Ocorreu um problema ao conectar-se ao serviço. Por favor, tente mais tarde.");
            } catch (\Exception $e) {
                // Captura outros erros de configuração (ex: .env em falta)
                error_log("❌ Erro de configuração: " . $e->getMessage());
                die("Ocorreu um problema de configuração no sistema. Contacte o suporte.");
            }
        }
        
        // Retorna a instância da conexão já existente ou a recém-criada.
        return self::$pdo;
    }
}
