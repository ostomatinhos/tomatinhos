<?php
require_once '../config/auth.php';
require_once '../config/conexao.php';

exigirProfessor();

$raiz = '../';
$erros = [];
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
    $dados = [
        'pergunta'         => trim($_POST['pergunta'] ?? ''),
        'alternativaA'     => trim($_POST['alternativaA'] ?? ''),
        'alternativaB'     => trim($_POST['alternativaB'] ?? ''),
        'alternativaC'     => trim($_POST['alternativaC'] ?? ''),
        'alternativaD'     => trim($_POST['alternativaD'] ?? ''),
        'alternativaE'     => trim($_POST['alternativaE'] ?? ''),
        'resposta_correta' => trim($_POST['resposta_correta'] ?? ''),
    ];

    if (in_array('', $dados, true)) {
        $erros[] = 'Preencha todos os campos.';
    }

    if (!in_array($dados['resposta_correta'], ['A', 'B', 'C', 'D', 'E'])) {
        $erros[] = 'A resposta correta deve ser A, B, C, D ou E.';
    }

    // Mantém no formulário o que o professor digitou
    $questao = array_merge($questao, $dados);

    if (empty($erros)) {
        $stmt = $conexao->prepare(
            "UPDATE questoes
                SET pergunta = ?, alternativaA = ?, alternativaB = ?, alternativaC = ?,
                    alternativaD = ?, alternativaE = ?, resposta_correta = ?
              WHERE id = ?"
        );
        $stmt->execute([
            $dados['pergunta'],
            $dados['alternativaA'],
            $dados['alternativaB'],
            $dados['alternativaC'],
            $dados['alternativaD'],
            $dados['alternativaE'],
            $dados['resposta_correta'],
            $id,
        ]);

        header('Location: listar.php?msg=editado');
        exit;
    }
}

require_once '../includes/header.php';
?>

<h1>Editar questão</h1>

<?php if (!empty($erros)): ?>
    <div class="erro">
        <?php foreach ($erros as $erro): ?><div><?= htmlspecialchars($erro) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="editar.php?id=<?= $id ?>">
    <label>Pergunta
        <textarea name="pergunta" required><?= htmlspecialchars($questao['pergunta']) ?></textarea>
    </label>
    <label>Alternativa A
        <input type="text" name="alternativaA" value="<?= htmlspecialchars($questao['alternativaA']) ?>" maxlength="255" required>
    </label>
    <label>Alternativa B
        <input type="text" name="alternativaB" value="<?= htmlspecialchars($questao['alternativaB']) ?>" maxlength="255" required>
    </label>
    <label>Alternativa C
        <input type="text" name="alternativaC" value="<?= htmlspecialchars($questao['alternativaC']) ?>" maxlength="255" required>
    </label>
    <label>Alternativa D
        <input type="text" name="alternativaD" value="<?= htmlspecialchars($questao['alternativaD']) ?>" maxlength="255" required>
    </label>
    <label>Alternativa E
        <input type="text" name="alternativaE" value="<?= htmlspecialchars($questao['alternativaE'] ?? '') ?>" maxlength="255" required>
    </label>
    <label>Resposta correta
        <select name="resposta_correta" required>
            <?php foreach (['A', 'B', 'C', 'D', 'E'] as $letra): ?>
                <option value="<?= $letra ?>" <?= $questao['resposta_correta'] === $letra ? 'selected' : '' ?>><?= $letra ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <p>
        <a href="listar.php" class="btn">Cancelar</a>
        <button type="submit">Salvar alterações</button>
    </p>
</form>

<?php require_once '../includes/footer.php'; ?>
