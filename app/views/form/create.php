<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Criar Formulário - SimpleCRM";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Criar Novo Formulário</h1>
    <!-- Exibe mensagens de erro, se existirem -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach;
                  unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <!-- Formulário para criação de formulário -->
    <form action="index.php?url=form/create" method="POST" novalidate>
        <div class="mb-3">
            <label for="form_name" class="form-label">Nome do Formulário</label>
            <input type="text" name="form_name" id="form_name" class="form-control" placeholder="Digite o nome do formulário" required minlength="2">
        </div>
        <div class="mb-3">
            <label for="form_content" class="form-label">Conteúdo do Formulário</label>
            <textarea name="form_content" id="form_content" class="form-control" rows="5" placeholder="Digite o conteúdo do formulário" required minlength="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Criar Formulário</button>
    </form>
</div>
<?php require 'app/views/partials/footer.php'; ?>