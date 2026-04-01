<?php
    include'funcoes.php';
    include'dadosConexao.php';

    $nomeRecebido = $_POST['containerNome'];
    $sobrenomeRecebido = $_POST['containerSobrenome'];
    $idadeRecebida = $_POST['containerIdade'];
    $pesoRecebido = $_POST['containerPeso'];
    $alturaRecebida = $_POST['containerAltura'];

    $queryInsercao = "INSERT INTO estudantes (nome, sobrenome, idade, peso, altura) VALUES (?, ?, ?, ?, ?)";

    $insercaoDosDados = $preparar->prepare($queryInsercao);
    $insercaoDosDados->execute([$nomeRecebido, $sobrenomeRecebido, $idadeRecebida, $pesoRecebido, $alturaRecebida]);
?>