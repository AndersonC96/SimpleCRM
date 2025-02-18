<?php
    // Inicia a sessão, se necessário
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Resultados da Pesquisa (NPS) - SimpleCRM";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Resultados da Pesquisa (NPS)</h1>
    <!-- Formulário de Filtros -->
    <form action="index.php?url=survey/results" method="GET" class="mb-4" novalidate>
        <div class="row">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Data de Início</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">Data de Término</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>">
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-secondary">Filtrar</button>
            </div>
        </div>
    </form>
    <!-- Exibição de Mensagens de Erro -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <?php if ($surveyResults): ?>
        <!-- Exibição dos Indicadores -->
        <div class="mb-4">
            <h2>NPS: <?= htmlspecialchars($surveyResults['nps']) ?></h2>
            <p>Total de respostas: <?= htmlspecialchars($surveyResults['total']) ?></p>
            <p>Promotores: <?= htmlspecialchars($surveyResults['promoters']) ?></p>
            <p>Detratores: <?= htmlspecialchars($surveyResults['detractors']) ?></p>
            <p>Neutros: <?= htmlspecialchars($surveyResults['neutrals']) ?></p>
        </div>
        <!-- Gráfico dos Dados (usando Chart.js) -->
        <div class="mb-4">
            <canvas id="npsChart"></canvas>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Nenhum dado disponível para os filtros aplicados.</p>
        </div>
    <?php endif; ?>
</div>
<!-- Inclusão do Chart.js via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php if ($surveyResults): ?>
    // Dados para o gráfico: Promotores, Neutros e Detratores
    const labels = ["Promotores", "Neutros", "Detratores"];
    const dataValues = [
        <?= htmlspecialchars($surveyResults['promoters']) ?>,
        <?= htmlspecialchars($surveyResults['neutrals']) ?>,
        <?= htmlspecialchars($surveyResults['detractors']) ?>
    ];

    const ctx = document.getElementById('npsChart').getContext('2d');
    const npsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Número de Respostas',
                data: dataValues,
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',  // Promotores
                    'rgba(255, 206, 86, 0.2)',   // Neutros
                    'rgba(255, 99, 132, 0.2)'    // Detratores
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
<?php endif; ?>
</script>
<?php require 'app/views/partials/footer.php'; ?>