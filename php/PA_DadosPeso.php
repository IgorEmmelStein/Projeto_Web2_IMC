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
        <table>
            <tr>
                <th>Nome</th>
                <th>Peso Atual</th>
                <th>Meta</th>
            </tr>
            <?php
            include 'dadosConexao.php';
            include 'funcoes.php';

            try {
                // Supondo que tu tenhas uma coluna 'idade' no teu banco projeto_imc
                $sql = "SELECT nome, idade FROM estudantes ORDER BY idade ASC";
                $stmt = $pdo->query($sql);
                $dadosIdade = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Erro ao carregar dados de idade: " . $e->getMessage());
            }
            ?>
        </table>

        <button onclick="location.href='../html/PainelAdministrativo.html'">Voltar</button>
    </div>

    <footer>
        <p>Pesquisadores: Igor Stein e João Pierret | IFSul Venâncio Aires</p>
    </footer>
</body>

</html>