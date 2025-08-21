<?php
// Em: app/Core/Controller.php

namespace App\Core; // <-- ESSA LINHA É CRUCIAL

/**
 * Controller Base
 * Todos os outros controllers estenderão esta classe.
 */
class Controller // <-- E O NOME DA CLASSE TAMBÉM
{
    /**
     * Renderiza um arquivo de view.
     */
    public function view($view, $data = [])
    {
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (file_exists($viewFile)) {
            extract($data);
            require_once $viewFile;
        } else {
            die("View não encontrada: " . $viewFile);
        }
    }
}