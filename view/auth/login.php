<?php include 'view/partials/header.php'; ?>
<h2>Login</h2>
<form method="POST" action="index.php?url=login">
  <input type="email" name="email" placeholder="E-mail" required><br>
  <input type="password" name="senha" placeholder="Senha" required><br>
  <button type="submit">Entrar</button>
</form>
<?php include 'view/partials/footer.php'; ?>