<?php
require_once __DIR__ . '/../../config/Database.php';
function getCardapioPublico(): array {
    try {
        $pdo = conectarDB();
        $stmt = $pdo->prepare("
            SELECT 
                ci.categoria_id,
                ci.nome,
                ci.descricao,
                ci.preco
            FROM cardapio_itens ci
            WHERE ci.disponivel = TRUE
            ORDER BY ci.categoria_id, ci.nome ASC
        ");
        $stmt->execute();
        $cardapio_itens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $cardapio_agrupado = [];
        foreach ($cardapio_itens as $item) {
            $categoria_nome = 'Outros';
            //1=Pratos Principais, 2=Entradas, 3=Bebidas, 4=Sobremesas
            if ($item['categoria_id'] == 1) {
                $categoria_nome = 'Pratos Principais';
            } elseif ($item['categoria_id'] == 2) {
                $categoria_nome = 'Entradas';
            } elseif ($item['categoria_id'] == 3) {
                $categoria_nome = 'Bebidas';
            } elseif ($item['categoria_id'] == 4) {
                $categoria_nome = 'Sobremesas';
            }
            
            $cardapio_agrupado[$categoria_nome][] = $item;
        }
        
        return $cardapio_agrupado;

    } catch (PDOException $e) {
        error_log("Erro ao buscar o cardápio público: " . $e->getMessage());
        return [];
    }
}
?>
