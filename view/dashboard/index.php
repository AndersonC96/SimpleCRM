<?php include 'view/partials/header.php'; ?>
<!-- Seção de Skeleton Loader -->
<div id="representantes-loading">
  <div class="columns is-multiline is-variable is-4">
    <?php for ($i = 0; $i < 4; $i++): ?>
      <div class="column is-one-quarter">
        <div class="box has-text-centered">
          <div class="skeleton skeleton-avatar mb-3"></div>
          <div class="skeleton skeleton-line" style="width: 60%; margin: 0 auto;"></div>
          <div class="skeleton skeleton-line" style="width: 40%; margin: 0.5rem auto;"></div>
        </div>
      </div>
    <?php endfor; ?>
  </div>
</div>
<section class="section">
  <div class="level">
    <div class="level-left">
      <h1 class="title is-4">Dashboard Corporativa</h1>
    </div>
    <div class="level-right">
      <label class="switch">
        <input type="checkbox" id="theme-toggle">
        <span class="check"></span> Tema Escuro
      </label>
    </div>
  </div>
  <div class="columns is-multiline">
    <!-- Gráfico NPS semicircular -->
    <div class="column is-half">
      <div class="box">
        <h2 class="subtitle is-6">NPS Corporativo</h2>
        <div id="npsChart"></div>
      </div>
    </div>
    <!-- Cards de comparativo -->
    <div class="column is-one-quarter">
      <div class="box has-text-centered">
        <p class="heading">Variação Mensal</p>
        <p class="title has-text-success">+12%</p>
        <span class="icon"><i class="fas fa-arrow-up"></i></span>
      </div>
    </div>
    <div class="column is-one-quarter">
      <div class="box has-text-centered">
        <p class="heading">Benchmark</p>
        <p class="title">65</p>
        <p class="subtitle is-7">Média do setor</p>
      </div>
    </div>
  </div>
  <!-- Representantes -->
  <div class="box mt-5">
    <h2 class="subtitle is-5">Representantes</h2>
    <div class="field is-grouped is-justify-content-space-between mb-4">
      <div class="control">
        <label class="label is-small">Ordenar por</label>
        <div class="select is-small">
          <select id="ordenar-representantes">
            <option value="nota">Maior NPS</option>
            <option value="respostas">Mais respostas</option>
            <option value="nome">A-Z</option>
          </select>
        </div>
      </div>
    </div>
    <div class="columns is-multiline is-variable is-4" id="grid-representantes" style="display: none;">
      <?php foreach ($representantes as $r): ?>
        <div class="column is-full-mobile is-one-third-tablet is-one-quarter-desktop representante"
             data-nota="<?= $r['nps'] ?>"
             data-nome="<?= $r['nome'] ?>"
             data-respostas="<?= $r['total_respostas'] ?>"
             data-area="<?= $r['area_atuacao'] ?>">
          <div class="box has-text-centered fade-in">
            <figure class="image is-96x96 is-inline-block mb-3">
              <img class="is-rounded" src="<?= $r['imagem_url'] ?? 'public/img/avatar.jpg' ?>" alt="Foto de <?= $r['nome'] ?>" onerror="this.onerror=null;this.src='public/img/avatar.jpg';">
            </figure>
            <h3 class="title is-6"><?= $r['nome'] ?></h3>
            <span class="tag is-medium 
              <?= $r['nps'] >= 9 ? 'is-success' : ($r['nps'] >= 7 ? 'is-warning' : 'is-danger') ?>
              has-tooltip-bottom"
              data-tooltip="Últimos 3 meses: 8.8 → 9.1 → <?= $r['nps'] ?>">
              <?= $r['nps'] ?> <i class="fas fa-arrow-right"></i>
            </span>
            <p class="is-size-7 mt-1">Taxa: <?= $r['total_respostas'] ?> respostas</p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- Métricas de Engajamento -->
  <div class="box mt-5">
    <h2 class="subtitle is-5">Engajamento</h2>
    <div class="columns">
      <!-- Barra dupla: Enviadas vs Respondidas -->
      <div class="column is-half">
        <div class="mb-4">
          <p class="mb-1">Mensagens enviadas: <strong>1.200</strong></p>
          <progress class="progress is-info" value="100" max="100">100%</progress>
          <p class="mb-1">Mensagens respondidas: <strong>880</strong></p>
          <progress class="progress is-success" value="73" max="100">73%</progress>
          <p class="is-size-7 has-text-grey mt-2">Taxa de conversão: <strong>73.3%</strong></p>
        </div>
        <div class="columns is-mobile is-multiline mt-3">
          <div class="column is-half">
            <p class="has-text-weight-semibold is-size-7">WhatsApp</p>
            <progress class="progress is-success is-small" value="600" max="800"></progress>
          </div>
          <div class="column is-half">
            <p class="has-text-weight-semibold is-size-7">Email</p>
            <progress class="progress is-warning is-small" value="280" max="400"></progress>
          </div>
        </div>
      </div>
      <!-- Gráfico de linhas -->
      <div class="column is-half">
        <div id="engajamentoChart"></div>
      </div>
    </div>
  </div>
