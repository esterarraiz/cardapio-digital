<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento do Cardápio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .header-actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .btn-add {
            background-color: #6A11CB;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s;
        }

        .btn-add:hover {
            background-color: #480a8a;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }

        .card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 15px;
        }

        .card-details {
            flex: 1;
        }

        .card-details h2 {
            margin: 0 0 5px;
            font-size: 18px;
            color: #222;
        }

        .card-details p {
            margin: 0;
            color: #555;
        }

        .price {
            font-weight: 700;
            color: #1e88e5;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            padding: 5px 12px;
            font-size: 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-edit {
            background-color: #e2e8f0;
            color: #1e293b;
        }

        .btn-edit:hover {
            background-color: #cbd5e1;
        }

        .btn-delete {
            background-color: #f8d7da;
            color: #721c24;
        }

        .btn-delete:hover {
            background-color: #f1b0b7;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Produtos Cadastrados</h1>
    <div class="header-actions">
        <a href="/produtos/criar" class="btn-add">+ Adicionar Produto</a>
    </div>
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'sucesso'): ?>
            <div class="alert-success">✅ Produto salvo com sucesso!</div>
        <?php elseif ($_GET['status'] === 'excluido'): ?>
            <div class="alert-success">✅ Produto excluído com sucesso!</div>
        <?php elseif ($_GET['status'] === 'atualizado'): ?>
            <div class="alert-success">✅ Produto atualizado com sucesso!</div>
        <?php elseif ($_GET['status'] === 'erro'): ?>
            <div class="alert-error">❌ Ocorreu um erro ao tentar excluir o produto.</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($produtos)): ?>
        <?php foreach ($produtos as $produto): ?>
            <div class="card">
                <?php if(!empty($produto['imagem_url'])): ?>
                    <img src="<?= htmlspecialchars($produto['imagem_url']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                <?php else: ?>
                    <img src="/img/placeholder.png" alt="Sem imagem">
                <?php endif; ?>
                <div class="card-details">
                    <h2><?= htmlspecialchars($produto['nome']) ?></h2>
                    <p><?= htmlspecialchars($produto['descricao']) ?></p>
                    <p class="price">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                    <div class="card-actions">
                        <a class="btn btn-edit" href="/produtos/editar/<?= $produto['id'] ?>">Editar</a>
                        <a class="btn btn-delete" href="/produtos/excluir/<?= $produto['id'] ?>" 
                           onclick="return confirm('Tem certeza que deseja excluir este item?');">Excluir</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum produto cadastrado ainda.</p>
    <?php endif; ?>
</div>
</body>
</html>
