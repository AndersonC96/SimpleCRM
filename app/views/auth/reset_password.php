<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Redefinir Senha - SimpleCRM";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
    // Recupera o token da query string ou do POST
    $token = isset($_GET['token']) ? trim($_GET['token']) : (isset($_POST['token']) ? trim($_POST['token']) : '');
    // Se o token não estiver presente, redireciona com mensagem de erro
    if (empty($token)) {
        $_SESSION['errors'][] = "Token inválido ou expirado.";
        header("Location: index.php?url=auth/forgot_password");
        exit;
    }
?>
<div class="container mt-5">
    <h1>Redefinir Senha</h1>
    <!-- Exibe mensagens de erro, se existirem -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; 
            unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <!-- Formulário para redefinir a senha -->
    <form action="index.php?url=auth/reset_password" method="POST" novalidate>
        <!-- Campo oculto para enviar o token -->
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <div class="mb-3">
            <label for="password" class="form-label">Nova Senha</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="form-control" 
                placeholder="Digite sua nova senha" 
                required 
                minlength="6">
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmar Nova Senha</label>
            <input 
                type="password" 
                name="confirm_password" 
                id="confirm_password" 
                class="form-control" 
                placeholder="Confirme sua nova senha" 
                required 
                minlength="6">
        </div>
        <button type="submit" class="btn btn-primary">Redefinir Senha</button>
    </form>
</div>
<?php
    // Inclui o footer
    require 'app/views/partials/footer.php';
?>