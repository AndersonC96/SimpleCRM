<?php include 'view/partials/header.php'; ?>
<h2 class="title is-4">Novo Usuário</h2>
<form action="index.php?url=usuarios/store" method="POST" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
  <div class="field">
    <label class="label">Nome</label>
    <div class="control">
      <input class="input" type="text" name="nome" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Email</label>
    <div class="control">
      <input class="input" type="email" name="email" required>
    </div>
  </div>
  <div class="field">
    <label class="label">Senha</label>
    <div class="control">
      <input class="input" type="password" name="senha" required minlength="6">
    </div>
  </div>
  <!-- Campo de Avatar -->
  <div class="field">
    <label class="label">Foto de Perfil</label>
    <div class="control">
      <input type="file" name="avatar" accept="image/*" onchange="previewAvatar(this)" class="input">
    </div>
    <figure class="image is-128x128 mt-2">
      <img id="avatarPreview" src="public/img/avatar.jpg" class="is-rounded">
    </figure>
  </div>
  <div class="field">
    <label class="label">Tipo</label>
    <div class="control">
      <div class="select">
        <select name="tipo" required>
          <!--<option value="operador">Operador</option>
          <option value="representante">Representante</option>-->
          <option value="admin">Administrador</option>
        </select>
      </div>
    </div>
  </div>
  <div class="field">
    <label class="checkbox">
      <input type="checkbox" name="ativo" checked>
      Usuário Ativo
    </label>
  </div>
  <div class="field">
    <button class="button is-success" type="submit">Salvar</button>
    <a class="button" href="index.php?url=usuarios">Cancelar</a>
  </div>
</form>
<?php include 'view/partials/footer.php'; ?>