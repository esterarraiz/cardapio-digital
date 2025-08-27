<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Novo Produto</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/criar.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Novo Produto</h1>
        <form action="/produtos/salvar" method="POST" enctype="multipart/form-data">
            
            <label for="nome">Nome do Produto</label>
            <input type="text" id="nome" name="nome" placeholder="Ex: X-Burger Duplo" required>

            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" rows="4" placeholder="Ingredientes, tamanho, etc."></textarea>

            <label for="preco">Preço</label>
            <input type="number" id="preco" name="preco" step="0.01" placeholder="Ex: 25.50" required>

            <label for="categoria_id">Categoria</label>
            <select name="categoria_id" id="categoria_id" required>
                <option value="" disabled selected>Selecione uma categoria</option>
                <?php foreach ($data['categorias'] as $categoria): ?>
                    <option value="<?= $categoria['id'] ?>">
                        <?= htmlspecialchars($categoria['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <div class="input-file-wrapper">
                <label for="imagem">Imagem do Produto</label>
                <label for="imagem" class="input-file-label">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    <span class="file-name">Escolha um arquivo...</span>
                </label>
                <input type="file" id="imagem" name="imagem" accept="image/png, image/jpeg, image/webp">
            </div>

            <button type="submit">Salvar Produto</button>
            <a href="/produtos" class="cancelar">Cancelar</a>
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
                fileNameSpan.textContent = 'Escolha um arquivo...';
            }
        });
    </script>
</body>
</html>