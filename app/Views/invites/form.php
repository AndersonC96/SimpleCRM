<form method="POST" action="index.php?url=invites/send">
    <input type="hidden" name="survey_id" value="<?= $survey->id ?>">
    <div class="field">
        <label class="label">Nome do Respondente</label>
        <div class="control">
            <input class="input" type="text" name="respondent_name" required>
        </div>
    </div>
    <div class="field">
        <label class="label">Canal de Envio</label>
        <div class="control">
            <div class="select">
                <select name="channel" required>
                    <option value="">Selecione</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="email">E-mail</option>
                </select>
            </div>
        </div>
    </div>
    <div class="field">
        <label class="label">Representante</label>
        <div class="control">
            <div class="select">
                <select name="representative_id" required>
                    <option value="">Selecione</option>
                    <?php foreach ($representatives as $rep): ?>
                        <option value="<?= $rep->id ?>"><?= htmlspecialchars($rep->name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="field mt-4">
        <div class="control">
            <button class="button is-primary">Enviar Convite</button>
            <a href="index.php?url=surveys/show&id=<?= $survey->id ?>" class="button is-light">Cancelar</a>
        </div>
    </div>
</form>