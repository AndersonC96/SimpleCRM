<?php include 'view/partials/header.php'; ?>
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

  <div class="box mt-5">
  <h2 class="subtitle is-5">Representantes</h2>
  
<!-- Filtro + Ordenador -->
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

<!-- Grid real de representantes -->
<div class="columns is-multiline is-variable is-4" id="grid-representantes">
  <?php foreach ($representantes as $r): ?>
    <div class="column is-full-mobile is-one-third-tablet is-one-quarter-desktop representante"
         data-nota="<?= $r['nps'] ?>"
         data-nome="<?= $r['nome'] ?>"
         data-respostas="<?= $r['total_respostas'] ?>"
         data-area="<?= $r['area_atuacao'] ?>"
         data-area="<?= $r['imagem_url'] ?>">
      <div class="box has-text-centered fade-in">
        <figure class="image is-96x96 is-inline-block mb-3">
          <img class="is-rounded" src="<?= $r['imagem_url'] ?>" alt="Avatar">
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


  <!-- Representantes (mock básico por enquanto) -->
  <div class="box mt-5">
    <h2 class="subtitle is-5">Representantes</h2>

    <div class="field is-grouped is-justify-content-space-between">
  <div class="control">
    <div class="select is-small">
      <select id="ordenar-representantes">
        <option value="nota">Maior NPS</option>
        <option value="respostas">Mais respostas</option>
        <option value="nome">A-Z</option>
      </select>
    </div>
  </div>
</div>



    <div class="columns is-multiline is-variable is-4">
      <?php for ($i = 0; $i < 4; $i++): ?>
        <!--<div class="column is-full-mobile is-one-third-tablet is-one-quarter-desktop">
          <div class="box has-text-centered">
            <figure class="image is-96x96 is-inline-block mb-3">
              <img class="is-rounded" src="public/img/avatar<?= $i + 1 ?>.jpg">
            </figure>
            <h3 class="title is-6">Nome Representante <?= $i + 1 ?></h3>
            <span class="tag is-medium is-success">9.1 <i class="fas fa-arrow-up"></i></span>
            <p class="is-size-7 mt-1">Taxa: 81%</p>
          </div>
        </div>-->
        <div class="column is-full-mobile is-one-third-tablet is-one-quarter-desktop representante" data-nota="9.1" data-nome="Ana" data-respostas="82">
  <div class="box has-text-centered fade-in">
    <figure class="image is-96x96 is-inline-block mb-3">
      <img class="is-rounded" src="public/img/avatar<?= $i + 1 ?>.jpg">
    </figure>
    <h3 class="title is-6">Nome Representante <?= $i + 1 ?></h3>

    <!-- Tooltip com histórico -->
    <div class="has-tooltip-arrow has-tooltip-bottom" data-tooltip="Últimos 3 meses: 8.9, 9.2, 9.1">
      <span class="tag is-medium is-success">9.1 <i class="fas fa-arrow-up"></i></span>
    </div>

    <p class="is-size-7 mt-1">Taxa: 82%</p>
  </div>
</div>
      <?php endfor; ?>
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  const chart = new ApexCharts(document.querySelector("#npsChart"), {
    chart: {
      type: 'radialBar',
      height: 250,
      offsetY: -10
    },
    plotOptions: {
      radialBar: {
        startAngle: -90,
        endAngle: 90,
        hollow: { size: '70%' },
        dataLabels: {
          name: { show: false },
          value: { fontSize: '30px', show: true }
        }
      }
    },
    series: [68],
    colors: ['#23d160']
  });
  chart.render();
  // Tema persistente
  const toggle = document.getElementById('theme-toggle');
  const root = document.documentElement;
  toggle.addEventListener('change', () => {
    const theme = toggle.checked ? 'dark' : 'light';
    root.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
  });
  window.onload = () => {
    const saved = localStorage.getItem('theme') || 'light';
    root.setAttribute('data-theme', saved);
    toggle.checked = saved === 'dark';
  }
</script>
<script>
  const engajamentoChart = new ApexCharts(document.querySelector("#engajamentoChart"), {
    chart: {
      type: 'line',
      height: 220,
      toolbar: { show: false }
    },
    series: [{
      name: 'Respostas',
      data: [120, 180, 150, 210, 190, 250, 300]
    }],
    xaxis: {
      categories: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom']
    },
    colors: ['#3273dc'],
    stroke: {
      width: 3,
      curve: 'smooth'
    },
    markers: {
      size: 4
    }
  });

  engajamentoChart.render();
</script>
<script>
document.getElementById('ordenar-representantes').addEventListener('change', function () {
  const tipo = this.value;
  const container = document.querySelector('.columns.is-multiline');
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
</script>
