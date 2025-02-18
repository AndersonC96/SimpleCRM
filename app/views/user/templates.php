<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $title = "Templates de Mensagens - SimpleCRM";
    // Inclui os parciais de layout
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Gerenciar Templates de Mensagens</h1>
    <!-- Instruções sobre placeholders -->
    <div class="alert alert-info">
        <p>Você pode utilizar os seguintes placeholders no conteúdo do template:</p>
        <ul>
            <li><code>{NOME}</code> – Nome do cliente</li>
            <li><code>{DATA}</code> – Data atual ou da campanha</li>
            <li><code>{CAMPANHA}</code> – Nome da campanha</li>
            <!-- Adicionar outros conforme necessário -->
        </ul>
    </div>
    <!-- Exibe mensagens de erro ou sucesso -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; 
                  unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <!-- Formulário para criação/edição do template -->
    <form action="index.php?url=user/templates" method="POST" novalidate>
        <div class="mb-3">
            <label for="template_name" class="form-label">Nome do Template</label>
            <input type="text" name="template_name" id="template_name" class="form-control" placeholder="Ex: Convite para Pesquisa" required minlength="2">
        </div>
        <div class="mb-3">
            <label for="template_content" class="form-label">Conteúdo do Template</label>
            <textarea name="template_content" id="template_content" class="form-control" rows="6" placeholder="Digite o conteúdo do template, utilizando os placeholders quando necessário" required minlength="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Template</button>
    </form>
</div>
<?php require 'app/views/partials/footer.php'; ?>