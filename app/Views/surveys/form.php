<form method="POST" action="surveys/store">
    <div class="field">
        <label class="label">Título</label>
        <div class="control">
            <input class="input" type="text" name="title" required>
        </div>
    </div>

    <div class="field">
        <label class="label">Descrição</label>
        <div class="control">
            <textarea class="textarea" name="description" required></textarea>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button class="button is-success">Salvar</button>
        </div>
    </div>
</form>
