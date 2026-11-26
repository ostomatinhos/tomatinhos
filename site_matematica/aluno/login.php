<?php
require_once '../config/auth.php';
require_once '../config/conexao.php';

$raiz = '../';
$erros = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {
        $erros[] = 'Preencha e-mail e senha.';
    }

    if (empty($erros)) {
        $stmt = $conexao->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ? AND tipo = 'aluno'");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            $erros[] = 'E-mail ou senha inválidos.';
        } else {
            $_SESSION['usuario_id']   = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_tipo'] = 'aluno';

            header('Location: aula1.php');
            exit;
        }
    }
}

require_once '../includes/header.php';
?>

<h1>Entrar como aluno</h1>

<?php if (!empty($erros)): ?>
    <div class="erro">
        <?php foreach ($erros as $erro): ?><div><?= htmlspecialchars($erro) ?></div><?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" action="login.php">
    <label>E-mail
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
    </label>
    <label>Senha
        <input type="password" name="senha" required>
    </label>
    <p><button type="submit">Entrar</button></p>
</form>

<p>Não tem conta? <a href="cadastro.php">Cadastrar</a></p>

<?php require_once '../includes/footer.php'; ?>
