<?php
// Em: app/Controllers/ProdutoController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CategoriaModel;

class ProdutoController extends Controller
{
    public function criar()
    {
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->listarTodas();

        $this->view('produtos/criar', ['categorias' => $categorias]);
    }

}