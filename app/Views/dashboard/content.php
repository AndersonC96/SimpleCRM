<div class="columns">
    <div class="column">
        <div class="box has-background-light">
            <p class="title is-4">📊 Pesquisas</p>
            <p class="subtitle is-2"><?= $totalSurveys ?></p>
        </div>
    </div>
    <div class="column">
        <div class="box has-background-light">
            <p class="title is-4">📩 Convites</p>
            <p class="subtitle is-2"><?= $totalInvites ?></p>
        </div>
    </div>
    <div class="column">
        <div class="box has-background-light">
            <p class="title is-4">✅ Respostas</p>
            <p class="subtitle is-2"><?= $totalResponses ?></p>
        </div>
    </div>
</div>

<hr>

<h2 class="title is-4">NPS por pesquisa</h2>
<table class="table is-fullwidth is-striped">
    <thead>
        <tr>
            <th>Pesquisa</th>
            <th>NPS</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($npsData as $nps): ?>
            <tr>
                <td><?= htmlspecialchars($nps['title']) ?></td>
                <td><strong><?= $nps['score'] ?></strong></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
