<?php
include_once 'funcoes.php';

$dadosBrutos = buscarDadosBrutos(); 

$stats = processarEstatisticasIdade($dadosBrutos); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/index.css">
    <title>Análise de Dados - Idade</title>
</head>
<body>
    <div class="container">
        <h1>Relatório de Idades - Grupo de Pesquisa IFSul</h1>

        <table border="1">
            <thead>
                <tr>
                    <th>Requisito</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Maior Idade?</strong></td>
                    <td><?= $stats['mais_velha']['idade'] ?> anos</td>
                </tr>
                <tr>
                    <td><strong>Nome da pessoa mais velha?</strong></td>
                    <td><?= $stats['mais_velha']['nome'] ?></td>
                </tr>
                <tr>
                    <td><strong>Menor Idade?</strong></td>
                    <td><?= $stats['mais_nova']['idade'] ?> anos</td>
                </tr>
                <tr>
                    <td><strong>Nome e altura da pessoa mais nova?</strong></td>
                    <td>
                        <?= $stats['mais_nova']['nome'] ?> 
                        (<?= isset($stats['mais_nova']['altura']) ? $stats['mais_nova']['altura'] . "m" : "Altura não registada" ?>)
                    </td>
                </tr>
                <tr>
                    <td><strong>Idade média do grupo?</strong></td>
                    <td><?= number_format($stats['media'], 1) ?> anos</td>
                </tr>
                <tr>
                    <td><strong>Acima da média?</strong></td>
                    <td>
                        <?= count($stats['nomes_acima']) ?> pessoa(s) <br>
                        <small>(<?= implode(", ", $stats['nomes_acima']) ?>)</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>Abaixo da média?</strong></td>
                    <td><?= count($stats['nomes_abaixo']) ?> pessoa(s)</td>
                </tr>
            </tbody>
        </table>

        <h3>Ranking: 3 Maiores Idades</h3>
        <ul>
            <?php foreach ($stats['top3_velhos'] as $p): ?>
                <li><?= $p['nome'] ?> - IMC: <?= number_format($p['imc'], 2) ?> (<?= $p['idade'] ?> anos)</li>
            <?php endforeach; ?>
        </ul>

        <h3>Ranking: 5 Menores Idades</h3>
        <ul>
            <?php foreach ($stats['top5_novos'] as $p): ?>
                <li><?= $p['nome'] ?> - IMC: <?= number_format($p['imc'], 2) ?> (<?= $p['idade'] ?> anos)</li>
            <?php endforeach; ?>
        </ul>

        <br>
        <button type="button" onclick="location.href='../html/PainelAdministrativo.html'">Voltar pro Painel</button>
    </div>

    <footer>
        <p>Pesquisadores: Igor Emmel Stein e João Pedro Pierret de Souza | IFSul Venâncio Aires</p>
    </footer>
</body>
</html>