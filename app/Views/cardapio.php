<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosso Cardápio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --brand-orange: #f97316;
            --brand-green: #22c55e;
            --neutral-dark: #334155;
            --neutral-lightest: #f8fafc;
        }
        .text-brand-orange { color: var(--brand-orange); }
        .text-brand-green { color: var(--brand-green); }
        .bg-brand-orange { background-color: var(--brand-orange); }
        .bg-neutral-dark { background-color: var(--brand-orange); }
    </style>
</head>
<body class="bg-neutral-lightest font-sans">

    <div class="container mx-auto p-4 sm:p-6 md:p-8 max-w-4xl">
        <header class="text-center mb-8">
            <h1 class="text-5xl font-bold text-neutral-dark mt-4">Cardápio:</h1>
        </header>

        

        <main class="space-y-8">

           
            <?php if (isset($_GET['status'])): ?>
                <?php if ($_GET['status'] === 'sucesso'): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4" role="alert">
                        Produto salvo com sucesso!
                    </div>
                <?php elseif ($_GET['status'] === 'excluido'): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4" role="alert">
                        Produto excluído com sucesso!
                    </div>
                <?php elseif ($_GET['status'] === 'erro'): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4" role="alert">
                        Ocorreu um erro ao tentar processar a ação.
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($erro_mensagem)): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                    <p class="font-bold">Ocorreu um Erro</p>
                    <p><?php echo htmlspecialchars($erro_mensagem); ?></p>
                </div>
            <?php elseif (empty($cardapio_agrupado)): ?>
                <div class="bg-white p-6 rounded-xl shadow-md text-center">
                    <p class="text-neutral-medium">O nosso cardápio está a ser atualizado. Volte em breve!</p>
                </div>
            <?php else: ?>
                <?php foreach ($cardapio_agrupado as $categoria => $itens): ?>
                    <section>
                        <h2 class="text-2xl font-bold text-brand-orange border-b-2 border-brand-green pb-2 mb-4">
                            <?php echo htmlspecialchars($categoria); ?>
                        </h2>
                        <div class="space-y-4">
                            <?php foreach ($itens as $item): ?>
                                <div class="bg-white p-4 rounded-lg shadow-sm flex items-start space-x-4">
                                    <img src="<?php echo htmlspecialchars($item['imagem_url'] ?? 'https://placehold.co/100x100/cccccc/ffffff?text=Item'); ?>" 
                                         alt="<?php echo htmlspecialchars($item['nome']); ?>" 
                                         class="w-20 h-20 object-cover rounded-md flex-shrink-0">
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-baseline">
                                            <h3 class="font-bold text-lg text-neutral-dark"><?php echo htmlspecialchars($item['nome']); ?></h3>
                                            <p class="font-semibold text-brand-green flex-shrink-0 ml-4">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
                                        </div>
                                        <?php if (!empty($item['descricao'])): ?>
                                            <p class="text-neutral-medium text-sm mt-1"><?php echo htmlspecialchars($item['descricao']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            <?php endif; ?>

        </main>
    </div>
    <a href="/produtos" 
       title="Gerenciar Cardápio"
       class="fixed bottom-6 right-6 bg-neutral-dark text-white p-3 rounded-full shadow-lg hover:bg-neutral-dark/80 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
            <circle cx="12" cy="12" r="3"></circle>
            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
        </svg>
    </a>
</body>
</html>
