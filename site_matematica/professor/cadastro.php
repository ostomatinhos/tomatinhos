<?php
require_once '../config/auth.php';
require_once '../config/conexao.php';

$raiz = '../';
$erros = [];
$dados = ['nome' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados['nome']  = trim($_POST['nome'] ?? '');
    $dados['email'] = trim($_POST['email'] ?? '');
    $senha          = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    if ($dados['nome'] === '') {
        $erros[] = 'O nome é obrigatório.';
    }

    if ($dados['email'] === '') {
        $erros[] = 'O e-mail é obrigatório.';
    } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'Informe um e-mail válido.';
    }

    if (strlen($senha) < 6) {
        $erros[] = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif ($senha !== $confirmarSenha) {
        $erros[] = 'As senhas não coincidem.';
    }

    if (empty($erros)) {
        $stmt = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$dados['email']]);
        if ($stmt->fetch()) {
            $erros[] = 'Já existe uma conta cadastrada com este e-mail.';
        }
    }

    if (empty($erros)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'professor')");
        $stmt->execute([$dados['nome'], $dados['email'], $senhaHash]);

        $_SESSION['usuario_id']   = $conexao->lastInsertId();
        $_SESSION['usuario_nome'] = $dados['nome'];
        $_SESSION['usuario_tipo'] = 'professor';

        header('Location: listar.php');
        exit;
    }
}

require_once '../includes/header.php';
?>

<h1>Cadastro de professor</h1>

<?php if (!empty($erros)): ?>
    <div class="erro">
        <?php foreach ($erros as $erro): ?><div><?= htmlspecialchars($erro) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="cadastro.php">
    <label>Nome
        <input type="text" name="nome" value="<?= htmlspecialchars($dados['nome']) ?>" required>
    </label>
    <label>E-mail
        <input type="email" name="email" value="<?= htmlspecialchars($dados['email']) ?>" required>
    </label>
    <label>Senha (mínimo 6 caracteres)
        <input type="password" name="senha" required>
    </label>
    <label>Confirmar senha
        <input type="password" name="confirmar_senha" required>
    </label>
    <p><button type="submit">Cadastrar</button></p>
</form>

<p>Já tem conta? <a href="login.php">Entrar</a></p>

<?php require_once '../includes/footer.php'; ?>
