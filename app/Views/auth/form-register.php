<form method="POST" action="index.php?url=register">
    <div class="field">
        <label class="label">Nome</label>
        <div class="control">
            <input class="input" type="text" name="name" required>
        </div>
    </div>
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
    <button class="button is-success">Cadastrar</button>
</form>
<p class="mt-3">Já tem conta? <a href="index.php?url=login">Fazer login</a></p>