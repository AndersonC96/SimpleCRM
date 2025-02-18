<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Obrigado - Pesquisa de Satisfação";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Obrigado!</h1>
    <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php else: ?>
        <p>Sua resposta foi registrada com sucesso. Agradecemos pelo seu tempo e feedback.</p>
    <?php endif; ?>
    <a href="index.php?url=home/index" class="btn btn-primary">Voltar para Home</a>
</div>
<?php require 'app/views/partials/footer.php'; ?>