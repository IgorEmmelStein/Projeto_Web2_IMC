<?php
include 'dadosConexao.php';
include 'funcoes.php';

try {
    $sql = "SELECT idestudante, nome, sobrenome, idade, peso, altura FROM estudantes";
    $stmt = $pdo->query($sql);
    $estudantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar registros: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Registros de IMC</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <div class="container">
        <h1>Registros de Estudantes</h1>
        <button onclick="location.href='../html/index.html'">Novo Cadastro</button>

        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Sobrenome</th>
                    <th>Idade</th>
                    <th>Peso</th>
                    <th>Altura</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estudantes as $aluno): ?>
                    <tr>
                        <td><?= $aluno['idestudante'] ?></td> 
                        <td><?= $aluno['nome'] ?></td> 
                        <td><?= $aluno['sobrenome'] ?></td> 
                        <td><?= $aluno['idade'] ?></td> 
                        <td><?= $aluno['peso'] ?></td> 
                        <td><?= $aluno['altura'] ?></td> 
                        <td> 
                            <a href="PA_AlterarEstudante.php?id=<?= $aluno['idestudante'] ?>">Editar</a> |
                            <a href="PA_ExcluirEstudante.php?id=<?= $aluno['idestudante'] ?>" onclick="return confirm('Excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>Pesquisadores: Igor Stein e João Pierret | IFSul Venâncio Aires</p>
    </footer>
</body>

</html>