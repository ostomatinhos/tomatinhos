<?php
// Sessão e controle de acesso (sem HTML).

session_start();

function ehAluno()
{
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'aluno';
}

function ehProfessor()
{
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'professor';
}

// Chame no início das páginas do aluno. Se não for aluno, vai para aluno/login.php
function exigirAluno()
{
    if (!ehAluno()) {
        header('Location: login.php');
        exit;
    }
}

// Chame no início das páginas do professor. Se não for professor, vai para professor/login.php
function exigirProfessor()
{
    if (!ehProfessor()) {
        header('Location: login.php');
        exit;
    }
}

// Quantas aulas o aluno logado já finalizou (0 a 3).
function aulasConcluidas($conexao)
{
    $stmt = $conexao->prepare("SELECT aulas_concluidas FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    return (int) $stmt->fetchColumn();
}
