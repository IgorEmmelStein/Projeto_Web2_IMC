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
    <title>Análise de IMC da Turma</title>
    <link rel="stylesheet" href="../css/index.css"> 
</head>
<body>
    <div class="container">
        <h1>Análise de IMC da Turma</h1>
        <button onclick="location.href='../html/PainelAdministrativo.html'">Voltar ao Painel</button>
        
        <table>
            <thead>
                <tr>
                    <th>NOME</th>
                    <th>PESO (KG)</th>
                    <th>ALTURA (M)</th>
                    <th>IMC</th>
                    <th>CLASSIFICAÇÃO</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($dados) > 0): ?>
                    <?php foreach ($dados as $linha): 
                        $peso = (float)$linha['peso'];
                        $altura = (float)$linha['altura'];
                        $imc = 0;
                        $classificacao = "Dados Inválidos";

                        
                        if ($altura > 0) {
                            $imc = $peso / ($altura * $altura);

                            if ($imc < 18.5) $classificacao = "Abaixo do peso";
                            elseif ($imc < 24.9) $classificacao = "Peso normal";
                            elseif ($imc < 29.9) $classificacao = "Sobrepeso";
                            else $classificacao = "Obesidade";
                        }
                    ?>
                        <tr>
                            <td><?= $linha['nome'] ?></td>
                            <td><?= number_format($peso, 2, ',', '.') ?></td>
                            <td><?= number_format($altura, 2, ',', '.') ?></td>
                            <td><?= $imc > 0 ? number_format($imc, 2, ',', '.') : "---" ?></td>
                            <td><?= $classificacao ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhum estudante cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>Pesquisadores: Igor Stein e João Pierret | IFSul Venâncio Aires</p>
    </footer>
</body>
</html>