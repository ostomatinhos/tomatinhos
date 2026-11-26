<?php
require_once 'config/auth.php';
$raiz = '';
require_once 'includes/header.php';
?>

<h1>Simulados de Matemática</h1>

<p>
    Plataforma para aprender matemática e testar o que você aprendeu.
    São três aulas em sequência e um simulado com correção automática.
</p>

<?php if (ehAluno()): ?>
    <p>
        <a href="aluno/aula1.php" class="btn">Ir para as aulas</a>
        <a href="aluno/prova1.php" class="btn">Fazer o simulado</a>
    </p>
<?php elseif (ehProfessor()): ?>
    <p><a href="professor/listar.php" class="btn">Gerenciar questões</a></p>
<?php else: ?>
    <p>
        <a href="aluno/login.php" class="btn">Começar / Entrar</a>
        <a href="aluno/cadastro.php" class="btn">Cadastrar</a>
        <a href="professor/login.php" class="btn">Área do professor</a>
    </p>
<?php endif; ?>

<h2>Aulas</h2>
<p>As aulas são liberadas em ordem: ao finalizar uma aula, a próxima é liberada.</p>

<div class="cartao">
    <h3>Aula 1</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
</div>
<div class="cartao">
    <h3>Aula 2</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
</div>
<div class="cartao">
    <h3>Aula 3</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
</div>

<h2>Simulado</h2>
<p>
    Cada prova tem 10 questões sorteadas aleatoriamente, com alternativas de A até E.
    Ao enviar, a prova é corrigida e você vê acertos, erros e nota.
</p>

<?php require_once 'includes/footer.php'; ?>
