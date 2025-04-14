<?php include 'view/partials/header.php'; ?>
<h2>Usuários</h2>
<a href="index.php?url=usuarios/create">Novo Usuário</a>
<table>
  <tr><th>Nome</th><th>Email</th><th>Tipo</th><th>Status</th><th>Ações</th></tr>
  <?php foreach ($usuarios as $u): ?>
    <tr>
      <td><?= htmlspecialchars($u['nome']) ?></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td><?= $u['tipo'] ?></td>
      <td><?= $u['ativo'] ? 'Ativo' : 'Inativo' ?></td>
      <td>
        <a href="index.php?url=usuarios/edit&id=<?= $u['id'] ?>">Editar</a> |
        <a href="index.php?url=usuarios/delete&id=<?= $u['id'] ?>">Excluir</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php include 'view/partials/footer.php'; ?>