<?php
    // Inicia a sessão, se necessário
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Excluir Formulário - SimpleCRM";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
    // Verifica se a variável $form está definida e contém os dados necessários
    if (!isset($form) || empty($form)) {
        echo "<div class='container mt-5'><p>Formulário não encontrado.</p></div>";
        require 'app/views/partials/footer.php';
        exit;
    }
?>
<div class="container mt-5">
    <h1>Excluir Formulário</h1>
    <p>Tem certeza que deseja excluir o formulário <strong><?= htmlspecialchars($form['name']) ?></strong>?</p>
    <!-- Formulário de confirmação para exclusão -->
    <form action="index.php?url=form/delete/<?= htmlspecialchars($form['id']) ?>" method="POST">
        <input type="hidden" name="action" value="delete">
        <button type="submit" class="btn btn-danger" onclick="return confirm('Esta ação não pode ser desfeita. Confirma a exclusão?');">
            Sim, excluir
        </button>
        <a href="index.php?url=form/index" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php require 'app/views/partials/footer.php'; ?>