<?php if (!empty($error)): ?>
    <div class="notification is-danger"><?= $error ?></div>
<?php endif; ?>
<form method="POST" action="index.php?url=login">
    <div class="field">
        <label class="label">E-mail</label>
        <div class="control">
            <input class="input" type="email" name="email" required>
        </div>
    </div>
    <div class="field">
        <label class="label">Senha</label>
        <div class="control">
            <input class="input" type="password" name="password" required>
        </div>
    </div>
    <button class="button is-primary">Entrar</button>
</form>
<p class="mt-3">Não tem conta? <a href="index.php?url=register">Cadastre-se</a></p>