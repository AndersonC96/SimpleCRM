<?php include 'view/partials/header.php'; ?>
<section class="section">
  <div class="container">
    <h1 class="title is-4">Gestão de Usuários</h1>
    <!-- Cards de Resumo -->
    <div class="columns is-multiline mb-5">
      <div class="column is-one-third">
        <div class="box has-text-centered">
          <p class="heading">Total de Usuários</p>
          <p class="title"><?= $resumo['total'] ?></p>
        </div>
      </div>
      <div class="column is-one-third">
        <div class="box has-text-centered">
          <p class="heading">Usuários Ativos</p>
          <p class="title has-text-success"><?= $resumo['ativos'] ?></p>
        </div>
      </div>
      <div class="column is-one-third">
        <div class="box has-text-centered">
          <p class="heading">Novos (últimos 30 dias)</p>
          <p class="title has-text-info"><?= $resumo['recentes'] ?></p>
        </div>
      </div>
    </div>
    <!-- Tabela de Usuários -->
    <table class="table is-striped is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Email</th>
          <th>Tipo</th>
          <th>Status</th>
          <th>Criado em</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $usuario): ?>
          <tr>
            <td><?= htmlspecialchars($usuario['nome']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td><?= ucfirst($usuario['tipo']) ?></td>
            <td>
              <span class="tag is-<?= $usuario['ativo'] ? 'success' : 'danger' ?>">
                <?= $usuario['ativo'] ? 'Ativo' : 'Inativo' ?>
              </span>
            </td>
            <td><?= date('d/m/Y', strtotime($usuario['criado_em'])) ?></td>
            <td>
              <a href="index.php?url=usuarios/edit&id=<?= $usuario['id'] ?>" class="button is-small is-info">Editar</a>
              <a href="index.php?url=usuarios/delete&id=<?= $usuario['id'] ?>" class="button is-small is-danger" onclick="return confirm('Excluir este usuário?')">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="index.php?url=usuarios/create" class="button is-primary mt-4">Novo Usuário</a>
  </div>
</section>
<?php include 'view/partials/footer.php'; ?>