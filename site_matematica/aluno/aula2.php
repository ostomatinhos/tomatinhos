<?php
require_once '../config/auth.php';
require_once '../config/conexao.php';

exigirAluno();

$raiz = '../';
$concluidas = aulasConcluidas($conexao);

// Aula 2 só abre se a Aula 1 foi concluída. Senão, volta para a aula liberada.
if ($concluidas < 1) {
    header('Location: aula1.php');
    exit;
}

// Clicou em "Finalizar aula"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($concluidas == 1) {
        $stmt = $conexao->prepare("UPDATE usuarios SET aulas_concluidas = 2 WHERE id = ?");
        $stmt->execute([$_SESSION['usuario_id']]);
    }
    header('Location: aula3.php');
    exit;
}

require_once '../includes/header.php';
?>

<h1>Aula 2</h1>

<!-- ===== CONTEÚDO DA AULA: substitua o Lorem Ipsum abaixo ===== -->

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>

<!-- ===== FIM DO CONTEÚDO DA AULA ===== -->

<hr>

<?php if ($concluidas >= 2): ?>
    <p><strong>Aula concluída.</strong> <a href="aula3.php">Ir para a Aula 3</a></p>
<?php else: ?>
    <form method="POST" action="aula2.php">
        <button type="submit">Finalizar aula</button>
    </form>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
