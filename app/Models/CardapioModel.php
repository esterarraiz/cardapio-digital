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
        // Pega a conexão com o banco de dados
        $this->db = Database::getConnection();
    }

    /**
     * Busca todos os itens disponíveis do cardápio e os agrupa por categoria.
     * @return array Retorna um array de categorias, cada uma contendo seus itens.
     */
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

            // Agrupa os resultados pela chave 'categoria_nome'
            $cardapio_agrupado = [];
            foreach ($cardapio_itens as $item) {
                $cardapio_agrupado[$item['categoria_nome']][] = $item;
            }
            
            return $cardapio_agrupado;

        } catch (PDOException $e) {
            // Em uma aplicação real, logar o erro é a melhor prática.
            error_log("Erro ao buscar o cardápio: " . $e->getMessage());
            return []; // Retorna um array vazio em caso de erro para não quebrar a view.
        }
    }
}
