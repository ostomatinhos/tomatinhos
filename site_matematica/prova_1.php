
<?php
require_once 'conexao.php';

$sql = "SELECT * FROM questoes ORDER BY RAND() LIMIT 10";

$stmt = $conexao->prepare($sql);
$stmt->execute();

$questoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Prova 1</title>
</head>
<body>

<h1>Prova de Matrizes</h1>

<?php foreach ($questoes as $indice => $questao): ?>

    <h3>
        <?= ($indice + 1) . '. ' . htmlspecialchars($questao['pergunta']) ?>
    </h3>

    <p>A) <?= htmlspecialchars($questao['alternativaA']) ?></p>
    <p>B) <?= htmlspecialchars($questao['alternativaB']) ?></p>
    <p>C) <?= htmlspecialchars($questao['alternativaC']) ?></p>
    <p>D) <?= htmlspecialchars($questao['alternativaD']) ?></p>
    <p>E) <?= htmlspecialchars($questao['alternativaE'] ?? '') ?></p>

    <hr>

<?php endforeach; ?>

</body>
</html>
