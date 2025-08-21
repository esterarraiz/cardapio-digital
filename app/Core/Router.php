<?php
// Em: app/Core/Router.php

namespace App\Core;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function __construct()
    {
        // Rota principal da aplicação
        $this->add('/', ['controller' => 'HomeController', 'action' => 'index']);
        
        // Adicione outras rotas de exemplo se quiser
        // $this->add('/produtos', ['controller' => 'ProdutoController', 'action' => 'listar']);
    }

    public function add($route, $params = [])
    {
        $route = preg_replace('/\//', '\\/', $route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }

    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function dispatch()
    {
        // AQUI ESTÁ A CORREÇÃO:
        // Usamos parse_url para pegar o caminho da URL de forma segura,
        // o que garante que a barra "/" da página inicial seja preservada.
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // O resto do código permanece, mas agora ele recebe a URL correta.
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = "App\\Controllers\\" . $this->params['controller'];

            if (class_exists($controller)) {
                $controller_object = new $controller();
                $action = $this->params['action'];

                if (method_exists($controller_object, $action)) {
                    $controller_object->$action();
                } else {
                    echo "Action '$action' não encontrada no controller '$controller'";
                }
            } else {
                echo "Controller '$controller' não encontrado.";
            }
        } else {
            echo "Página não encontrada (Erro 404) para a URL: " . htmlspecialchars($url);
        }
    }

    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('?', $url, 2);
            $url = $parts[0];
        }
        return $url;
    }
}