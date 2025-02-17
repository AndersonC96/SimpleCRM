<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Dashboard - Administrador";
    // Inclui os arquivos parciais de header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Dashboard do Administrador</h1>
    <?php if (isset($stats) && is_array($stats) && count($stats) > 0): ?>
        <div class="row">
            <!-- Card para total de usuários -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Usuários</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($stats['total_users'] ?? 'N/A') ?></h5>
                        <p class="card-text">Total de usuários cadastrados.</p>
                    </div>
                </div>
            </div>
            <!-- Card para total de clientes -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Clientes</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($stats['total_clients'] ?? 'N/A') ?></h5>
                        <p class="card-text">Total de clientes cadastrados.</p>
                    </div>
                </div>
            </div>
            <!-- Card para total de campanhas -->
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Campanhas</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($stats['total_campaigns'] ?? 'N/A') ?></h5>
                        <p class="card-text">Total de campanhas criadas.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Exibe o NPS se estiver definido e for numérico -->
        <?php if (isset($nps) && is_numeric($nps)): ?>
            <div class="mt-4">
                <h2>NPS: <?= htmlspecialchars($nps) ?></h2>
            </div>
        <?php else: ?>
            <div class="mt-4">
                <h2>NPS: N/A</h2>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Nenhum dado disponível.</p>
        </div>
    <?php endif; ?>
</div>
<?php
    // Inclui o footer
    require 'app/views/partials/footer.php';
?>