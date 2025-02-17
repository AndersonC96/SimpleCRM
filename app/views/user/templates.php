<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Templates de Mensagem - Usuário";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Gerenciar Templates de Mensagem</h1>
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
    <!-- Formulário para criar ou editar um template -->
    <form action="index.php?url=user/templates" method="POST" novalidate>
        <div class="mb-3">
            <label for="template_name" class="form-label">Nome do Template</label>
            <input type="text" name="template_name" id="template_name" class="form-control" placeholder="Digite o nome do template" required minlength="2">
        </div>
        <div class="mb-3">
            <label for="template_content" class="form-label">Conteúdo do Template</label>
            <textarea name="template_content" id="template_content" class="form-control" rows="5" placeholder="Digite o conteúdo do template" required minlength="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Template</button>
    </form>
</div>
<?php
    // Inclui o footer
    require 'app/views/partials/footer.php';
?>