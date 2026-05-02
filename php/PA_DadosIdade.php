<?php
include 'dadosConexao.php';
include 'funcoes.php';

try {
    $sql = "SELECT nome, idade FROM estudantes ORDER BY idade ASC";
    $stmt = $pdo->query($sql);
    $dadosIdade = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar dados de idade: " . $e->getMessage());
}
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

        <table>
            <thead>
                <tr>
                    <th>Requisito</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Maior Idade?</strong></td>
                    <td><?= $dadosIdade['mais_velha']['idade'] ?> anos</td>
                </tr>
                <tr>
                    <td><strong>Nome da pessoa mais velha?</strong></td>
                    <td><?= $dadosIdade['mais_velha']['nome'] ?></td>
                </tr>
                <tr>
                    <td><strong>Menor Idade?</strong></td>
                    <td><?= $dadosIdade['mais_nova']['idade'] ?> anos</td>
                </tr>
                <tr>
                    <td><strong>Nome e altura da pessoa mais nova?</strong></td>
                    <td>
                        <?= $dadosIdade['mais_nova']['nome'] ?> 
                        (<?= isset($dadosIdade['mais_nova']['altura']) ? $dadosIdade['mais_nova']['altura'] . "m" : "Altura não registada" ?>)
                    </td>
                </tr>
                <tr>
                    <td><strong>Idade média do grupo?</strong></td>
                    <td><?= number_format($dadosIdade['media'], 1) ?> anos</td>
                </tr>
                <tr>
                    <td><strong>Acima da média?</strong></td>
                    <td>
                        <?= count($dadosIdade['nomes_acima']) ?> pessoa(s) <br>
                        <small>(<?= implode(", ", $dadosIdade['nomes_acima']) ?>)</small>
                    </td>
                </tr>
                <tr>
                    <td><strong>Abaixo da média?</strong></td>
                    <td><?= count($dadosIdade['nomes_abaixo']) ?> pessoa(s)</td>
                </tr>
            </tbody>
        </table>

        <h3>Ranking: 3 Maiores Idades</h3>
        <ul>
            <?php foreach ($dadosIdade['top3_velhos'] as $p): ?>
                <li><?= $p['nome'] ?> - IMC: <?= number_format($p['imc'], 2) ?> (<?= $p['idade'] ?> anos)</li>
            <?php endforeach; ?>
        </ul>

        <h3>Ranking: 5 Menores Idades</h3>
        <ul>
            <?php foreach ($dadosIdade['top5_novos'] as $p): ?>
                <li><?= $p['nome'] ?> - IMC: <?= number_format($p['imc'], 2) ?> (<?= $p['idade'] ?> anos)</li>
            <?php endforeach; ?>
        </ul>

        <br>
        <button type="button" onclick="location.href='../html/PainelAdministrativo.html'">Voltar pro Painel</button>
    </div>

    <footer>
        <p>Pesquisadores: Igor Stein e João Pierret | IFSul Venâncio Aires</p>
    </footer>
</body>
</html>