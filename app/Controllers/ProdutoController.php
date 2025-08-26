<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\CategoriaModel;
use App\Models\CardapioModel;

class ProdutoController extends Controller
{
    public function criar()
    {
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->listarTodas();

        $this->view('produtos/criar', ['categorias' => $categorias]);
    }

    public function excluir($id)
    {
        $cardapioModel = new CardapioModel();
        $sucesso = $cardapioModel->excluirProduto((int)$id); 

        if ($sucesso) {
            header('Location: /produtos/listar?status=excluido');
        } else {
            header('Location: /produtos/listar?status=erro');
        }
        exit;
    }

    public function listar()
    {
        $cardapioModel = new CardapioModel();
        $produtos = $cardapioModel->listarTodos(); 
        $this->view('produtos/listar', ['produtos' => $produtos]);
    }
}
