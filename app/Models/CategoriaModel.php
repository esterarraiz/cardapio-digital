<?php


namespace App\Models;

use Config\Database;
use PDO;

class CategoriaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function listarTodas()
    {
        try {
            $query = $this->db->query("SELECT id, nome FROM cardapio_categorias ORDER BY nome ASC");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            return [];
        }
    }
}