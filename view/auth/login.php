<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <title>Login - NPS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" rel="stylesheet">
    <link href="public/css/auth.css" rel="stylesheet">
  </head>
  <body>
    <div class="login-box">
      <h1 class="has-text-centered">Login</h1>
      <p class="has-text-centered mb-4">Acesse o painel NPS via WhatsApp</p>
      <form method="POST" action="index.php?url=login">
        <div class="field">
          <div class="control">
            <input class="input" type="email" name="email" placeholder="E-mail" required>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="input" type="password" name="senha" placeholder="Senha" required>
          </div>
        </div>

        <div class="field">
          <div class="control">
            <button class="button is-primary" type="submit">Entrar</button>
          </div>
        </div>
      </form>
      <div class="login-footer">
        &copy; <?= date('Y') ?> Sistema NPS via WhatsApp
      </div>
    </div>
  </body>
</html>
