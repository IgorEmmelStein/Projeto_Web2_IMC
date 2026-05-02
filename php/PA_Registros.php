<?php
include 'dadosConexao.php';
include 'funcoes.php';

try {
    $sql = "SELECT id, nome, peso, altura FROM estudantes";
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
                    <th>Peso</th>
                    <th>Altura</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($estudantes) > 0): ?>
                    <?php foreach ($estudantes as $aluno): ?>
                        <tr>
                            <td><?= $aluno['id'] ?></td>
                            <td><?= $aluno['nome'] ?></td>
                            <td><?= $aluno['peso'] ?> kg</td>
                            <td><?= $aluno['altura'] ?> m</td>
                            <td>
                                <a href="PA_AlterarEstudante.php?id=<?= $aluno['id'] ?>">Editar</a> | 
                                <a href="PA_ExcluirEstudante.php?id=<?= $aluno['id'] ?>" 
                                   onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhum registro encontrado.</td>
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