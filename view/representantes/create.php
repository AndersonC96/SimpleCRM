<?php include 'view/partials/header.php'; ?>
<h2 class="title is-4">Novo Representante</h2>
<form method="POST" action="index.php?url=representantes/store">
  <div class="field">
    <label class="label">Nome</label>
    <div class="control">
      <input class="input" type="text" name="nome" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Área de Atuação</label>
    <div class="control">
      <input class="input" type="text" name="area_atuacao" required>
    </div>
  </div>
  <div class="field is-grouped mt-4">
    <div class="control">
      <button type="submit" class="button is-success">Salvar</button>
    </div>
    <div class="control">
      <a href="index.php?url=representantes" class="button is-light">Cancelar</a>
    </div>
  </div>
</form>
<?php include 'view/partials/footer.php'; ?>