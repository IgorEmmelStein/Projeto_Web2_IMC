<?php
include 'dadosConexao.php';
include 'funcoes.php';

$estudantes = buscarDadosBrutos();

$maiorPeso = 0;
$menorPeso = 0;
$somaPeso = 0;
$contagem = count($estudantes);

if ($contagem > 0) {
    $pesos = array_column($estudantes, 'peso');
    $maiorPeso = max($pesos);
    $menorPeso = min($pesos);
    $somaPeso = array_sum($pesos);
    $mediaPeso = $somaPeso / $contagem;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Pesos</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <div class="container">
        <h1>Relatório de Pesos - Grupo IFSul</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Estatística</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Maior Peso Registrado:</strong></td>
                    <td><?= number_format($maiorPeso, 2, ',', '.') ?> kg</td>
                </tr>
                <tr>
                    <td><strong>Menor Peso Registrado:</strong></td>
                    <td><?= number_format($menorPeso, 2, ',', '.') ?> kg</td>
                </tr>
                <tr>
                    <td><strong>Média de Peso do Grupo:</strong></td>
                    <td><?= $contagem > 0 ? number_format($mediaPeso, 2, ',', '.') : 0 ?> kg</td>
                </tr>
            </tbody>
        </table>

        <h3>Listagem Geral de Pesos</h3>
        <ul>
            <?php foreach ($estudantes as $aluno): ?>
                <li><?= $aluno['nome'] ?> <?= $aluno['sobrenome'] ?>: <?= $aluno['peso'] ?> kg</li>
            <?php endforeach; ?>
        </ul>

        <button onclick="location.href='../html/PainelAdministrativo.html'">Voltar</button>
    </div>
</body>
</html>