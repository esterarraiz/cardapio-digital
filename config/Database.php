<?php

// É uma boa prática usar namespaces para organizar seu código.
namespace Config;

// Importa as classes que serão usadas neste arquivo.
// Isso evita ter que escrever o caminho completo da classe toda vez.
use Dotenv\Dotenv;
use PDO;
use PDOException;

/**
 * Carrega o autoloader do Composer.
 * Esta é a linha MAIS IMPORTANTE. Ela "ensina" o PHP a encontrar a classe Dotenv e outras bibliotecas.
 * O caminho __DIR__ . '/../vendor/autoload.php' significa:
 * a partir do diretório deste arquivo (config), volte um nível (para a raiz) e entre em vendor/autoload.php
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Carrega as variáveis de ambiente do arquivo .env
 * que está na raiz do projeto.
 */
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


class Database {
    // As propriedades continuam privadas
    private static $host;
    private static $db;
    private static $user;
    private static $pass;
    private static $port;
    private static $pdo = null;

    public static function connect(): PDO {
        // Se a conexão ainda não foi criada...
        if (self::$pdo === null) {
            // Pega as variáveis de ambiente carregadas pelo Dotenv
            self::$host = $_ENV['DB_HOST'];
            self::$db   = $_ENV['DB_DATABASE'];
            self::$user = $_ENV['DB_USERNAME'];
            self::$pass = $_ENV['DB_PASSWORD'];
            self::$port = $_ENV['DB_PORT'];

            try {
                // Monta a string de conexão (DSN)
                $dsn = "pgsql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$db;

                // Cria a nova instância do PDO
                self::$pdo = new PDO($dsn, self::$user, self::$pass);

                // Configura o modo de erro para lançar exceções, o que é ótimo para debugar.
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                // Em caso de erro, a execução é interrompida e a mensagem de erro é exibida.
                // Em um ambiente de produção, você poderia registrar esse erro em um log em vez de exibir na tela.
                die("❌ Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }
        // Retorna a instância da conexão
        return self::$pdo;
    }
}