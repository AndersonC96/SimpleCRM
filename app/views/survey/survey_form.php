<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Pesquisa de Satisfação (NPS) - SimpleCRM";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Pesquisa de Satisfação (NPS)</h1>
    <!-- Exibe mensagens de erro, se houver -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; 
                  unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <!-- Formulário de Pesquisa -->
    <form action="index.php?url=survey/submit" method="POST" novalidate>
        <div class="mb-3">
            <label for="rating" class="form-label">Nota (0 a 10)</label>
            <input 
                type="number" 
                name="rating" 
                id="rating" 
                class="form-control" 
                placeholder="Digite sua nota" 
                required 
                min="0" 
                max="10" 
                step="0.1">
        </div>
        <div class="mb-3">
            <label for="comment" class="form-label">Comentário (opcional, até 500 caracteres)</label>
            <textarea 
                name="comment" 
                id="comment" 
                class="form-control" 
                rows="4" 
                placeholder="Digite seu comentário (opcional)" 
                maxlength="500"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Pesquisa</button>
    </form>
</div>
<?php require 'app/views/partials/footer.php'; ?>