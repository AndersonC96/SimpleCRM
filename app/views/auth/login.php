<?php
    // Inicia a sessão (se ainda não estiver iniciada)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página
    $title = "Login - SimpleCRM";
    // Inclui os arquivos parciais para o layout
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Login</h1>
    <!-- Exibe mensagens de erro, se existirem -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <!-- Exibe mensagem de sucesso, se existir -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <form action="index.php?url=auth/login" method="POST" novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Usuário</label>
            <input 
                type="text" 
                name="username" 
                id="username" 
                class="form-control" 
                placeholder="Digite seu usuário" 
                required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control" 
                placeholder="Digite sua senha" 
                required>
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
    <div class="mt-3">
        <a href="index.php?url=auth/forgot_password">Esqueceu a senha?</a> | 
        <a href="index.php?url=auth/register">Registrar novo usuário</a>
    </div>
</div>
<?php require 'app/views/partials/footer.php'; ?>