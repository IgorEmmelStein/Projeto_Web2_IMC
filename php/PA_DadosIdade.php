<?php
include 'dadosConexao.php';

$dadosIdade = [
    'mais_nova' => ['nome' => 'N/A', 'idade' => 0, 'altura' => 0],
    'media' => 0,
    'nomes_acima' => [],
    'nomes_abaixo' => [],
    'top3_velhos' => [['nome' => 'N/A', 'idade' => 0, 'imc' => 0]],
    'top5_novos' => []
];

try {

    $stmt = $pdo->query("SELECT nome, idade, peso, altura FROM estudantes ORDER BY idade ASC");
    $todos = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (count($todos) > 0) {
        $somaIdades = 0;
        $nomes_acima = [];
        $nomes_abaixo = [];
        $ranking = [];

    
        $mais_nova = $todos[0];

    
        foreach ($todos as $p) {
            $somaIdades += $p['idade'];
            
        
            $altura_quadrada = $p['altura'] * $p['altura'];
            $p['imc'] = ($altura_quadrada > 0) ? ($p['peso'] / $altura_quadrada) : 0;
            $ranking[] = $p;
        }

    
        $mediaIdade = $somaIdades / count($todos);

    
        foreach ($todos as $p) {
            if ($p['idade'] > $mediaIdade) {
                $nomes_acima[] = $p['nome'];
            } elseif ($p['idade'] < $mediaIdade) {
                $nomes_abaixo[] = $p['nome'];
            }
        }

    
        $top5_novos = array_slice($ranking, 0, 5);
        
    
        usort($ranking, function ($a, $b) {
            return $b['idade'] <=> $a['idade'];
        });
        $top3_velhos = array_slice($ranking, 0, 3);

    
        $dadosIdade = [
            'mais_nova' => $mais_nova,
            'media' => $mediaIdade,
            'nomes_acima' => $nomes_acima,
            'nomes_abaixo' => $nomes_abaixo,
            'top3_velhos' => $top3_velhos,
            'top5_novos' => $top5_novos
        ];
    }
} catch (PDOException $e) {
    die("Erro técnico: " . $e->getMessage());
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

        <table border="1">
            <thead>
                <tr>
                    <th>REQUISITO</th>
                    <th>RESULTADO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Maior Idade?</strong></td>
                    <td><?= $dadosIdade['top3_velhos'][0]['idade'] ?> anos</td> 
                </tr>
                <tr>
                    <td><strong>Nome da pessoa mais velha?</strong></td>
                    <td><?= $dadosIdade['top3_velhos'][0]['nome'] ?></td> 
                </tr>
                <tr>
                    <td><strong>Menor Idade?</strong></td>
                    <td><?= $dadosIdade['mais_nova']['idade'] ?> anos</td> 
                </tr>
                <tr>
                    <td><strong>Nome e altura da pessoa mais nova?</strong></td>
                    <td>
                        <?= $dadosIdade['mais_nova']['nome'] ?> 
                        (<?= $dadosIdade['mais_nova']['altura'] ?>m)
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