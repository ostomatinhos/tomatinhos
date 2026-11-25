<?php
require_once '../config/auth.php';
require_once '../config/conexao.php';

exigirProfessor();

$raiz = '../';

$stmt = $conexao->query("SELECT * FROM questoes ORDER BY id");
$questoes = $stmt->fetchAll();

$mensagem = $_GET['msg'] ?? '';

require_once '../includes/header.php';
?>

<h1>Questões</h1>

<?php if ($mensagem === 'cadastrado'): ?>
    <div class="sucesso">Questão cadastrada com sucesso!</div>
<?php elseif ($mensagem === 'editado'): ?>
    <div class="sucesso">Questão atualizada com sucesso!</div>
<?php elseif ($mensagem === 'excluido'): ?>
    <div class="sucesso">Questão excluída.</div>
<?php endif; ?>

<p><a href="cadastrar.php" class="btn">+ Nova questão</a></p>

<?php if (empty($questoes)): ?>
    <p>Nenhuma questão cadastrada.</p>
<?php else: ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Pergunta</th>
            <th>A</th>
            <th>B</th>
            <th>C</th>
            <th>D</th>
            <th>E</th>
            <th>Correta</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($questoes as $q): ?>
            <tr>
                <td><?= $q['id'] ?></td>
                <td><?= htmlspecialchars($q['pergunta']) ?></td>
                <td><?= htmlspecialchars($q['alternativaA']) ?></td>
                <td><?= htmlspecialchars($q['alternativaB']) ?></td>
                <td><?= htmlspecialchars($q['alternativaC']) ?></td>
                <td><?= htmlspecialchars($q['alternativaD']) ?></td>
                <td><?= htmlspecialchars($q['alternativaE'] ?? '') ?></td>
                <td><?= htmlspecialchars($q['resposta_correta']) ?></td>
                <td>
                    <a href="editar.php?id=<?= $q['id'] ?>">Editar</a>
                    <a href="excluir.php?id=<?= $q['id'] ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
