<?php

namespace App\Controllers;

use App\Models\ProdutoModel;
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
    
    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Acesso negado. Esta rota só pode ser acessada via POST.");
        }

        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $preco = filter_var($_POST['preco'] ?? null, FILTER_VALIDATE_FLOAT);
        $categoria_id = filter_var($_POST['categoria_id'] ?? null, FILTER_VALIDATE_INT);

        if (empty($nome) || $preco === false || $categoria_id === false) {
            die("Erro de validação: Nome, preço e categoria são obrigatórios e devem ser válidos.");
        }

        $caminhoImagem = null;
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            
            $diretorioUploads = __DIR__ . '/../../public/uploads/';

            if (!is_dir($diretorioUploads)) {
                mkdir($diretorioUploads, 0777, true);
            }

            $nomeArquivo = uniqid('prod_') . '-' . basename($_FILES['imagem']['name']);
            $caminhoDestino = $diretorioUploads . $nomeArquivo;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                $caminhoImagem = '/uploads/' . $nomeArquivo;
            } else {
                die("Falha ao salvar a imagem no servidor.");
            }
        }

        $produtoModel = new \App\Models\ProdutoModel();
        $sucesso = $produtoModel->criar(
            $nome,
            $descricao,
            $preco,
            $categoria_id,
            $caminhoImagem
        );

        if ($sucesso) {
            header('Location: /produtos?status=sucesso');
        } else {
            header('Location: /produtos/criar?status=erro');
        }
        exit;
    }

    public function editar($id)
    {
        $produtoModel = new ProdutoModel();
        $produto = $produtoModel->buscarPorId((int)$id);

        if (!$produto) {
            header('Location: /produtos/listar');
            exit;
        }

        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->listarTodas();

        $this->view('produtos/editar', [
            'produto' => $produto,
            'categorias' => $categorias
        ]);
    }

    public function atualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die("Acesso negado.");
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            die("Erro de validação: ID do produto é inválido.");
        }

        $produtoModel = new ProdutoModel();
        $produtoAtual = $produtoModel->buscarPorId($id);

        if (!$produtoAtual) {
            die("Produto não encontrado para o ID fornecido.");
        }

        $caminhoImagem = $produtoAtual['imagem_url'] ?? null;

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            
            $diretorioUploads = __DIR__ . '/../../public/uploads/';
            $nomeArquivo = uniqid('prod_') . '-' . basename($_FILES['imagem']['name']);
            $caminhoDestino = $diretorioUploads . $nomeArquivo;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                if ($caminhoImagem && file_exists(__DIR__ . '/../../public' . $caminhoImagem)) {
                    unlink(__DIR__ . '/../../public' . $caminhoImagem);
                }
                $caminhoImagem = '/uploads/' . $nomeArquivo;
            } else {
                header('Location: /produtos/editar/' . $id . '?status=erro_upload');
                exit;
            }
        }

        $dados = [
            'nome' => trim($_POST['nome'] ?? ''),
            'descricao' => trim($_POST['descricao'] ?? ''),
            'preco' => filter_var(str_replace(',', '.', $_POST['preco'] ?? '0'), FILTER_VALIDATE_FLOAT),
            'categoria_id' => filter_input(INPUT_POST, 'categoria_id', FILTER_VALIDATE_INT),
            'imagem_url' => $caminhoImagem
        ];

        $sucesso = $produtoModel->atualizar($id, $dados);

        if ($sucesso) {
            header('Location: /produtos?status=atualizado');
        } else {
            header('Location: /produtos/editar/' . $id . '?status=erro');
        }
        exit;
    }

    public function excluir($id)
    {
        $produtoModel = new ProdutoModel();
        $sucesso = $produtoModel->excluir((int)$id);

        if ($sucesso) {
            header('Location: /produtos?status=excluido');
        } else {
            header('Location: /produtos?status=erro');
        }
        exit;
    }

    public function listar()
    {
        $produtoModel = new ProdutoModel();
        $produtos = $produtoModel->listarTodos();
        $this->view('produtos/listar', ['produtos' => $produtos]);
    }
}