<?php
include_once '../php/funcoes.php';

$conn = conectar();
$res = $conn->query("SELECT * FROM pessoas");
$listaPessoas = $res->fetch_all(MYSQLI_ASSOC);

// Processamento dos dados através das funções 
$media = calcularMediaIdade($listaPessoas);
$velha = getPessoaMaisVelha($listaPessoas);
$nova = getPessoaMaisNova($listaPessoas);
$relatorio = getRelatorioMedia($listaPessoas, $media);

// Registo obrigatório no log 
registrarLog("Visualizou relatório de idades");
?>