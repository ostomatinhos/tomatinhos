<?php
require_once '../config/auth.php';
require_once '../config/conexao.php';

exigirAluno();

$raiz = '../';

// Só corrige se veio do formulário e se existe uma prova sorteada.
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['prova'])) {
    header('Location: prova1.php');
    exit;
}

$respostas = $_POST['resposta'] ?? [];
$acertos = 0;
$resultados = [];

// Percorre as questões sorteadas (guardadas na sessão) e compara com o gabarito do BANCO.
foreach ($_SESSION['prova'] as $idQuestao) {
    $stmt = $conexao->prepare("SELECT * FROM questoes WHERE id = ?");
    $stmt->execute([$idQuestao]);
    $questao = $stmt->fetch();

    if (!$questao) {
        continue;
    }

    $marcada = $respostas[$idQuestao] ?? '';

    if ($marcada === $questao['resposta_correta']) {
        $acertos++;
    }

    $resultados[] = [
        'pergunta' => $questao['pergunta'],
        'marcada'  => $marcada,
        'correta'  => $questao['resposta_correta'],
    ];
}

$total = count($resultados);
$erros = $total - $acertos;
$nota  = $total > 0 ? $acertos * 10 / $total : 0;

// Apaga a prova da sessão: não dá para enviar a mesma prova de novo.
unset($_SESSION['prova']);

require_once '../includes/header.php';
?>

<h1>Resultado</h1>

<p>Acertos: <strong><?= $acertos ?></strong></p>
<p>Erros (incluindo questões em branco): <strong><?= $erros ?></strong></p>
<p>Nota (0 a 10): <strong><?= number_format($nota, 1, ',', '') ?></strong></p>

<h2>Gabarito</h2>
<table>
    <tr><th>#</th><th>Questão</th><th>Sua resposta</th><th>Resposta correta</th></tr>
    <?php foreach ($resultados as $indice => $r): ?>
        <tr>
            <td><?= $indice + 1 ?></td>
            <td><?= htmlspecialchars($r['pergunta']) ?></td>
            <td class="<?= $r['marcada'] === $r['correta'] ? 'certa' : 'errada' ?>">
                <?= $r['marcada'] !== '' ? htmlspecialchars($r['marcada']) : 'em branco' ?>
            </td>
            <td><?= htmlspecialchars($r['correta']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="prova1.php" class="btn">Fazer nova prova</a></p>

<?php require_once '../includes/footer.php'; ?>
