<?php

namespace App\Controllers;

use Config\Database;

class CardViewController
{
    public function index()
    {
        $cardapio_agrupado = [];
        $erro_mensagem = null;

        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("
                SELECT 
                    cc.nome AS categoria_nome,
                    ci.nome,
                    ci.descricao,
                    ci.preco,
                    ci.imagem_url 
                FROM cardapio_itens ci
                JOIN cardapio_categorias cc ON ci.categoria_id = cc.id
                WHERE ci.disponivel = TRUE
                ORDER BY cc.id, ci.nome ASC
            ");
            $stmt->execute();
            $cardapio_itens = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($cardapio_itens as $item) {
                $cardapio_agrupado[$item['categoria_nome']][] = $item;
            }

        } catch (\PDOException $e) {
            error_log("Erro ao buscar o cardápio público: " . $e->getMessage());
            $erro_mensagem = "Não foi possível carregar o cardápio neste momento. Por favor, tente novamente mais tarde.";
        }

        require_once __DIR__ . '/../Views/cardapio.php';
    }
}
