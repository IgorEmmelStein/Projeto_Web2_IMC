<?php
include 'funcoes.php';

$conexao = conectar();

$nomeRecebido      = $_POST['containerNome'];
$sobrenomeRecebido = $_POST['containerSobrenome'];
$idadeRecebida     = $_POST['containerIdade'];
$pesoRecebido      = $_POST['containerPeso'];
$alturaRecebida    = $_POST['containerAltura'];

$imc = calcularIMC($pesoRecebido, $alturaRecebida);

$query = $conexao->prepare("INSERT INTO estudantes (nome, sobrenome, idade, peso, altura, imc) VALUES (?, ?, ?, ?, ?, ?)");
$query->bind_param("ssiddd", $nomeRecebido, $sobrenomeRecebido, $idadeRecebida, $pesoRecebido, $alturaRecebida, $imc);


if ($query->execute()) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $query->error;
}

$query->close();
$conexao->close();
?>