<?php include 'view/partials/header.php'; ?>

<!-- Skeleton enquanto carrega -->
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

  <!-- Gráficos principais -->
  <div class="columns is-multiline">
    <div class="column is-half">
      <div class="box">
        <h2 class="subtitle is-6">NPS Corporativo</h2>
        <div id="npsChart"></div>
      </div>
    </div>
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
              <img class="is-rounded" src="<?= $r['avatar'] ?? 'public/img/avatar.jpg' ?>" onerror="this.src='public/img/avatar.jpg';">
            </figure>
            <h3 class="title is-6"><?= $r['nome'] ?></h3>
            <span class="tag is-medium <?= $r['nps'] >= 9 ? 'is-success' : ($r['nps'] >= 7 ? 'is-warning' : 'is-danger') ?> has-tooltip-bottom"
                  data-tooltip="Últimos 3 meses: 8.8 → 9.1 → <?= $r['nps'] ?>">
              <?= $r['nps'] ?> <i class="fas fa-arrow-right"></i>
            </span>
            <p class="is-size-7 mt-1">Taxa: <?= $r['total_respostas'] ?> respostas</p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Engajamento com dados reais -->
  <?php
    $enviadas = $resumo['total']['total_enviados'] ?? 0;
    $respondidas = $resumo['total']['total_respondidos'] ?? 0;
    $taxa = $enviadas > 0 ? round(($respondidas / $enviadas) * 100, 1) : 0;
  ?>
  <div class="box mt-5">
    <h2 class="subtitle is-5">Engajamento</h2>
    <div class="columns">
      <div class="column is-half">
        <p class="mb-1">Mensagens enviadas: <strong><?= number_format($enviadas, 0, ',', '.') ?></strong></p>
        <progress class="progress is-info" value="100" max="100"></progress>

        <p class="mb-1">Mensagens respondidas: <strong><?= number_format($respondidas, 0, ',', '.') ?></strong></p>
        <progress class="progress is-success" value="<?= $taxa ?>" max="100"><?= $taxa ?>%</progress>

        <p class="is-size-7 has-text-grey mt-2">Taxa de conversão: <strong><?= $taxa ?>%</strong></p>
      </div>
      <div class="column is-half">
        <div id="engajamentoChart"></div>
      </div>
    </div>
  </div>
</section>

<?php include 'view/partials/footer.php'; ?>