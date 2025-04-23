<?php include 'view/partials/header.php'; ?>
<h2 class="title is-4">Editar Usuário</h2>
<!--<form method="POST" action="index.php?url=usuarios/update">-->
<form method="POST" action="index.php?url=usuarios/update" enctype="multipart/form-data" id="form-editar-usuario">
  <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
  <div class="field">
    <label class="label">Nome</label>
    <div class="control">
      <input class="input" type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Email</label>
    <div class="control">
      <input class="input" type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Tipo</label>
    <div class="control">
      <div class="select">
        <select name="tipo" required>
          <option value="operador" <?= $usuario['tipo'] === 'operador' ? 'selected' : '' ?>>Operador</option>
          <option value="representante" <?= $usuario['tipo'] === 'representante' ? 'selected' : '' ?>>Representante</option>
          <option value="admin" <?= $usuario['tipo'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
        </select>
      </div>
    </div>
  </div>
  <div class="field">
    <label class="checkbox">
      <input type="checkbox" name="ativo" <?= $usuario['ativo'] ? 'checked' : '' ?>>
      Usuário Ativo
    </label>
  </div>
  <!-- Imagem atual -->
  <?php if (!empty($usuario['avatar'])): ?>
  <div class="mb-3 has-text-centered">
    <figure class="image is-128x128 is-inline-block">
      <img class="is-rounded" src="<?= htmlspecialchars($usuario['avatar']) ?>" alt="Avatar de <?= htmlspecialchars($usuario['nome']) ?>">
    </figure>
    <p class="is-size-7 mt-2 has-text-grey">Imagem atual</p>
  </div>
  <?php endif; ?>
  <!-- Upload de nova imagem -->
  <div class="field">
    <label class="label">Nova Imagem</label>
    <div class="control">
      <input class="input" type="file" name="avatar" accept="image/*">
    </div>
  </div>
  <!--<div class="field">
    <button class="button is-primary" type="submit">Atualizar</button>
    <a class="button" href="index.php?url=usuarios">Cancelar</a>
  </div>-->
  <div class="field is-grouped mt-4">
    <div class="control">
      <button type="submit" class="button is-success">Salvar</button>
    </div>
    <div class="control">
      <a href="index.php?url=usuarios" class="button is-light">Cancelar</a>
    </div>
  </div>
</form>
<!-- Confirmação JS -->
<script>
  document.getElementById('form-editar-usuario').addEventListener('submit', function (e) {
    if (!confirm('Deseja realmente salvar as alterações do usuário?')) {
      e.preventDefault();
    }
  });
</script>
<?php include 'view/partials/footer.php'; ?>