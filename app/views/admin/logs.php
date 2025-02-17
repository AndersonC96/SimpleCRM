<?php
    // Inicia a sessão, se necessário
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Logs e Histórico de Atividades - Administrador";
    // Inclui os arquivos parciais do layout
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Logs e Histórico de Atividades</h1>
    <!-- Formulário para filtrar os logs -->
    <form action="index.php?url=admin/logs" method="GET" class="mb-4" novalidate>
        <div class="mb-3">
            <label for="filter" class="form-label">Filtrar por mensagem:</label>
            <input type="text" name="filter" id="filter" class="form-control" placeholder="Digite uma palavra-chave">
        </div>
        <button type="submit" class="btn btn-secondary">Filtrar</button>
    </form>
    <?php if (isset($logs) && is_array($logs) && !empty($logs)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mensagem</th>
                    <th>Data/Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['id']) ?></td>
                        <td><?= htmlspecialchars($log['message']) ?></td>
                        <td><?= htmlspecialchars($log['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Nenhum log encontrado.</p>
        </div>
    <?php endif; ?>
</div>
<?php require 'app/views/partials/footer.php'; ?>