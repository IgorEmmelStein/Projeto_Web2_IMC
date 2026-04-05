<?php

function conectar(): mysqli
{
    include 'dadosConexao.php';

    $conexao = new mysqli($localSevidor, $usuario, $senha, $nomeBaseDados);

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    return $conexao;
}

function registrarLog(string $operacao): void
{
    $dataHora = date('Y-m-d H:i:s');
    $mensagem = "[$dataHora] Operação: $operacao" . PHP_EOL;
    file_put_contents('operacoes_bd.txt', $mensagem, FILE_APPEND);
}

function calcularIMC(float $peso, float $altura): float
{
    if ($altura <= 0) {
        throw new InvalidArgumentException("Altura deve ser maior que zero.");
    }
    return $peso / ($altura * $altura);
}

function classificarIMC(float $imc): string
{
    if ($imc <= 18.5) return "Abaixo do peso";
    if ($imc <= 24.9) return "Peso normal";
    if ($imc <= 29.9) return "Sobrepeso";
    if ($imc <= 34.9) return "Obesidade grau 1";
    if ($imc <= 39.9) return "Obesidade grau 2";
    return "Obesidade grau 3";
}

function inserirestudante(string $nome, string $sobrenome, int $idade, float $peso, float $altura): void
{
    $conexao = conectar();
    $imc = calcularIMC($peso, $altura);
    
    $stmt = $conexao->prepare("INSERT INTO estudantes (nome, sobrenome, idade, peso, altura, imc) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiddd", $nome, $sobrenome, $idade, $peso, $altura, $imc);

    if ($stmt->execute()) {
        registrarLog("Inserção de estudante: $nome");
        echo "estudante inserida com sucesso!";
    } else {
        echo "Erro: " . $conexao->error;
    }
    $conexao->close();
}

function excluirestudante(int $id): void
{
    $conexao = conectar();
    $comandoSQL = "DELETE FROM estudantes WHERE idestudante = $id";

    if (mysqli_query($conexao, $comandoSQL)) {
        registrarLog("Exclusão de estudante com ID: $id");
        echo "estudante excluída com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($conexao);
    }
    mysqli_close($conexao);
}

function alterarestudante(int $id, string $nome, string $sobrenome, int $idade, float $peso, float $altura): void
{
    $conexao = conectar();
    $imc = calcularIMC($peso, $altura);
    $comandoSQL = "UPDATE estudantes SET nome='$nome', sobrenome='$sobrenome', idade=$idade, peso=$peso, altura=$altura, imc=$imc WHERE idestudante=$id";

    if (mysqli_query($conexao, $comandoSQL)) {
        registrarLog("Alteração de estudante com ID: $id");
        echo "estudante alterada com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($conexao);
    }
    mysqli_close($conexao);
}

function consultaEstudantes(mysqli $conexao): void
{
    $comandoSQL = "SELECT * FROM estudantes";
    $retorno = mysqli_query($conexao, $comandoSQL);

    echo "<table border='1'>
            <tr>
                <th>Nome</th>
                <th>Idade</th>
                <th>IMC</th>
                <th>Ações</th> 
            </tr>";

    while ($reg = mysqli_fetch_array($retorno)) {
        echo "<tr>
                <td>{$reg['nome']} {$reg['sobrenome']}</td>
                <td>{$reg['idade']}</td>
                <td>" . number_format($reg['imc'], 2) . "</td>
                <td>
                    <a href='form_alterar.php?id={$reg['idestudante']}'>Alterar</a> | 
                    <a href='../php/processa_exclusao.php?id={$reg['idestudante']}'>Excluir</a>
                </td>
              </tr>";
    }
    echo "</table>";
}

// Retorna todos os registros em um array para processamento manual
function buscarDadosBrutos(): array {
    $conn = conectar();
    $res = $conn->query("SELECT * FROM estudantes"); 
    if (!$res) {
        die("Erro na consulta: " . $conn->error);
    }
    $dados = $res->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $dados;
}

// Estatísticas de Idade
function processarEstatisticasIdade(array $lista): array {
    if (empty($lista)) return [];

    $soma = 0;
    $velha = $lista[0];
    $nova = $lista[0];

    foreach ($lista as $p) {
        $soma += $p['idade'];
        if ($p['idade'] > $velha['idade']) $velha = $p;
        if ($p['idade'] < $nova['idade']) $nova = $p;
    }

    $media = $soma / count($lista);
    $acima = [];
    $abaixo = [];

    foreach ($lista as $p) {
        if ($p['idade'] > $media) $acima[] = $p['nome'];
        elseif ($p['idade'] < $media) $abaixo[] = $p['nome'];
    }

    // Ordenação manual para os rankings
    $listaMaiores = $lista;
    usort($listaMaiores, fn($a, $b) => $b['idade'] <=> $a['idade']);
    
    $listaMenores = $lista;
    usort($listaMenores, fn($a, $b) => $a['idade'] <=> $b['idade']);

    return [
        'media' => $media,
        'mais_velha' => $velha,
        'mais_nova' => $nova,
        'nomes_acima' => $acima,
        'nomes_abaixo' => $abaixo,
        'top3_velhos' => array_slice($listaMaiores, 0, 3),
        'top5_novos' => array_slice($listaMenores, 0, 5)
    ];
}

// Estatísticas de Peso e IMC
function processarEstatisticasSaude(array $lista): array {
    if (empty($lista)) return [];

    $maiorPeso = $lista[0]['peso'];
    $menorPeso = $lista[0]['peso'];
    $somaPeso = 0;
    $somaIMC = 0;
    $contagemGraus = [];
    $foraDoNormal = [];

    foreach ($lista as $p) {
        // Peso
        if ($p['peso'] > $maiorPeso) $maiorPeso = $p['peso'];
        if ($p['peso'] < $menorPeso) $menorPeso = $p['peso'];
        $somaPeso += $p['peso'];

        // IMC
        $somaIMC += $p['imc'];
        $classe = classificarIMC($p['imc']);
        $contagemGraus[$classe] = ($contagemGraus[$classe] ?? 0) + 1;

        // Fora do Normal (Cálculo de ganho/perda)
        if ($classe != "Peso normal") {
            $pesoIdeal = 22 * ($p['altura'] * $p['altura']);
            $foraDoNormal[] = [
                'nome' => $p['nome'],
                'peso_atual' => $p['peso'],
                'diferenca' => $pesoIdeal - $p['peso']
            ];
        }
    }

    return [
        'peso_maior' => $maiorPeso,
        'peso_menor' => $menorPeso,
        'peso_media' => $somaPeso / count($lista),
        'imc_media' => $somaIMC / count($lista),
        'contagem_imc' => $contagemGraus,
        'ajustes_peso' => $foraDoNormal
    ];
}
?>