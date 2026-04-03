<?php
include __DIR__ . "/dadosConexao.php";

function conectar(): mysqli
{
    include __DIR__ . "/dadosConexao.php";
    $conexao = mysqli_connect($localSevidor, $usuario, $senha, $nomeBaseDados);

    if (!$conexao) {
        die("Erro: " . mysqli_connect_error());
    }
    return $conexao;
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

function registrarLog(string $operacao): void
{
    $dataHora = date('Y-m-d H:i:s');
    $mensagem = "[$dataHora] Operação: $operacao" . PHP_EOL;
    file_put_contents('operacoes_bd.txt', $mensagem, FILE_APPEND);
}

// Lógica de processamento do Botão de Ação
if (isset($_POST['btnAcao'])) {
    $conexao = conectar();
    $filtro = $_POST['btnAcao'];
    
    echo "<h2>Resultados: " . ucfirst($filtro) . "</h2>";
    consultaEstudantes($conexao, $filtro);
    
    echo "<br><a href='PainelAdministrativo.html'>Voltar pro Painel</a>";
    mysqli_close($conexao);
}

// --- FUNÇÕES DE CRUD (TABELA PESSOAS) ---

function inserirPessoa(string $nome, string $sobrenome, int $id, float $peso, float $altura): void
{
    $conexao = conectar();
    $imc = calcularIMC($peso, $altura);
    $comandoSQL = "INSERT INTO pessoas (nome, sobrenome, idade, peso, altura, imc) VALUES ('$nome', '$sobrenome', $id, $peso, $altura, $imc)";

    if (mysqli_query($conexao, $comandoSQL)) {
        registrarLog("Inserção de pessoa: $nome");
        echo "Pessoa inserida com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($conexao);
    }
    mysqli_close($conexao);
}

function excluirPessoa(int $id): void
{
    $conexao = conectar();
    $comandoSQL = "DELETE FROM pessoas WHERE id = $id";

    if (mysqli_query($conexao, $comandoSQL)) {
        registrarLog("Exclusão de pessoa com ID: $id");
        echo "Pessoa excluída com sucesso!";
    } else { 
        echo "Erro: " . mysqli_error($conexao);
    }
    mysqli_close($conexao);
}

function alterarPessoa(int $id, string $nome, string $sobrenome, int $idade, float $peso, float $altura): void
{
    $conexao = conectar();
    $comandoSQL = "UPDATE pessoas SET nome='$nome', sobrenome='$sobrenome', idade=$idade, peso=$peso, altura=$altura WHERE id=$id";

    if (mysqli_query($conexao, $comandoSQL)) {
        registrarLog("Alteração de pessoa com ID: $id");
        echo "Pessoa alterada com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($conexao);
    }
    mysqli_close($conexao);
}

function consultaEstudantes(mysqli $conexao, string $filtro): void
{
    $comandoSQL = "SELECT * FROM pessoas";
    $retorno = mysqli_query($conexao, $comandoSQL);

    echo "<table border='1'><tr><th>Nome</th>";
    if ($filtro == "todos" || $filtro == "idade") echo "<th>Idade</th>";
    if ($filtro == "todos" || $filtro == "peso") echo "<th>Peso</th>";
    if ($filtro == "todos" || $filtro == "imc") echo "<th>IMC</th>";
    echo "</tr>";

    while ($reg = mysqli_fetch_array($retorno)) {
        echo "<tr><td>{$reg['nome']}</td>";
        if ($filtro == "todos" || $filtro == "idade") echo "<td>{$reg['idade']}</td>";
        if ($filtro == "todos" || $filtro == "peso") echo "<td>{$reg['peso']}</td>";
        if ($filtro == "todos" || $filtro == "imc") echo "<td>{$reg['imc']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// --- FUNÇÕES DE ESTATÍSTICA ---

function listarTodos(): mysqli_result
{
    $conn = conectar();
    $sql = "SELECT * FROM pessoas";
    return $conn->query($sql);
}

function getMediaIdade(mysqli_result $dados): float{
    $somaIdade = 0;
    $total = 0;
    foreach ($dados as $p) {
        $somaIdade += $p['idade'];    
        $total++;
    }
    return $total > 0 ? $somaIdade / $total : 0;
}

// (As outras funções getMaiorIdade, getMenorIdade, etc., seguem a mesma lógica usando a tabela pessoas)
// teste
?>