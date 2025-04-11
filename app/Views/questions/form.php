<form method="POST" action="<?= $action ?>">
    <input type="hidden" name="survey_id" value="<?= $survey->id ?>">
    <div class="field">
        <label class="label">Pergunta</label>
        <div class="control">
            <input
                class="input"
                type="text"
                name="text"
                required
                value="<?= isset($question) ? htmlspecialchars($question->text) : '' ?>"
            >
        </div>
    </div>
    <div class="field">
        <label class="label">Tipo</label>
        <div class="control">
            <div class="select">
                <select name="type" required>
                    <option value="">Selecione</option>
                    <option value="nps" <?= (isset($question) && $question->type === 'nps') ? 'selected' : '' ?>>NPS (0 a 10)</option>
                    <option value="text" <?= (isset($question) && $question->type === 'text') ? 'selected' : '' ?>>Comentário aberto</option>
                </select>
            </div>
        </div>
    </div>
    <div class="field mt-4">
        <div class="control">
            <button class="button is-primary"><?= isset($question) ? 'Salvar alterações' : 'Adicionar' ?></button>
            <a href="index.php?url=surveys/show&id=<?= $survey->id ?>" class="button is-light">Cancelar</a>
        </div>
    </div>
</form>