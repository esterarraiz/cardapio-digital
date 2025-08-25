<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CategoriaModel;
use App\Models\ProdutoModel; // Adicione esta linha para poder usar o ProdutoModel

class ProdutoController extends Controller
{
    /**
     * Método para EXIBIR o formulário de criação de produto.
     * Ele busca as categorias para preencher o campo <select>.
     */
    public function criar()
    {
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->listarTodas();

        // O array de dados é passado como segundo argumento do método view
        $this->view('produtos/criar', ['categorias' => $categorias]);
    }

    /**
     * Método para SALVAR os dados do formulário no banco de dados.
     * Este método será chamado pela rota POST /produtos/salvar.
     */
    public function salvar()
    {
        // 1. VERIFICAR SE O MÉTODO DA REQUISIÇÃO É POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo "Método não permitido.";
            exit;
        }

        // 2. OBTER E VALIDAR OS DADOS DO FORMULÁRIO
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $preco = filter_var($_POST['preco'], FILTER_VALIDATE_FLOAT);
        $categoria_id = filter_var($_POST['categoria_id'], FILTER_VALIDATE_INT);

        if (empty($nome) || $preco === false || $categoria_id === false) {
            // Em uma aplicação real, redirecione com uma mensagem de erro na sessão
            die("Erro: Nome, preço e categoria são obrigatórios e devem ser válidos.");
        }

        // 3. PROCESSAR O UPLOAD DA IMAGEM
        $caminhoImagem = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $diretorioUploads = __DIR__ . '/../../public/uploads/';

            if (!is_dir($diretorioUploads)) {
                mkdir($diretorioUploads, 0777, true);
            }

            $nomeArquivo = uniqid('prod_') . '_' . basename($_FILES['imagem']['name']);
            $caminhoCompleto = $diretorioUploads . $nomeArquivo;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
                $caminhoImagem = '/uploads/' . $nomeArquivo;
            } else {
                die("Erro ao salvar a imagem.");
            }
        }

        // 4. USAR O PRODUTOMODEL PARA SALVAR NO BANCO
        $produtoModel = new ProdutoModel();
        $sucesso = $produtoModel->criar($nome, $descricao, $preco, $categoria_id, $caminhoImagem);

        // 5. REDIRECIONAR O USUÁRIO
        if ($sucesso) {
            header('Location: /produtos?status=sucesso');
        } else {
            header('Location: /produtos/criar?status=erro');
        }
        exit;
    }
}