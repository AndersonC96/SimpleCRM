<a href="index.php?url=surveys/create" class="button is-primary mb-4">Nova Pesquisa</a>
<table class="table is-fullwidth is-striped">
    <thead>
        <tr>
            <th>Título</th>
            <th>Descrição</th>
            <th>Criada em</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($surveys as $survey): ?>
            <tr>
                <td><?= htmlspecialchars($survey->title) ?></td>
                <td><?= htmlspecialchars($survey->description) ?></td>
                <td><?= $survey->created_at ?></td>
                <td>
                    <a class="button is-small is-info" href="index.php?url=surveys/show&id=<?= $survey->id ?>">Ver</a>
                    <a class="button is-small is-danger" href="index.php?url=surveys/delete&id=<?= $survey->id ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>