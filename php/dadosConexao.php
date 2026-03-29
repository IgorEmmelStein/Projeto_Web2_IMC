<?php
$localSevidor = "localhost";
$usuario = "root";
$senha = "";
$nomeBaseDados = "projeto_web2_imc";

include __DIR__ . "/funcoes.php"; // Garante o caminho correto

if (isset($_GET['acao'])) {
    $conexao = conectar();
    $filtro = $_GET['acao'];

    consultaEstudantes($conexao, $filtro);

    mysqli_close($conexao);
}
