<?php
include 'dadosConexao.php';
include 'funcoes.php';

try {
    $sql = "SELECT nome, peso, altura FROM estudantes";
    $stmt = $pdo->query($sql);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de IMC</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <div class="container">
        <h1>Análise de IMC da Turma</h1>
        <button onclick="location.href='PainelAdministrativo.html'">Voltar ao Painel</button>
        
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Peso (kg)</th>
                    <th>Altura (m)</th>
                    <th>IMC</th>
                    <th>Classificação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados as $linha): 
                    $imc = $linha['peso'] / ($linha['altura'] * $linha['altura']);
                    $classificacao = "";

                    if ($imc < 18.5) $classificacao = "Abaixo do peso";
                    elseif ($imc < 24.9) $classificacao = "Peso normal";
                    elseif ($imc < 29.9) $classificacao = "Sobrepeso";
                    else $classificacao = "Obesidade";
                ?>
                    <tr>
                        <td><?= $linha['nome'] ?></td>
                        <td><?= $linha['peso'] ?></td>
                        <td><?= $linha['altura'] ?></td>
                        <td><?= number_format($imc, 2) ?></td>
                        <td><?= $classificacao ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>Pesquisadores: Igor Stein e João Pierret | IFSul Venâncio Aires</p>
    </footer>
</body>
</html>