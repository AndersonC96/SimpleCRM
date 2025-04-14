<?php include 'view/partials/header.php'; ?>
<h2>Clientes</h2>
<a href="index.php?url=clientes/criar">Novo Cliente</a>
<table>
  <tr><th>Nome</th><th>Telefone</th><th>Email</th><th>Ações</th></tr>
  <?php foreach ($clientes as $c): ?>
    <tr>
      <td><?= htmlspecialchars($c['nome']) ?></td>
      <td><?= $c['telefone'] ?></td>
      <td><?= $c['email'] ?></td>
      <td>
        <a href="index.php?url=clientes/editar&id=<?= $c['id'] ?>">Editar</a> |
        <a href="index.php?url=clientes/excluir&id=<?= $c['id'] ?>">Excluir</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include 'view/partials/footer.php'; ?>