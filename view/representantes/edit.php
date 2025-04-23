<?php include 'view/partials/header.php'; ?>
<h2 class="title is-4">Editar Representante</h2>
<form method="POST" action="index.php?url=representantes/update">
  <input type="hidden" name="id" value="<?= $representante['id'] ?>">
  <div class="field">
    <label class="label">Nome</label>
    <div class="control">
      <input class="input" type="text" name="nome" value="<?= htmlspecialchars($representante['nome']) ?>" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Área de Atuação</label>
    <div class="control">
      <input class="input" type="text" name="area_atuacao" value="<?= htmlspecialchars($representante['area_atuacao']) ?>" required>
    </div>
  </div>
  <div class="field is-grouped mt-4">
    <div class="control">
      <button type="submit" class="button is-success">Atualizar</button>
    </div>
    <div class="control">
      <a href="index.php?url=representantes" class="button is-light">Cancelar</a>
    </div>
  </div>
</form>
<?php include 'view/partials/footer.php'; ?>