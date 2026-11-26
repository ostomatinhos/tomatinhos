<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/conexao.php';

// $raiz é definido em cada página: '' em index.php e '../' nas pastas aluno/ e professor/
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulados de Matemática</title>
    <link rel="stylesheet" href="<?= $raiz ?>css/style.css">
</head>
<body>

<header>
    <a href="<?= $raiz ?>index.php" class="logo">Simulados de Matemática</a>

    <nav>
        <?php if (ehAluno()): ?>
            <?php $concluidas = aulasConcluidas($conexao); ?>

            <?php for ($i = 1; $i <= 3; $i++): ?>
                <?php if ($concluidas >= $i): ?>
                    <a href="<?= $raiz ?>aluno/aula<?= $i ?>.php" class="concluida">Aula <?= $i ?> (concluída)</a>
                <?php elseif ($concluidas == $i - 1): ?>
                    <a href="<?= $raiz ?>aluno/aula<?= $i ?>.php">Aula <?= $i ?> (liberada)</a>
                <?php else: ?>
                    <span class="bloqueada">Aula <?= $i ?> (bloqueada)</span>
                <?php endif; ?>
            <?php endfor; ?>

            <a href="<?= $raiz ?>aluno/prova1.php">Simulado</a>
            <a href="<?= $raiz ?>logout.php">Sair (<?= htmlspecialchars($_SESSION['usuario_nome']) ?>)</a>

        <?php elseif (ehProfessor()): ?>
            <a href="<?= $raiz ?>professor/listar.php">Questões</a>
            <a href="<?= $raiz ?>professor/cadastrar.php">Nova questão</a>
            <a href="<?= $raiz ?>logout.php">Sair (<?= htmlspecialchars($_SESSION['usuario_nome']) ?>)</a>

        <?php else: ?>
            <a href="<?= $raiz ?>aluno/login.php">Entrar</a>
            <a href="<?= $raiz ?>aluno/cadastro.php">Cadastrar</a>
            <a href="<?= $raiz ?>professor/login.php">Área do professor</a>
        <?php endif; ?>
    </nav>
</header>

<main>
