<?php

session_start();

function ehAluno()
{
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'aluno';
}

function ehProfessor()
{
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'professor';
}


function exigirAluno()
{
    if (!ehAluno()) {
        header('Location: login.php');
        exit;
    }
}


function exigirProfessor()
{
    if (!ehProfessor()) {
        header('Location: login.php');
        exit;
    }
}


function aulasConcluidas($conexao)
{
    $stmt = $conexao->prepare("SELECT aulas_concluidas FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    return (int) $stmt->fetchColumn();
}
