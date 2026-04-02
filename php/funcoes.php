<?php
include __DIR__ . "/dadosConexao.php";
function conectar(): mysqli
{
    include __DIR__ . "/dadosConexao.php";
    include "dadosConexao.php";

    $conexao = mysqli_connect($localSevidor, $usuario, $senha, $nomeBaseDados);

    if (!$conexao) {
        die("Erro: " . mysqli_connect_error());
    }
    return $conexao;
}

function consultaEstudantes(mysqli $conexao, string $filtro): void {
    $comandoSQL = "SELECT * FROM pessoas"; // Busca tudo, o filtro decide o que mostrar
    $retorno = mysqli_query($conexao, $comandoSQL);

    echo "<table><tr><th>Nome</th>";
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

if (isset($_POST['btnAcao'])) {
    $conexao = conectar();
    $filtro = $_POST['btnAcao'];
    
    echo "<h2>Resultados: " . ucfirst($filtro) . "</h2>";
    consultaEstudantes($conexao, $filtro);
    
    echo "<br><a href='PainelAdministrativo.html'>Voltar pro Painel</a>";
    mysqli_close($conexao);
}

?>
