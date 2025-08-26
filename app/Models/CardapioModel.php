<?php
namespace App\Models;

use Config\Database;
use PDO;
use PDOException;

class CardapioModel
{
    private $db;

    public function __construct()
    {
        
        $this->db = Database::getConnection();
    }


    public function buscarItensAgrupados(): array
    {
        $sql = "
            SELECT 
                ci.id,
                ci.nome,
                ci.descricao,
                ci.preco,
                ci.imagem_url,
                cc.nome AS categoria_nome 
            FROM 
                cardapio_itens ci
            JOIN 
                cardapio_categorias cc ON ci.categoria_id = cc.id
            WHERE 
                ci.disponivel = TRUE
            ORDER BY 
                cc.id, ci.nome ASC
        ";

        try {
            $stmt = $this->db->query($sql);
            $cardapio_itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

           
            $cardapio_agrupado = [];
            foreach ($cardapio_itens as $item) {
                $cardapio_agrupado[$item['categoria_nome']][] = $item;
            }
            
            return $cardapio_agrupado;

        } catch (PDOException $e) {
            
            error_log("Erro ao buscar o cardápio: " . $e->getMessage());
            return []; 
        }
    }
    
    public function excluirProduto(int $id): bool
{
    $sql = "DELETE FROM cardapio_itens WHERE id = ?";
    try {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    } catch (\PDOException $e) {
        error_log("Erro ao excluir produto: " . $e->getMessage());
        return false;
    }
}

public function listarTodos(): array
{
    $sql = "SELECT id, nome, descricao, preco, imagem_url FROM cardapio_itens ORDER BY id DESC";
    $stmt = $this->db->query($sql); 
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

}
