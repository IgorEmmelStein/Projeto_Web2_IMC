<?php
include 'dadosConexao.php';
include 'funcoes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id']; 
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $idade = (int)$_POST['idade'];
    $peso = (float)$_POST['peso'];
    $altura = (float)$_POST['altura'];

    try {
        $sql = "UPDATE estudantes SET nome = :nome, sobrenome = :sobrenome, idade = :idade, peso = :peso, altura = :altura WHERE idestudante = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':sobrenome', $sobrenome);
        $stmt->bindValue(':idade', $idade);
        $stmt->bindValue(':peso', $peso);
        $stmt->bindValue(':altura', $altura);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: PA_Registros.php?sucesso=1");
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao atualizar: " . $e->getMessage());
    }
}
?>