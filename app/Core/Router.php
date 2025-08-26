<?php

namespace App\Core;

class Router
{
    protected $routes = [];

    protected $params = [];

    public function __construct()
    {

        $this->add('/cardapio', ['controller' => 'CardViewController', 'action' => 'index']);
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
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        $url = $this->removeSubdirectory($url);

        if ($this->match($url)) {
            $controller = "App\\Controllers\\" . $this->params['controller'];

            if (class_exists($controller)) {
                $controller_object = new $controller();
                $action = $this->params['action'];

                if (is_callable([$controller_object, $action])) {
                    $controller_object->$action();
                } else {
                    echo "Ação '{$action}' não encontrada no controlador '{$controller}'";
                }
            } else {
                echo "Controlador '{$controller}' não encontrado.";
            }
        } else {
            echo "Página não encontrada (Erro 404) para o URL: " . htmlspecialchars($url);
        }
    }
    

    protected function removeSubdirectory($url)
    {
        $project_folder = basename(dirname(__DIR__, 2)); 
        if (strpos($url, $project_folder) !== false) {
            return preg_replace('/^\/' . preg_quote($project_folder, '/') . '/', '', $url);
        }
        return $url;
    }
}
