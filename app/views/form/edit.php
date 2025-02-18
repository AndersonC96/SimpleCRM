<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Editar Formulário - SimpleCRM";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
    // Verifica se a variável $form está definida (vinda do controlador)
    if (!isset($form) || empty($form)) {
        echo "<div class='container mt-5'><p>Formulário não encontrado.</p></div>";
        require 'app/views/partials/footer.php';
        exit;
    }
?>
<div class="container mt-5">
    <h1>Editar Formulário</h1>
    <!-- Exibe mensagens de erro, se existirem -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach;
                  unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <!-- Formulário para edição -->
    <form action="index.php?url=form/edit/<?= htmlspecialchars($form['id']) ?>" method="POST" novalidate>
        <div class="mb-3">
            <label for="form_name" class="form-label">Nome do Formulário</label>
            <input type="text" name="form_name" id="form_name" class="form-control" value="<?= htmlspecialchars($form['name']) ?>" required minlength="2">
        </div>
        <div class="mb-3">
            <label for="form_content" class="form-label">Conteúdo do Formulário</label>
            <textarea name="form_content" id="form_content" class="form-control" rows="5" required minlength="5"><?= htmlspecialchars($form['content']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar Formulário</button>
    </form>
</div>
<?php require 'app/views/partials/footer.php'; ?>