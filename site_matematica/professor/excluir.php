<?php
require_once '../config/auth.php';
require_once '../config/conexao.php';

exigirProfessor();

$raiz = '../';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: listar.php');
    exit;
}

$stmt = $conexao->prepare("SELECT * FROM questoes WHERE id = ?");
$stmt->execute([$id]);
$questao = $stmt->fetch();

if (!$questao) {
    header('Location: listar.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conexao->prepare("DELETE FROM questoes WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: listar.php?msg=excluido');
    exit;
}

require_once '../includes/header.php';
?>

<h1>Confirmar exclusão</h1>

<p>Tem certeza de que deseja excluir esta questão? Esta ação não pode ser desfeita.</p>
<p><strong><?= htmlspecialchars($questao['pergunta']) ?></strong></p>

<form method="POST" action="excluir.php?id=<?= $id ?>">
    <a href="listar.php" class="btn">Cancelar</a>
    <button type="submit">Sim, excluir questão</button>
</form>

<?php require_once '../includes/footer.php'; ?>
