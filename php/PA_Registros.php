<?php
 require_once 'funcoes.php';

 $conexao = conectar();
 ?>

 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar registros</title>
    <link rel="stylesheet" href="../css/index.css">
 </head>
 <body>
    <div class="container">
        <h1>Registros do Sistema (Modo desenvolvedor)</h1>
        <p>Aqui você pode visualizar os registros do sistema, editar ou excluir.</p>
        <?php
        consultaEstudantes($conexao);
        ?>
        <br>
        <button onclick="location.href='../html/PainelAdministrativo.html'">Voltar ao Painel Administrativo</button>
    </div>
 </body>
 </html>