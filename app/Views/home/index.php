<?php
// Em: app/Views/home/index.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio Digital - Início</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f8; color: #2d3748; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { text-align: center; background-color: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        h1 { font-size: 2.5em; color: #2c5282; }
        p { font-size: 1.2em; color: #4a5568; }
        code { background-color: #edf2f7; padding: 2px 6px; border-radius: 4px; font-family: "Courier New", Courier, monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 <?= htmlspecialchars($data['title']); ?></h1>
        <p><?= htmlspecialchars($data['description']); ?></p>
        <hr>
        <p>Próximos passos: criar a rota, o controller e a view para a sua primeira feature!</p>
        <p>O arquivo para esta página é: <code>app/Views/home/index.php</code></p>
    </div>
</body>
</html>