<?php include 'view/partials/header.php'; ?>
<section class="section">
  <div class="columns is-multiline">
    <!-- Card Total -->
    <div class="column is-one-third">
      <div class="box has-text-centered">
        <p class="heading">Total de Usuários</p>
        <p class="title"><?= $totalUsuarios ?></p>
      </div>
    </div>

    <!-- Card Ativos -->
    <div class="column is-one-third">
      <div class="box has-text-centered has-text-success">
        <p class="heading">Ativos</p>
        <p class="title"><?= $usuariosAtivos ?></p>
      </div>
    </div>

    <!-- Card Novos (últimos 30 dias) -->
    <div class="column is-one-third">
      <div class="box has-text-centered has-text-info">
        <p class="heading">Novos (30 dias)</p>
        <p class="title"><?= $novosUsuarios ?></p>
      </div>
    </div>
  </div>

  <!-- Filtro e busca -->
  <form method="get" class="field has-addons mb-4">
    <div class="control is-expanded">
      <input type="text" class="input" name="busca" placeholder="Buscar por nome ou e-mail..." value="<?= $_GET['busca'] ?? '' ?>">
    </div>
    <div class="control">
      <button type="submit" class="button is-info">Buscar</button>
    </div>
  </form>

  <!-- Tabela de usuários -->
  <div class="table-container">
    <table class="table is-fullwidth is-hoverable is-bordered">
      <thead>
        <tr>
          <th>Avatar</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Status</th>
          <th>Cadastro</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $usuario): ?>
          <tr>
            <td>
              <figure class="image is-32x32 is-rounded">
                <img class="is-rounded" src="<?= $usuario['avatar'] ?: 'public/img/avatar.jpg' ?>" alt="Avatar" onerror="this.onerror=null;this.src='public/img/avatar.jpg'">
              </figure>
            </td>
            <td><?= htmlspecialchars($usuario['nome']) ?></td>
            <td><?= htmlspecialchars($usuario['email']) ?></td>
            <td>
              <span class="tag <?= $usuario['ativo'] ? 'is-success' : 'is-danger' ?>">
                <?= $usuario['ativo'] ? 'Ativo' : 'Inativo' ?>
              </span>
            </td>
            <td><?= date('d/m/Y', strtotime($usuario['criado_em'])) ?></td>
            <td>
              <a href="index.php?url=usuarios/editar&id=<?= $usuario['id'] ?>" class="button is-small is-light is-info">Editar</a>
              <a href="index.php?url=usuarios/deletar&id=<?= $usuario['id'] ?>" class="button is-small is-light is-danger">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
<?php include 'view/partials/footer.php'; ?>
