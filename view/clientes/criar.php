<?php include 'view/partials/header.php'; ?>
<h2 class="title is-4">Novo Cliente</h2>
<form method="POST" action="index.php?url=clientes/salvar">
  <div class="field">
    <label class="label">Nome</label>
    <div class="control">
      <input class="input" type="text" name="nome" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Telefone</label>
    <div class="control">
      <input class="input" type="text" name="telefone" placeholder="Ex: (11) 91234-5678" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Email</label>
    <div class="control">
      <input class="input" type="email" name="email">
    </div>
  </div>
  <div class="field">
    <label class="label">Tags</label>
    <div class="control">
      <input class="input" type="text" name="tags" placeholder="ex: cliente vip, oftalmo">
    </div>
  </div>
  <div class="field">
    <label class="label">Representante</label>
    <div class="control">
      <div class="select">
        <select name="representante_id">
          <option value="">-- Selecione --</option>
          <?php foreach ($representantes as $r): ?>
            <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nome']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
  <div class="field">
    <button class="button is-success" type="submit">Salvar</button>
    <a class="button" href="index.php?url=clientes">Cancelar</a>
  </div>
</form>
<?php include 'view/partials/footer.php'; ?>