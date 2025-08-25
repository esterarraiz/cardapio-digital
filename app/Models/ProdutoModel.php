<?php

namespace App\Models; // <-- CORREÇÃO: Usar barra invertida '\'

use Config\Database; // Importa sua classe de conexão com o banco de dados
use PDO;
use PDOException;

class ProdutoModel
{
    private $pdo;

    /**
     * O construtor é chamado automaticamente quando você cria um novo objeto ProdutoModel.
     * Ele estabelece a conexão com o banco de dados.
     */
    public function __construct()
    {
        // Chama o método estático 'conectar' da sua classe de configuração de banco de dados
         $this->pdo = Database::getConnection();
    }

    /**
     * Insere um novo produto na tabela 'produtos' do banco de dados.
     * Utiliza prepared statements para prevenir ataques de SQL Injection.
     *
     * @param string $nome O nome do produto.
     * @param string $descricao A descrição do produto.
     * @param float $preco O preço do produto.
     * @param int $categoria_id O ID da categoria do produto.
     * @param string|null $caminhoImagem O caminho para a imagem do produto (pode ser nulo).
     * @return bool Retorna true se a inserção for bem-sucedida, false caso contrário.
     */
    public function criar(string $nome, string $descricao, float $preco, int $categoria_id, ?string $caminhoImagem): bool
    {
        // A query SQL com placeholders (?) para os valores
        $sql = "INSERT INTO cardapio_itens (nome, descricao, preco, categoria_id, imagem_url) VALUES (?, ?, ?, ?, ?)";

        try {
            // Prepara a query para execução
            $stmt = $this->pdo->prepare($sql);
            
            // Executa a query, substituindo os placeholders pelos valores reais de forma segura
            $stmt->execute([
                $nome,
                $descricao,
                $preco,
                $categoria_id,
                $caminhoImagem
            ]);

            return true; // Retorna true se a execução foi um sucesso

        } catch (PDOException $e) {
            // Linha de debug para mostrar o erro exato do banco de dados
            die('ERRO DE BANCO DE DADOS: ' . $e->getMessage());

            // error_log($e->getMessage());
            return false;
        }
    }
}