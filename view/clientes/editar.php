<?php include 'view/partials/header.php'; ?>
<h2 class="title is-4">Editar Cliente</h2>
<form method="POST" action="index.php?url=clientes/atualizar">
  <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
  <div class="field">
    <label class="label">Nome</label>
    <div class="control">
      <input class="input" type="text" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Telefone</label>
    <div class="control">
      <input class="input" type="text" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Email</label>
    <div class="control">
      <input class="input" type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>">
    </div>
  </div>
  <div class="field">
    <label class="label">Tags</label>
    <div class="control">
      <input class="input" type="text" name="tags" value="<?= htmlspecialchars($cliente['tags']) ?>">
    </div>
  </div>
  <div class="field">
    <label class="label">Representante</label>
    <div class="control">
      <div class="select">
        <select name="representante_id">
          <option value="">-- Selecione --</option>
          <?php foreach ($representantes as $r): ?>
            <option value="<?= $r['id'] ?>" <?= $cliente['representante_id'] == $r['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($r['nome']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
  <div class="field">
    <button class="button is-primary" type="submit">Atualizar</button>
    <a class="button" href="index.php?url=clientes">Cancelar</a>
  </div>
</form>
<?php include 'view/partials/footer.php'; ?>