<?php
    // Inicia a sessão, se necessário
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Dashboard - Administrador";
    // Inclui os arquivos parciais do layout (header, navbar)
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Dashboard do Administrador</h1>
    <!-- Indicadores principais -->
    <?php if (isset($stats) && is_array($stats) && count($stats) > 0): ?>
        <div class="row">
            <!-- Total de Usuários -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Usuários</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($stats['total_users'] ?? '0') ?></h5>
                        <p class="card-text">Total de usuários cadastrados.</p>
                    </div>
                </div>
            </div>
            <!-- Total de Clientes -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Clientes</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($stats['total_clients'] ?? '0') ?></h5>
                        <p class="card-text">Total de clientes cadastrados.</p>
                    </div>
                </div>
            </div>
            <!-- Total de Campanhas -->
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Campanhas</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($stats['total_campaigns'] ?? '0') ?></h5>
                        <p class="card-text">Total de campanhas criadas.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Nenhum dado disponível.</p>
        </div>
    <?php endif; ?>
    <!-- Exibe o NPS médio -->
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <h4>NPS Médio: <?= isset($nps) && is_numeric($nps) ? htmlspecialchars($nps) : 'N/A' ?></h4>
            </div>
        </div>
    </div>
    <!-- Gráfico de Tendência do NPS utilizando Chart.js -->
    <div class="row">
        <div class="col-md-12">
            <canvas id="npsChart"></canvas>
        </div>
    </div>
    <!-- Link para Logs e Monitoramento -->
    <div class="row mt-4">
        <div class="col-md-12">
            <a href="index.php?url=admin/logs" class="btn btn-secondary">Visualizar Logs e Histórico</a>
        </div>
    </div>
</div>
<!-- Inclusão do Chart.js via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // As variáveis $npsLabels e $npsData devem ser definidas no controlador.
    // Caso não estejam definidas, define valores padrão para evitar erros.
    const npsLabels = <?= json_encode(isset($npsLabels) && is_array($npsLabels) ? $npsLabels : ['Sem dados']) ?>;
    const npsData = <?= json_encode(isset($npsData) && is_array($npsData) ? $npsData : [0]) ?>;
    const ctx = document.getElementById('npsChart').getContext('2d');
    const npsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: npsLabels,
            datasets: [{
                label: 'Tendência do NPS',
                data: npsData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 100
                }
            },
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    });
</script>
<?php require 'app/views/partials/footer.php'; ?>