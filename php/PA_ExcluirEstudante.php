<?php
include 'funcoes.php';

$conexao = conectar(); //
$excluidoComSucesso = false;

// 1. Verifica se o ID foi enviado pela URL (via GET)
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // 2. Tenta excluir o estudante usando a tua função existente
    // Nota: Tua função 'excluirestudante' já faz o delete e o log
    excluirestudante($id);
    $excluidoComSucesso = true;
} else {
    // Se tentarem acessar a página sem um ID, volta para a lista
    header("Location: PA_Registros.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Estudante</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <div class="container"> <?php if ($excluidoComSucesso): ?>
            <h1>Excluir Estudante</h1>
            <p>O registro do estudante (ID: <?= $id ?>) foi removido com sucesso!</p>
            <button onclick="location.href='PA_Registros.php'">Voltar</button>
        <?php else: ?>
            <h1>Erro</h1>
            <p>Não foi possível identificar o estudante para exclusão.</p>
            <button onclick="location.href='PA_Registros.php'">Voltar</button>
        <?php endif; ?>
    </div>

    <footer>
        <p>Pesquisadores: Igor Stein e João Pierret | IFSul Venâncio Aires</p>
    </footer>
</body>

</html>