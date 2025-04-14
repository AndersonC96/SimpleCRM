<?php include 'view/partials/header.php'; ?>
<h2 class="title is-4">Nova Campanha</h2>
<form method="POST" action="index.php?url=campanhas/salvar">
  <div class="field">
    <label class="label">Nome da campanha</label>
    <div class="control">
      <input class="input" type="text" name="nome" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Data de início</label>
    <div class="control">
      <input class="input" type="date" name="data_inicio" value="<?= date('Y-m-d') ?>" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Canal</label>
    <div class="control">
      <div class="select">
        <select name="canal" required>
          <option value="whatsapp">WhatsApp</option>
          <option value="email">E-mail</option>
        </select>
      </div>
    </div>
  </div>
  <div class="field">
    <label class="label">Template</label>
    <div class="control">
      <div class="select">
        <select name="template_id" required>
          <option value="">-- Selecione --</option>
          <?php foreach ($templates as $t): ?>
            <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nome']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
  <div class="field">
    <label class="label">Clientes</label>
    <div class="control">
      <div class="select is-multiple is-fullwidth">
        <select name="clientes[]" multiple size="10" required>
          <?php foreach ($clientes as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?> - <?= $c['telefone'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <p class="help">Segure CTRL para selecionar múltiplos</p>
    </div>
  </div>
  <div class="field mt-4">
    <button class="button is-success" type="submit">Criar Campanha</button>
    <a class="button" href="index.php?url=campanhas">Cancelar</a>
  </div>
</form>
<?php include 'view/partials/footer.php'; ?>