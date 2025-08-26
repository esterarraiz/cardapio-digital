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
    
    /**
     * Valida os dados recebidos do formulário via POST, processa o upload da imagem,
     * e chama o Model para salvar o novo produto no banco de dados.
     */
    public function salvar()
    {
        // 1. VERIFICAR SE O MÉTODO DA REQUISIÇÃO É POST
        // Garante que a lógica só seja executada ao enviar o formulário.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Código para "Método não permitido"
            die("Acesso negado. Esta rota só pode ser acessada via POST.");
        }


        // 2. OBTER E VALIDAR OS DADOS DO FORMULÁRIO
        // Funções como trim() e filter_var() limpam e validam os dados.
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $preco = filter_var($_POST['preco'] ?? null, FILTER_VALIDATE_FLOAT);
        $categoria_id = filter_var($_POST['categoria_id'] ?? null, FILTER_VALIDATE_INT);

        // Validação para garantir que os campos obrigatórios não estão vazios ou inválidos.
        if (empty($nome) || $preco === false || $categoria_id === false) {
            // Em uma aplicação real, redirecionar com uma mensagem de erro é o ideal.
            die("Erro de validação: Nome, preço e categoria são obrigatórios e devem ser válidos.");
        }

        // 3. PROCESSAR O UPLOAD DA IMAGEM
        $caminhoImagem = null; // Valor padrão caso nenhuma imagem seja enviada.
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            
            $diretorioUploads = __DIR__ . '/../../public/uploads/';

            // Cria o diretório se ele não existir.
            if (!is_dir($diretorioUploads)) {
                mkdir($diretorioUploads, 0777, true);
            }

            // Gera um nome de arquivo único para evitar conflitos.
            $nomeArquivo = uniqid('prod_') . '-' . basename($_FILES['imagem']['name']);
            $caminhoDestino = $diretorioUploads . $nomeArquivo;

            // Move o arquivo para o destino final de forma segura.
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                $caminhoImagem = '/uploads/' . $nomeArquivo; // Salva o caminho relativo no banco.
            } else {
                die("Falha ao salvar a imagem no servidor.");
            }
        }

        // 4. INSTANCIAR O MODEL E SALVAR OS DADOS
        $produtoModel = new \App\Models\ProdutoModel();

        $sucesso = $produtoModel->criar(
            $nome,
            $descricao,
            $preco,
            $categoria_id,
            $caminhoImagem
        );

        // 5. REDIRECIONAR O USUÁRIO (PADRÃO POST-REDIRECT-GET)
        // Isso evita que o formulário seja reenviado se o usuário atualizar a página.
        if ($sucesso) {
            header('Location: /produtos?status=sucesso');
        } else {
            header('Location: /produtos/criar?status=erro');
        }
        exit; // Encerra o script para garantir o redirecionamento.
    }
    


    public function excluir($id)
    {
        $cardapioModel = new CardapioModel();
        $sucesso = $cardapioModel->excluirProduto((int)$id); 

        if ($sucesso) {
            header('Location: /produtos?status=excluido');
        } else {
            header('Location: /produtos?status=erro');
        }
        exit;
    }

    public function listar()
    {
        $cardapioModel = new CardapioModel();
        $produtos = $cardapioModel->listarTodos(); 
        $this->view('produtos/listar', ['produtos' => $produtos]);
    }
}

