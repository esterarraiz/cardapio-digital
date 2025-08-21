<?php
// Em: app/Controllers/HomeController.php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    /**
     * Carrega a página inicial.
     */
    public function index()
    {
        $data = [
            'title' => 'Olá, Time! 🚀',
            'description' => 'Sejam muito bem-vindos ao projeto Cardápio Digital. A base está pronta para começarmos a desenvolver!'
        ];
        
        // O método 'view' está no Controller base (app/Core/Controller.php)
        $this->view('home/index', $data);
    }
}