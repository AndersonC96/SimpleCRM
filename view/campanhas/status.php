<?php include 'view/partials/header.php'; ?>
<h2 class="title is-4">Status dos Envios</h2>
<table class="table is-fullwidth is-striped">
  <thead>
    <tr>
      <th>Nome</th>
      <th>Telefone</th>
      <th>Status</th>
      <th>Enviado em</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($envios as $e): ?>
      <tr>
        <td><?= htmlspecialchars($e['nome']) ?></td>
        <td><?= $e['telefone'] ?></td>
        <td>
          <?php if ($e['status'] === 'enviado'): ?>
            <span class="tag is-success">Enviado</span>
          <?php elseif ($e['status'] === 'falha'): ?>
            <span class="tag is-danger">Falha</span>
          <?php else: ?>
            <span class="tag is-warning">Pendente</span>
          <?php endif; ?>
        </td>
        <td><?= $e['enviado_em'] ? date('d/m/Y H:i', strtotime($e['enviado_em'])) : '-' ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<a class="button" href="index.php?url=campanhas">Voltar</a>
<?php include 'view/partials/footer.php'; ?>