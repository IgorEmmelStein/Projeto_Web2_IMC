<?php
include 'dadosConexao.php';
include 'funcoes.php';

$estudante = null;

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $sql = "SELECT * FROM estudantes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $estudante = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$estudante) {
    echo "Estudante não encontrado!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Estudante</title>
    <link rel="stylesheet" href="../css/index.css"> 
</head>
<body>
    <div class="container">
        <h1>Alterar Dados do Estudante</h1>
        <form action="PA_ProcessaAlteracao.php" method="POST">
            <input type="hidden" name="id" value="<?= $estudante['id'] ?>">
            
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= $estudante['nome'] ?>" required>
            
            <label>Peso (kg):</label>
            <input type="number" step="0.01" name="peso" value="<?= $estudante['peso'] ?>" required>
            
            <label>Altura (m):</label>
            <input type="number" step="0.01" name="altura" value="<?= $estudante['altura'] ?>" required>
            
            <button type="submit">Salvar Alterações</button>
            <button type="button" onclick="location.href='PA_Registros.php'">Cancelar</button>
        </form>
    </div>
</body>
</html>