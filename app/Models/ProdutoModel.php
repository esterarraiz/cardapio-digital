<?php

namespace App\Models; 

use Config\Database; 
use PDO;
use PDOException;

class ProdutoModel
{
    private $pdo;

    public function __construct()
    {
         $this->pdo = Database::getConnection();
    }

    public function buscarPorId(int $id)
    {
        $sql = "SELECT * FROM cardapio_itens WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function criar(string $nome, string $descricao, float $preco, int $categoria_id, ?string $caminhoImagem): bool
    {
        $sql = "INSERT INTO cardapio_itens (nome, descricao, preco, categoria_id, imagem_url) VALUES (?, ?, ?, ?, ?)";

        try {
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->execute([
                $nome,
                $descricao,
                $preco,
                $categoria_id,
                $caminhoImagem
            ]);

            return true; 

        } catch (PDOException $e) {
            die('ERRO DE BANCO DE DADOS: ' . $e->getMessage());

            return false;
        }
    }
    public function atualizar(int $id, array $dados): bool
    {
        $sql = "UPDATE cardapio_itens SET 
                    nome = :nome, 
                    descricao = :descricao, 
                    preco = :preco, 
                    categoria_id = :categoria_id, 
                    imagem_url = :imagem_url 
                WHERE id = :id";
        
        try {
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':nome', $dados['nome']);
            $stmt->bindValue(':descricao', $dados['descricao']);
            $stmt->bindValue(':preco', $dados['preco']);
            $stmt->bindValue(':categoria_id', $dados['categoria_id'], PDO::PARAM_INT);
            $stmt->bindValue(':imagem_url', $dados['imagem_url']); // CRUCIAL
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao atualizar produto: " . $e->getMessage());
            return false;
        }
    }

    public function listarTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM cardapio_itens ORDER BY nome ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function excluir(int $id): bool
    {
        $sql = "DELETE FROM cardapio_itens WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}