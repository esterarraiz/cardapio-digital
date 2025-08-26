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
    </style>
</head>
<body class="bg-neutral-lightest font-sans">

    <div class="container mx-auto p-4 sm:p-6 md:p-8 max-w-4xl">
        <header class="text-center mb-8">
            <h1 class="text-5xl font-bold text-neutral-dark mt-4">Nosso Cardápio</h1>
        </header>
        <div class="mb-6 text-right">
            <a href="/produtos/criar" 
               class="inline-block bg-brand-orange text-white font-bold py-2 px-5 rounded-lg hover:bg-orange-600 transition-colors shadow-sm">
                + Adicionar Novo Produto
            </a>
        </div>

        <main class="space-y-8">
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
                                        <div class="mt-4 flex items-center space-x-2">
                                            <a href="/produtos/editar/<?php echo $item['id']; ?>" 
                                            class="text-xs font-semibold bg-slate-200 text-slate-700 hover:bg-slate-300 rounded-md py-1 px-3 transition-colors">
                                                Editar
                                            </a>
                                            <a href="/produtos/excluir/<?php echo $item['id']; ?>" 
                                            class="text-xs font-semibold bg-red-100 text-red-700 hover:bg-red-200 rounded-md py-1 px-3 transition-colors" 
                                            onclick="return confirm('Tem certeza que deseja excluir este item?');">
                                                Excluir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
