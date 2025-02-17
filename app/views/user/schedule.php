<?php
    // Inicia a sessão, se necessário
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Agendar Mensagens - Usuário";
    // Inclui os arquivos parciais de layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Agendar Mensagens</h1>
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
    <!-- Formulário para agendamento de mensagem -->
    <form action="index.php?url=user/schedule" method="POST" novalidate>
        <div class="mb-3">
            <label for="schedule_date" class="form-label">Data de Agendamento</label>
            <input type="date" name="schedule_date" id="schedule_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="schedule_time" class="form-label">Horário de Agendamento</label>
            <input type="time" name="schedule_time" id="schedule_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Mensagem</label>
            <textarea name="message" id="message" class="form-control" rows="4" placeholder="Digite sua mensagem" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Agendar Mensagem</button>
    </form>
</div>
<?php
    // Inclui o footer
    require 'app/views/partials/footer.php';
?>