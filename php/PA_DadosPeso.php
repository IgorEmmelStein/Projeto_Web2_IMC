<?php
// php/PA_DadosPeso.php
include_once 'funcoes.php';

$dadosBrutos = buscarDadosBrutos();
$stats = processarEstatisticasSaude($dadosBrutos);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/index.css">
    <title>Dados de Peso</title>
</head>
<body>
    <div class="container">
        <h1>Análise de Pesos</h1>
        <p><strong>Maior Peso:</strong> <?= $stats['peso_maior'] ?>kg | <strong>Menor:</strong> <?= $stats['peso_menor'] ?>kg</p>

        <h3>Estudantes fora do peso Normal</h3>
        <table border="1">
            <tr><th>Nome</th><th>Peso Atual</th><th>Meta</th></tr>
            <?php foreach ($stats['ajustes_peso'] as $p): ?>
                <tr>
                    <td><?= $p['nome'] ?></td>
                    <td><?= $p['peso_atual'] ?>kg</td>
                    <td><?= $p['diferenca'] > 0 ? "Ganhar" : "Perder" ?> <?= number_format(abs($p['diferenca']), 2) ?>kg</td>
                </tr>
            <?php endforeach; ?>
        </table>

        <button onclick="location.href='../html/PainelAdministrativo.html'">Voltar</button>
    </div>
</body>
</html>