<?php include 'view/partials/header.php'; ?>
<h2>Campanhas</h2>
<a href="index.php?url=campanhas/criar">Nova Campanha</a>
<table>
  <tr><th>Nome</th><th>Canal</th><th>Template</th><th>Status</th><th>Ações</th></tr>
  <?php foreach ($campanhas as $c): ?>
    <tr>
      <td><?= htmlspecialchars($c['nome']) ?></td>
      <td><?= $c['canal'] ?></td>
      <td><?= $c['template'] ?></td>
      <td><?= $c['status'] ?></td>
      <td>
        <a href="index.php?url=campanhas/disparar&id=<?= $c['id'] ?>">Disparar</a> |
        <a href="index.php?url=campanhas/status&id=<?= $c['id'] ?>">Status</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include 'view/partials/footer.php'; ?>