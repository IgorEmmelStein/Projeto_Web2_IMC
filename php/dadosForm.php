<?php
include 'dadosConexao.php';
include 'funcoes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome   = $_POST['nome'];
    $peso   = (float)$_POST['peso'];
    $altura = (float)$_POST['altura'];

    try {
        $sql = "INSERT INTO estudantes (nome, peso, altura) VALUES (:nome, :peso, :altura)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':peso', $peso);
        $stmt->bindValue(':altura', $altura);

        if ($stmt->execute()) {
            header("Location: PA_Registros.php");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao salvar estudante: " . $e->getMessage());
    }
} else {
    header("Location: ../html/index.html");
    exit;
}
?>