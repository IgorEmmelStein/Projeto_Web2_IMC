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
    <title>Dados de Idade</title>
</head>
<body>
    <div class="container">
        <h1>Análise de Idades</h1>

        <table border="1">
            <tr><td><strong>Maior Idade:</strong></td><td><?= $stats['mais_velha']['idade'] ?> anos (<?= $stats['mais_velha']['nome'] ?>)</td></tr>
            <tr><td><strong>Menor Idade:</strong></td><td><?= $stats['mais_nova']['idade'] ?> anos (<?= $stats['mais_nova']['nome'] ?> - <?= $stats['mais_nova']['altura'] ?>m)</td></tr>
            <tr><td><strong>Média de Idade:</strong></td><td><?= number_format($stats['media'], 1) ?> anos</td></tr>
        </table>

        <h3>Acima da Média (<?= count($stats['nomes_acima']) ?> estudante(s))</h3>
        <p><?= implode(", ", $stats['nomes_acima']) ?></p>

        <h3>Ranking de Idades</h3>
        <p><strong>3 Maiores:</strong></p>
        <ul>
            <?php foreach ($stats['top3_velhos'] as $p): ?>
                <li><?= $p['nome'] ?> - IMC: <?= number_format($p['imc'], 2) ?></li>
            <?php endforeach; ?>
        </ul>

        <button onclick="location.href='../html/PainelAdministrativo.html'">Voltar</button>
    </div>
</body>
</html>