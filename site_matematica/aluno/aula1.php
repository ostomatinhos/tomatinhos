<?php
require_once '../config/auth.php';
require_once '../config/conexao.php';

exigirAluno();

$raiz = '../';
$concluidas = aulasConcluidas($conexao);

// Aula 1 está sempre liberada.

// Clicou em "Finalizar aula"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($concluidas == 0) {
        $stmt = $conexao->prepare("UPDATE usuarios SET aulas_concluidas = 1 WHERE id = ?");
        $stmt->execute([$_SESSION['usuario_id']]);
    }
    header('Location: aula2.php');
    exit;
}

require_once '../includes/header.php';
?>

<h1>Aula 1</h1>

<!-- ===== CONTEÚDO DA AULA: substitua o Lorem Ipsum abaixo ===== -->

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>

<!-- ===== FIM DO CONTEÚDO DA AULA ===== -->

<hr>

<?php if ($concluidas >= 1): ?>
    <p><strong>Aula concluída.</strong> <a href="aula2.php">Ir para a Aula 2</a></p>
<?php else: ?>
    <form method="POST" action="aula1.php">
        <button type="submit">Finalizar aula</button>
    </form>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
