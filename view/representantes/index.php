<?php include 'view/partials/header.php'; ?>
<h2 class="title is-4">Representantes</h2>
<a class="button is-primary mb-4" href="index.php?url=representantes/create">
  <span class="icon"><i class="fas fa-plus"></i></span>
  <span>Novo Representante</span>
</a>
<table class="table is-fullwidth is-striped is-hoverable">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Área de Atuação</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($representantes as $r): ?>
      <tr>
        <td><?= $r['id'] ?></td>
        <td><?= htmlspecialchars($r['nome']) ?></td>
        <td><?= htmlspecialchars($r['area_atuacao']) ?></td>
        <td>
          <a href="index.php?url=representantes/edit&id=<?= $r['id'] ?>" class="button is-small is-info">Editar</a>
          <a href="index.php?url=representantes/delete&id=<?= $r['id'] ?>" class="button is-small is-danger" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include 'view/partials/footer.php'; ?>