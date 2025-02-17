<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Contato - SimpleCRM";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Contato</h1>
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
    <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <!-- Formulário de contato -->
    <form action="index.php?url=home/contact" method="POST" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control" 
                placeholder="Digite seu nome" 
                required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-control" 
                placeholder="Digite seu email" 
                required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Mensagem</label>
            <textarea 
                name="message" 
                id="message" 
                class="form-control" 
                rows="5" 
                placeholder="Digite sua mensagem" 
                required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<?php
    // Inclui o footer
    require 'app/views/partials/footer.php';
?>