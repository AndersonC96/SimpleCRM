<?php include 'view/partials/header.php'; ?>
<h2 class="title is-4">Editar Usuário</h2>
<form method="POST" action="index.php?url=usuarios/update">
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
  <div class="field">
    <button class="button is-primary" type="submit">Atualizar</button>
    <a class="button" href="index.php?url=usuarios">Cancelar</a>
  </div>
</form>
<?php include 'view/partials/footer.php'; ?>