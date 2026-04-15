<?php
include_once 'funcoes.php';

$dadosBrutos = buscarDadosBrutos(); 

$stats = processarEstatisticasSaude($dadosBrutos);
$totalParticipantes = count($dadosBrutos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/index.css">
    <title>Dados - Índice de Massa Corporal</title>
</head>
<body>
    <div class="container">
        <h1>Relatório de IMC - OMS Venâncio Aires</h1>

        <h3>IMC por Participante</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>IMC</th>
                    <th>Classificação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dadosBrutos as $p): ?>
                <tr>
                    <td><?= $p['nome'] ?></td>
                    <td><?= number_format($p['imc'], 2) ?></td>
                    <td><?= classificarIMC($p['imc']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <hr>

        <h3>Média do Grupo</h3>
        <p><strong>IMC Médio:</strong> <?= number_format($stats['imc_media'], 2) ?></p>

        <hr>

        <h3>Percentuais por Grau de Obesidade do Grupo</h3>
        <table border="1">
            <thead>
                <tr>
                    <th>Grau / Classificação</th>
                    <th>Quantidade</th>
                    <th>Percentual</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats['contagem_imc'] as $classe => $quantidade): ?>
                <tr>
                    <td><?= $classe ?></td>
                    <td><?= $quantidade ?></td>
                    <td><?= number_format(($quantidade / $totalParticipantes) * 100, 1) ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <br>
        <button type="button" onclick="location.href='../html/PainelAdministrativo.html'">Voltar pro Painel</button>
    </div>

    <footer>
        <p>Desenvolvedores: Igor Emmel Stein e João Pedro Pierret de Souza | IFSul</p>
    </footer>
</body>
</html>