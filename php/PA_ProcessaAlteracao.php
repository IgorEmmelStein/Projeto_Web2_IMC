<?php
include 'dadosConexao.php';
include 'funcoes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $nome = $_POST['nome'];
    $peso = (float)$_POST['peso'];
    $altura = (float)$_POST['altura'];

    try {
        $sql = "UPDATE estudantes SET nome = :nome, peso = :peso, altura = :altura WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':peso', $peso);
        $stmt->bindValue(':altura', $altura);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: PA_Registros.php?status=sucesso");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao atualizar registro: " . $e->getMessage());
    }
} else {
    header("Location: PA_Registros.php");
    exit;
}
?>