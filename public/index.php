<?php
// Em: public/index.php

/**
 * Ponto de Entrada da Aplicação (Front Controller)
 *
 * Todas as requisições para a aplicação são direcionadas para este ficheiro.
 * Ele é responsável por inicializar o sistema e despachar a rota correta.
 */

// 1. Carrega o autoloader do Composer.
// Isto permite que as classes (como o Router e os Controladores) sejam carregadas automaticamente.
require_once __DIR__ . '/../vendor/autoload.php';

// 2. Cria uma nova instância do Roteador.
// O construtor do Router já regista todas as rotas da aplicação.
$router = new App\Core\Router();

// 3. Despacha o URL.
// O método dispatch() irá encontrar o controlador e a ação correspondentes ao URL
// e executá-los.
$router->dispatch();
