<?php
// Em: app/Core/Router.php

namespace App\Core;

class Router
{
    /**
     * @var array A tabela de rotas da aplicação.
     */
    protected $routes = [];

    /**
     * @var array Os parâmetros da rota correspondente.
     */
    protected $params = [];

    /**
     * Construtor da classe. Aqui são definidas todas as rotas da aplicação.
     */
    public function __construct()
    {
        // Rota para a página inicial (ainda a ser criada)
        // $this->add('/', ['controller' => 'HomeController', 'action' => 'index']);

        // Rota para a página do cardápio público
        $this->add('/cardapio', ['controller' => 'CardViewController', 'action' => 'index']);
    }

    /**
     * Adiciona uma nova rota à tabela de rotas.
     *
     * @param string $route A URL da rota.
     * @param array $params Os parâmetros (controlador e ação).
     */
    public function add($route, $params = [])
    {
        // Converte a rota numa expressão regular para uma correspondência precisa
        $route = preg_replace('/\//', '\\/', $route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }

    /**
     * Verifica se o URL corresponde a uma rota na tabela.
     *
     * @param string $url O URL a ser verificado.
     * @return boolean True se encontrar uma correspondência, false caso contrário.
     */
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

    /**
     * Despacha a rota, criando o controlador e executando a ação correspondente.
     */
    public function dispatch()
    {
        // Obtém o caminho do URL, ignorando parâmetros como ?id=1
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove o nome do subdiretório do URL, se o projeto não estiver na raiz do servidor
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
    
    /**
     * Remove o subdiretório do URL se o projeto estiver numa subpasta.
     * Ex: /cardapio-digital/cardapio -> /cardapio
     */
    protected function removeSubdirectory($url)
    {
        $project_folder = basename(dirname(__DIR__, 2)); // Obtém o nome da pasta raiz, ex: "cardapio-digital"
        if (strpos($url, $project_folder) !== false) {
            return preg_replace('/^\/' . preg_quote($project_folder, '/') . '/', '', $url);
        }
        return $url;
    }
}
