<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Rifa Fortune Tiger</title>
</head>
<body>
    <header>
        <h1>Rifa Fortune Tiger</h1>
    </header>
    <main>
        <h1>Escolha uma rifa para comprar:</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 0;
            $campanha = htmlspecialchars($_POST['campanha'] ?? '');
            $premio = htmlspecialchars($_POST['premio'] ?? '');
            $valor = htmlspecialchars($_POST['valor'] ?? '');
            $imagemPath = '';

            if (!empty($_FILES['imagem']['name'])) {
                $nomeImagem = basename($_FILES['imagem']['name']);
                $imagemPath = 'uploads/' . $nomeImagem;
                move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath);
            }

            if ($quantidade > 0 && $campanha && $premio && $valor) {
                $rifasSalvas = file_exists('rifas.json') ? json_decode(file_get_contents('rifas.json'), true) : [];

                echo "<div class='info-campanha'>";
                echo "<h2>Campanha: <span>$campanha</span></h2>";
                echo "<p><strong>Prêmio:</strong> $premio</p>";
                echo "<p><strong>Valor do Bilhete:</strong> R$ $valor</p>";
                echo "</div>";

                echo "<div class='bilhetes-lista'>";
                for ($i = 1; $i <= $quantidade; $i++) {
                    $num = str_pad($i, 3, "0", STR_PAD_LEFT);

                    echo "<div class='bilhete'>";
                    echo "<div class='bilhete-header'>$campanha</div>";
                    echo "<div class='bilhete-numero'>$num</div>";
                    echo "<div class='bilhete-premio'>Prêmio: $premio</div>";
                    if ($imagemPath) {
                        echo "<div class='bilhete-imagem'><img src='$imagemPath' alt='Imagem do Prêmio'></div>";
                    }
                    echo "<div class='bilhete-valor'>Valor: R$ $valor</div>";
                    echo "</div>";

                    $rifasSalvas[] = [
                        'campanha' => $campanha,
                        'premio' => $premio,
                        'valor' => $valor,
                        'numero' => $i,
                        'imagem' => $imagemPath
                    ];
                }
                echo "</div>";
                echo "<button class='btn-imprimir' onclick='window.print()'>Imprimir Bilhetes</button>";

                file_put_contents('rifas.json', json_encode($rifasSalvas, JSON_PRETTY_PRINT));
            } else {
                echo "<p style='color:red;'>Preencha todos os campos corretamente.</p>";
            }
        } else {
        ?>
            <form method="post" enctype="multipart/form-data" class="gerar-bilhetes-form">
                <label for="campanha">Nome da Campanha / Título da Rifa:</label>
                <input type="text" id="campanha" name="campanha" required>

                <label for="premio">Nome do(s) Prêmio(s):</label>
                <input type="text" id="premio" name="premio" required>

                <label for="valor">Valor do Bilhete (R$):</label>
                <input type="number" step="0.01" id="valor" name="valor" required>

                <label for="quantidade">Quantidade de Bilhetes a Gerar:</label>
                <input type="number" id="quantidade" name="quantidade" min="1" required>

                <label for="imagem">Imagem do Prêmio (opcional):</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">

                <button type="submit">Gerar Bilhetes</button>
            </form>
        <?php
        }
        ?>
        <button class="btn-voltar"><a href="index.php">Voltar</a></button>
    </main>
    <footer>
        <p>&copy; 2025 Fortune Tiger. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
