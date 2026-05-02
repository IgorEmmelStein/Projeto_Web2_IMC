<?php
include 'dadosConexao.php';
include 'funcoes.php';

if (isset($_POST['containerNome'], $_POST['containerPeso'], $_POST['containerAltura'])) {

    $nome   = $_POST['containerNome'];
    $peso   = (float)$_POST['containerPeso'];
    $altura = (float)$_POST['containerAltura'];

    try {
        $sql = "INSERT INTO estudantes (nome, sobrenome, idade, peso, altura) VALUES (:nome, :sobrenome, :idade, :peso, :altura)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nome', $_POST['containerNome']);
        $stmt->bindValue(':sobrenome', $_POST['containerSobrenome']);
        $stmt->bindValue(':idade', (int)$_POST['containerIdade']);
        $stmt->bindValue(':peso', $peso);
        $stmt->bindValue(':altura', $altura);

        if ($stmt->execute()) {
            header("Location: ../html/PainelAdministrativo.html");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao salvar estudante: " . $e->getMessage());
    }
} else {
    header("Location: ../html/index.html?erro=campos_nao_encontrados");
    exit;
}
