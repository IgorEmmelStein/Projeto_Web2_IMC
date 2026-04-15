<?php
include 'funcoes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id        = (int)$_POST['id_estudante'];
    $nome      = $_POST['containerNome'];
    $sobrenome = $_POST['containerSobrenome'];
    $idade     = (int)$_POST['containerIdade'];
    $peso      = (float)$_POST['containerPeso'];
    $altura    = (float)$_POST['containerAltura'];

    alterarestudante($id, $nome, $sobrenome, $idade, $peso, $altura);

    echo "<script>
            alert('Dados atualizados com sucesso!');
            window.location.href = 'PA_Registros.php';
          </script>";
}