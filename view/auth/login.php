<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login - NPS System</title>
  <link href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css" rel="stylesheet">
  <style>
    body {
      background: radial-gradient(circle at center, #0e0e0e 0%, #000000 100%);
      color: #f0f0f0;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-box {
      background-color: rgba(20, 20, 20, 0.85);
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.6);
      width: 100%;
      max-width: 400px;
    }
    .login-box h1 {
      font-size: 2rem;
      margin-bottom: 0.5rem;
      color: #fff;
    }
    .login-box input {
      background-color: #111;
      border: 1px solid #333;
      color: #fff;
    }
    .login-box input::placeholder {
      color: #aaa;
    }
    .login-box .button {
      background-color: #4FAEB6;
      border: none;
      width: 100%;
    }
    .login-box .button:hover {
      background-color: #4FAEB6;
    }
    .login-footer {
      margin-top: 1rem;
      text-align: center;
      font-size: 0.9rem;
      color: #aaa;
    }
  </style>
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