</section>
<?php include 'view/partials/footer.php'; ?>
<!-- Inclusão do ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Script para gráficos e funcionalidades adicionais -->
<script>
  function getThemeColors() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    return {
      bg: isDark ? '#0d1117' : '#ffffff',
      text: isDark ? '#e6edf3' : '#1f2d3d',
      green: '#23d160',
      blue: '#3273dc'
    };
  }
  function renderNPSChart() {
    const colors = getThemeColors();
    new ApexCharts(document.querySelector("#npsChart"), {
      chart: {
        type: 'radialBar',
        height: 250,
        offsetY: -10,
        background: colors.bg,
        foreColor: colors.text
      },
      plotOptions: {
        radialBar: {
          startAngle: -90,
          endAngle: 90,
          hollow: { size: '70%' },
          dataLabels: {
            value: { fontSize: '30px' }
          }
        }
      },
      series: [68],
      colors: [colors.green]
    }).render();
  }
  function renderEngajamentoChart() {
    const colors = getThemeColors();
    new ApexCharts(document.querySelector("#engajamentoChart"), {
      chart: {
        type: 'line',
        height: 220,
        background: colors.bg,
        foreColor: colors.text,
        toolbar: { show: false }
      },
      series: [{
        name: 'Respostas',
        data: [120, 180, 150, 210, 190, 250, 300]
      }],
      xaxis: { categories: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'] },
      colors: [colors.blue],
      stroke: { width: 3, curve: 'smooth' },
      markers: { size: 4 }
    }).render();
  }
  function renderCharts() {
    renderNPSChart();
    renderEngajamentoChart();
  }
  // Tema toggle + gráfico update
  const toggle = document.getElementById('theme-toggle');
  toggle.addEventListener('change', () => {
    const theme = toggle.checked ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    location.reload(); // recarrega para aplicar nos gráficos
  });
  // Ordenação dinâmica
  document.getElementById('ordenar-representantes').addEventListener('change', function () {
    const tipo = this.value;
    const container = document.getElementById('grid-representantes');
    const cards = Array.from(container.querySelectorAll('.representante'));
    cards.sort((a, b) => {
      if (tipo === 'nota') {
        return parseFloat(b.dataset.nota) - parseFloat(a.dataset.nota);
      } else if (tipo === 'respostas') {
        return parseInt(b.dataset.respostas) - parseInt(a.dataset.respostas);
      } else if (tipo === 'nome') {
        return a.dataset.nome.localeCompare(b.dataset.nome);
      }
    });
    cards.forEach(card => container.appendChild(card));
  });
  // Carregamento e renderização
  window.addEventListener("DOMContentLoaded", () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    toggle.checked = savedTheme === 'dark';
    // Renderiza gráficos e remove loader
    renderCharts();
    document.getElementById("representantes-loading").style.display = "none";
    document.getElementById("grid-representantes").style.display = "flex";
  });
</script>
<!-- Estilos para skeleton -->
<style>
  .skeleton {
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.2s infinite linear;
    border-radius: 6px;
  }
  @keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
  }
  .skeleton-avatar {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    margin: 0 auto;
  }
  .skeleton-line {
    height: 1rem;
    margin: 0.5rem 0;
  }
</style>