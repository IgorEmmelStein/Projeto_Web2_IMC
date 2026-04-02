<?php
    include 'dadosConexao.php'; 
    include 'funcoes.php';;

    // Conexão com MySQLi
    $conexao = conectar($localSevidor, $usuario, $senha, $nomeBaseDados, $conexao);

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    // Recebimento de dados do formulário
    $nomeRecebido      = $_POST['containerNome'];
    $sobrenomeRecebido = $_POST['containerSobrenome'];
    $idadeRecebida     = $_POST['containerIdade'];
    $pesoRecebido      = $_POST['containerPeso'];
    $alturaRecebida    = $_POST['containerAltura'];

    // Preparar a query
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
?>