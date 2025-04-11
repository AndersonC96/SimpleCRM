<a href="surveys/create" class="button is-primary mb-3">Nova Pesquisa</a>
<table class="table is-fullwidth is-striped">
    <thead>
        <tr>
            <th>Título</th>
            <th>Descrição</th>
            <th>Criada em</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($surveys as $survey): ?>
            <tr>
                <td><?= htmlspecialchars($survey->title) ?></td>
                <td><?= htmlspecialchars($survey->description) ?></td>
                <td><?= $survey->created_at ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
