<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\CardapioModel; 

class CardViewController extends Controller 
{
    public function index()
    {
        $erro_mensagem = null;
        $cardapio_agrupado = [];

        try {
            $cardapioModel = new CardapioModel();

            $cardapio_agrupado = $cardapioModel->buscarItensAgrupados();

        } catch (\Exception $e) {
            error_log("Erro no CardViewController: " . $e->getMessage());
            $erro_mensagem = "Não foi possível carregar o cardápio neste momento. Por favor, tente novamente mais tarde.";
        }

        $this->view('cardapio', [
            'cardapio_agrupado' => $cardapio_agrupado,
            'erro_mensagem' => $erro_mensagem
        ]);
    }
}
