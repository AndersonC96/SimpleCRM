<?php
    // Inicia a sessão, se necessário
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Recuperar Senha - SimpleCRM";
    // Inclui os arquivos parciais do layout (header, navbar)
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Recuperar Senha</h1>
    <!-- Exibe mensagens de erro, se existirem -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; 
            unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <!-- Exibe mensagem de sucesso, se existir -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <form action="index.php?url=auth/forgot_password" method="POST" novalidate>
        <div class="mb-3">
            <label for="email" class="form-label">Informe seu email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control" 
                placeholder="Digite seu email" 
                required>
        </div>
        <button type="submit" class="btn btn-primary">Recuperar Senha</button>
    </form>
    <div class="mt-3">
        <a href="index.php?url=auth/login">Voltar para Login</a>
    </div>
</div>
<?php 
    // Inclui o footer
    require 'app/views/partials/footer.php';
?>