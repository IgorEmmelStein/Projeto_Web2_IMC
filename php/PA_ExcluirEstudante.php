<?php
include 'dadosConexao.php'; 
include 'funcoes.php';

$excluidoComSucesso = false;
$id = 0;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    if (excluirestudante($id)) {
        $excluidoComSucesso = true;
    }
} else {
    header("Location: PA_Registros.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Excluir Estudante</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <div class="container"> 
        <?php if ($excluidoComSucesso): ?>
            <h1>Excluir Estudante</h1>
            <p>O registro do estudante (ID: <?= $id ?>) foi removido com sucesso!</p>
            <button onclick="location.href='PA_Registros.php'">Voltar</button>
        <?php else: ?>
            <h1>Erro</h1>
            <p>Não foi possível identificar o estudante pra exclusão.</p>
            <button onclick="location.href='PA_Registros.php'">Voltar</button>
        <?php endif; ?>
    </div>

    <footer>
        <p>Pesquisadores: Igor Stein e João Pierret | IFSul Venâncio Aires</p>
    </footer>
</body>
</html>