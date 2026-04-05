<?php
include 'dadosConexao.php';
include 'funcoes.php';

$conexao = conectar($localSevidor, $usuario, $senha, $nomeBaseDados, $conexao);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$nomeRecebido      = $_POST['containerNome'];
$sobrenomeRecebido = $_POST['containerSobrenome'];
$idadeRecebida     = $_POST['containerIdade'];
$pesoRecebido      = $_POST['containerPeso'];
$alturaRecebida    = $_POST['containerAltura'];

$query = $conexao->prepare("INSERT INTO pessoas (nome, sobrenome, idade, peso, altura) VALUES (?, ?, ?, ?, ?)");
$query->bind_param("ssidd", $nomeRecebido, $sobrenomeRecebido, $idadeRecebida, $pesoRecebido, $alturaRecebida);

$inserido = mysqli_query($conexao, $query);

if ($query->execute()) {
    echo "Cadastro realizado com sucesso!";
} else {
    echo "Erro ao cadastrar: " . $query->error;
}

$query->close();
$conexao->close();
