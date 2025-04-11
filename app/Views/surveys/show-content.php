<div class="box">
    <h2 class="title is-4"><?= htmlspecialchars($survey->title) ?></h2>
    <p><strong>Descrição:</strong></p>
    <p><?= nl2br(htmlspecialchars($survey->description)) ?></p>
    <p class="has-text-grey mt-3">Criada em: <?= $survey->created_at ?></p>
</div>
<a href="index.php?url=surveys" class="button is-light">Voltar</a>