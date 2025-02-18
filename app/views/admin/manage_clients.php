<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $title = "Gerenciamento de Clientes - Administrador";
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Gerenciamento de Clientes</h1>
    <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach($_SESSION['errors'] as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <!-- Formulário para criar novo cliente -->
    <h2>Criar Novo Cliente</h2>
    <form action="index.php?url=admin/manage_clients" method="POST" novalidate>
        <input type="hidden" name="action" value="create">
        <div class="mb-3">
            <label for="client_name" class="form-label">Nome do Cliente</label>
            <input type="text" name="client_name" id="client_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="client_contact" class="form-label">Contato do Cliente</label>
            <input type="text" name="client_contact" id="client_contact" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Criar Cliente</button>
    </form>
    <!-- Lista de clientes -->
    <h2>Lista de Clientes</h2>
    <?php if (isset($clients) && !empty($clients)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Contato</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= htmlspecialchars($client['id']) ?></td>
                        <td><?= htmlspecialchars($client['name']) ?></td>
                        <td><?= htmlspecialchars($client['contact']) ?></td>
                        <td>
                            <a href="index.php?url=admin/manage_clients/edit/<?= htmlspecialchars($client['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                            <form action="index.php?url=admin/manage_clients" method="POST" style="display:inline-block;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="client_id" value="<?= htmlspecialchars($client['id']) ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?');">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum cliente cadastrado.</p>
    <?php endif; ?>
</div>
<?php require 'app/views/partials/footer.php'; ?>