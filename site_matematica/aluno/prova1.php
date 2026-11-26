<?php
require_once '../config/auth.php';
require_once '../config/conexao.php';

exigirAluno();

$raiz = '../';

// Sorteia as 10 questões só uma vez e guarda os ids na sessão.
// Assim as questões não mudam até o aluno enviar a prova.
if (!isset($_SESSION['prova'])) {
    $stmt = $conexao->query("SELECT id FROM questoes ORDER BY RAND() LIMIT 10");
    $_SESSION['prova'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Busca no banco cada questão sorteada
$questoes = [];
foreach ($_SESSION['prova'] as $idQuestao) {
    $stmt = $conexao->prepare("SELECT * FROM questoes WHERE id = ?");
    $stmt->execute([$idQuestao]);
    $questao = $stmt->fetch();

    if ($questao) {
        $questoes[] = $questao;
    }
}

require_once '../includes/header.php';
?>

<h1>Simulado</h1>

<?php if (empty($questoes)): ?>
    <p>Não há questões cadastradas.</p>
<?php else: ?>

    <form method="POST" action="corrigir.php">

        <?php foreach ($questoes as $indice => $q): ?>
            <div class="questao">
                <h3><?= $indice + 1 ?>. <?= htmlspecialchars($q['pergunta']) ?></h3>

                <?php foreach (['A', 'B', 'C', 'D', 'E'] as $letra): ?>
                    <?php if (!empty($q['alternativa' . $letra])): ?>
                        <label>
                            <input type="radio" name="resposta[<?= $q['id'] ?>]" value="<?= $letra ?>">
                            <?= $letra ?>) <?= htmlspecialchars($q['alternativa' . $letra]) ?>
                        </label>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <hr>
        <?php endforeach; ?>

        <button type="submit">Finalizar e enviar prova</button>
    </form>

<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
