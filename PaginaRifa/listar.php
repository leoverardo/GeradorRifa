<?php
$rifas = [];

if (file_exists('rifas.json')) {
    $json = file_get_contents('rifas.json');
    $rifas = json_decode($json, true);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Rifas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <img src="maxresdefault-removebg-preview.png" class="tiger_logo" alt="Logo">
        <h1>Rifas Cadastradas</h1>
    </header>
    <main>
        <?php if (!empty($rifas)): ?>
            <div class="bilhetes-lista">
                <?php foreach ($rifas as $rifa): ?>
                    <div class="bilhete">
                        <div class="bilhete-header"><?= htmlspecialchars($rifa['campanha']) ?></div>
                        <div class="bilhete-numero"><?= str_pad($rifa['numero'], 3, '0', STR_PAD_LEFT) ?></div>
                        <div class="bilhete-premio">Prêmio: <?= htmlspecialchars($rifa['premio']) ?></div>
                        <?php if (!empty($rifa['imagem'])): ?>
                            <div class="bilhete-imagem">
                                <img src="<?= htmlspecialchars($rifa['imagem']) ?>" alt="Prêmio">
                            </div>
                        <?php endif; ?>
                        <div class="bilhete-valor">Valor: R$ <?= number_format($rifa['valor'], 2, ',', '.') ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align: center;">Nenhuma rifa cadastrada ainda.</p>
        <?php endif; ?>
        <button class="btn-voltar"><a href="index.php">Voltar</a></button>
    </main>
</body>
</html>
