<?php
    // Inicia a sessão, se necessário
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Meus Formulários - SimpleCRM";
    // Inclui os arquivos parciais do layout: header e navbar
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Meus Formulários</h1>
    <!-- Exibe mensagens de erro, se existirem -->
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach;
                  unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <!-- Exibe mensagem de sucesso, se existir -->
    <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <!-- Link para criar um novo formulário -->
    <div class="mb-3">
        <a href="index.php?url=form/create" class="btn btn-primary">Criar Novo Formulário</a>
    </div>
    <!-- Lista de formulários -->
    <?php if (isset($forms) && is_array($forms) && !empty($forms)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Conteúdo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($forms as $form): ?>
                    <tr>
                        <td><?= htmlspecialchars($form['id']) ?></td>
                        <td><?= htmlspecialchars($form['name']) ?></td>
                        <td><?= htmlspecialchars($form['content']) ?></td>
                        <td>
                            <a href="index.php?url=form/edit/<?= htmlspecialchars($form['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                            <form action="index.php?url=form/delete/<?= htmlspecialchars($form['id']) ?>" method="POST" style="display:inline-block;">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este formulário?');">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum formulário cadastrado.</p>
    <?php endif; ?>
</div>
<?php require 'app/views/partials/footer.php'; ?>