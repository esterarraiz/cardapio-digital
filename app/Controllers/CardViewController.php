<?php
namespace App\Controllers;

use App\Core\Controller;     // Importa e estende o Controller base
use App\Models\CardapioModel; // Importa o novo Model

class CardViewController extends Controller // A classe agora estende o Controller
{
    public function index()
    {
        $erro_mensagem = null;
        $cardapio_agrupado = [];

        try {
            // 1. Instancia o Model
            $cardapioModel = new CardapioModel();

            // 2. Chama o método do Model para buscar os dados. Toda a lógica SQL está lá.
            $cardapio_agrupado = $cardapioModel->buscarItensAgrupados();

        } catch (\Exception $e) {
            // Captura qualquer erro inesperado durante o processo
            error_log("Erro no CardViewController: " . $e->getMessage());
            $erro_mensagem = "Não foi possível carregar o cardápio neste momento. Por favor, tente novamente mais tarde.";
        }

        // 3. Chama o método view() (herdado do Controller base) e passa os dados
        $this->view('cardapio', [
            'cardapio_agrupado' => $cardapio_agrupado,
            'erro_mensagem' => $erro_mensagem
        ]);
    }
}
