<?php
include 'funcoes.php';

$conexao = conectar();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$comandoSQL = "SELECT * FROM estudantes WHERE idestudante = $id";
$resultado = mysqli_query($conexao, $comandoSQL);
$dados = mysqli_fetch_array($resultado);

if (!$dados) {
    echo "<script>alert('Estudante não encontrado!'); window.location.href='PA_Visualizar.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Estudante</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>  
    <div class="container">
        <h1>Alterar Dados</h1>
        <form action="PA_ProcessaAlteracao.php" method="post">
            <input type="hidden" name="id_estudante" value="<?= $dados['idestudante'] ?>">

            <label>Nome: </label>
            <input type="text" name="containerNome" value="<?= $dados['nome'] ?>">
            <br>
            <label>Sobrenome:</label>
            <input type="text" name="containerSobrenome" value="<?= $dados['sobrenome'] ?>">
            <br>
            <label>Idade:</label>
            <input type="number" name="containerIdade" value="<?= $dados['idade'] ?>">
            <br>
            <label>Peso:</label>
            <input type="number" name="containerPeso" step="0.01" value="<?= $dados['peso'] ?>">
            <br>
            <label>Altura:</label>
            <input type="number" name="containerAltura" step="0.01" value="<?= $dados['altura'] ?>">
            <br>
            <button type="submit">Salvar Alterações</button>
        </form>
        <br>
        <button class="btn-voltar" onclick="location.href='PA_Visualizar.php'">Cancelar</button>
    </div>
</body>
</html>