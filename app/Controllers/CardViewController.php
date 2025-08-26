<?php
// Em: app/Controllers/CardViewController.php

namespace App\Controllers;

// Importa a sua classe de base de dados para ser usada aqui.
use Config\Database;

class CardViewController
{
    /**
     * Ação principal (index): Busca os dados do cardápio e exibe a view.
     */
    public function index()
    {
        // Inicializa as variáveis que serão passadas para a view.
        $cardapio_agrupado = [];
        $erro_mensagem = null;

        try {
            // Usa o método estático connect() da sua classe Database para obter a conexão.
            $pdo = Database::connect();

            // CONSULTA ATUALIZADA: Agora busca também a coluna 'imagem_url'.
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

            // Agrupa os itens por categoria.
            foreach ($cardapio_itens as $item) {
                $cardapio_agrupado[$item['categoria_nome']][] = $item;
            }

        } catch (\PDOException $e) {
            error_log("Erro ao buscar o cardápio público: " . $e->getMessage());
            $erro_mensagem = "Não foi possível carregar o cardápio neste momento. Por favor, tente novamente mais tarde.";
        }

        // O passo final do controlador: carregar o ficheiro da view.
        require_once __DIR__ . '/../Views/cardapio.php';
    }
}
