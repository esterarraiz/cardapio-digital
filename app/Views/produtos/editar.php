<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/criar.css">
</head>
<body>
    <div class="container">
        <h1>Editar Produto</h1>

        <form action="/produtos/atualizar" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="id" value="<?= htmlspecialchars($data['produto']['id']) ?>">

            <label for="nome">Nome do Produto</label>
            <input type="text" id="nome" name="nome" placeholder="Ex: X-Burger Duplo" required 
                   value="<?= htmlspecialchars($data['produto']['nome']) ?>">

            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" rows="4" placeholder="Ingredientes, tamanho, etc."><?= htmlspecialchars($data['produto']['descricao']) ?></textarea>

            <label for="preco">Preço</label>
            <input type="number" id="preco" name="preco" step="0.01" placeholder="Ex: 25.50" required
                   value="<?= htmlspecialchars($data['produto']['preco']) ?>">

            <label for="categoria_id">Categoria</label>
            <select name="categoria_id" id="categoria_id" required>
                <option value="" disabled>Selecione uma categoria</option>
                <?php foreach ($data['categorias'] as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>" <?= ($categoria['id'] == $data['produto']['categoria_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($categoria['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <div class="imagem-atual">
                <label>Imagem Atual</label>
                <?php if (!empty($data['produto']['imagem_url'])): ?>
                    <img src="<?= htmlspecialchars($data['produto']['imagem_url']) ?>" alt="Imagem atual de <?= htmlspecialchars($data['produto']['nome']) ?>" width="100">
                <?php else: ?>
                    <p>Nenhuma imagem cadastrada.</p>
                <?php endif; ?>
            </div>

            <div class="input-file-wrapper">
                <label for="imagem">Substituir Imagem (opcional)</label>
                <label for="imagem" class="input-file-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    <span class="file-name">Escolha um novo arquivo...</span>
                </label>
                <input type="file" id="imagem" name="imagem" accept="image/png, image/jpeg, image/webp">
            </div>

            <button type="submit">Salvar Alterações</button>
            <a href="/produtos/listar" class="cancelar">Cancelar</a>
        </form>
    </div>

    <script>
        const inputFile = document.getElementById('imagem');
        const fileNameSpan = document.querySelector('.file-name');
        
        inputFile.addEventListener('change', function(event) {
            const files = event.target.files;
            if (files.length > 0) {
                fileNameSpan.textContent = files[0].name;
            } else {
                fileNameSpan.textContent = 'Escolha um novo arquivo...';
            }
        });
    </script>

    <style>
        .imagem-atual {
            margin-bottom: 1.2rem;
        }
        .imagem-atual img {
            border-radius: 8px;
            border: 1px solid var(--cor-borda);
            margin-top: 0.5rem;
        }
        .imagem-atual p {
            font-size: 0.9rem;
            color: #667085;
        }
    </style>
</body>
</html>