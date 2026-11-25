<?php
require_once '../config/auth.php';
require_once '../config/conexao.php';

exigirProfessor();

$raiz = '../';
$erros = [];
$dados = [
    'pergunta'         => '',
    'alternativaA'     => '',
    'alternativaB'     => '',
    'alternativaC'     => '',
    'alternativaD'     => '',
    'alternativaE'     => '',
    'resposta_correta' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados['pergunta']         = trim($_POST['pergunta'] ?? '');
    $dados['alternativaA']     = trim($_POST['alternativaA'] ?? '');
    $dados['alternativaB']     = trim($_POST['alternativaB'] ?? '');
    $dados['alternativaC']     = trim($_POST['alternativaC'] ?? '');
    $dados['alternativaD']     = trim($_POST['alternativaD'] ?? '');
    $dados['alternativaE']     = trim($_POST['alternativaE'] ?? '');
    $dados['resposta_correta'] = trim($_POST['resposta_correta'] ?? '');

    if (in_array('', $dados, true)) {
        $erros[] = 'Preencha todos os campos.';
    }

    if (!in_array($dados['resposta_correta'], ['A', 'B', 'C', 'D', 'E'])) {
        $erros[] = 'A resposta correta deve ser A, B, C, D ou E.';
    }

    if (empty($erros)) {
        $stmt = $conexao->prepare(
            "INSERT INTO questoes (pergunta, alternativaA, alternativaB, alternativaC, alternativaD, alternativaE, resposta_correta)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $dados['pergunta'],
            $dados['alternativaA'],
            $dados['alternativaB'],
            $dados['alternativaC'],
            $dados['alternativaD'],
            $dados['alternativaE'],
            $dados['resposta_correta'],
        ]);

        header('Location: listar.php?msg=cadastrado');
        exit;
    }
}

require_once '../includes/header.php';
?>

<h1>Cadastrar questão</h1>

<?php if (!empty($erros)): ?>
    <div class="erro">
        <?php foreach ($erros as $erro): ?><div><?= htmlspecialchars($erro) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="cadastrar.php">
    <label>Pergunta
        <textarea name="pergunta" required><?= htmlspecialchars($dados['pergunta']) ?></textarea>
    </label>
    <label>Alternativa A
        <input type="text" name="alternativaA" value="<?= htmlspecialchars($dados['alternativaA']) ?>" maxlength="255" required>
    </label>
    <label>Alternativa B
        <input type="text" name="alternativaB" value="<?= htmlspecialchars($dados['alternativaB']) ?>" maxlength="255" required>
    </label>
    <label>Alternativa C
        <input type="text" name="alternativaC" value="<?= htmlspecialchars($dados['alternativaC']) ?>" maxlength="255" required>
    </label>
    <label>Alternativa D
        <input type="text" name="alternativaD" value="<?= htmlspecialchars($dados['alternativaD']) ?>" maxlength="255" required>
    </label>
    <label>Alternativa E
        <input type="text" name="alternativaE" value="<?= htmlspecialchars($dados['alternativaE']) ?>" maxlength="255" required>
    </label>
    <label>Resposta correta
        <select name="resposta_correta" required>
            <option value="">Selecione</option>
            <?php foreach (['A', 'B', 'C', 'D', 'E'] as $letra): ?>
                <option value="<?= $letra ?>" <?= $dados['resposta_correta'] === $letra ? 'selected' : '' ?>><?= $letra ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <p>
        <a href="listar.php" class="btn">Cancelar</a>
        <button type="submit">Cadastrar questão</button>
    </p>
</form>

<?php require_once '../includes/footer.php'; ?>
