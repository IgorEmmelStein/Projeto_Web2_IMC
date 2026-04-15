<?php
include 'funcoes.php';

$conexao = conectar();

$mensagemStatus = "";
$nomeRecebido = ""; // Inicializando para evitar erro no HTML caso acesse sem POST

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomeRecebido      = $_POST['containerNome'];
    $sobrenomeRecebido = $_POST['containerSobrenome'];
    $idadeRecebida     = $_POST['containerIdade'];
    $pesoRecebido      = $_POST['containerPeso'];
    $alturaRecebida    = $_POST['containerAltura'];

    $imc = calcularIMC($pesoRecebido, $alturaRecebida);

    $query = $conexao->prepare("INSERT INTO estudantes (nome, sobrenome, idade, peso, altura, imc) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssiddd", $nomeRecebido, $sobrenomeRecebido, $idadeRecebida, $pesoRecebido, $alturaRecebida, $imc);

    if ($query->execute()) {
        $mensagemStatus = "sucesso";
    } else {
        $mensagemStatus = "erro";
        $erroDetalhe = $query->error;
    }

    $query->close();
}
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <title>Status do Cadastro</title>
</head>

<body>
    <div class="container">
        <?php if ($mensagemStatus == "sucesso"): ?>
            <h3>Usuário Inserido com sucesso!</h3>
            <p>Os dados de <?= htmlspecialchars($nomeRecebido) ?> foram registrados.</p>

            <button onclick="location.href='../html/index.html'">Voltar ao Cadastro</button>

            <button onclick="location.href='PA_Registros.php'">Visualizar Registros</button>

        <?php elseif ($mensagemStatus == "erro"): ?>
            <h3 style="color: red;">Erro ao inserir usuário!</h3>
            <p><?= $erroDetalhe ?></p>
            <button onclick="history.back()">Voltar e Tentar Novamente</button>

        <?php else: ?>
            <h3>Nenhum dado enviado.</h3>
            <button onclick="location.href='../html/index.html'">Voltar ao Cadastro</button>
        <?php endif; ?>
    </div>

    <footer>
        <p>Pesquisadores: Igor Stein e João Pierret | IFSul Venâncio Aires</p>
    </footer>
</body>

</html>