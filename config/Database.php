<?php
if (!function_exists('conectarDB')) {
    function conectarDB(): PDO {
        $host = 'aws-1-sa-east-1.pooler.supabase.com';
        $port = '5432';
        $dbname = 'postgres';
        $user = 'postgres.eczkjsrfupjnaijhpjey';
        $password = 'Edeilson2025';

        try {
            $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $pdo;
        } catch (PDOException $e) {
            error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
            throw $e;
        }
    }
}

?>
