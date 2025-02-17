<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Gerenciamento de Usuários - Administrador";
    // Inclui os arquivos parciais do layout
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Gerenciamento de Usuários</h1>
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
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    <!-- Formulário para criar novo usuário -->
    <h2>Criar Novo Usuário</h2>
    <form action="index.php?url=admin/manage_users" method="POST" novalidate>
        <input type="hidden" name="action" value="create">
        <div class="mb-3">
            <label for="username" class="form-label">Usuário</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Digite seu usuário" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Digite sua senha" required minlength="6">
        </div>
        <button type="submit" class="btn btn-primary">Criar Usuário</button>
    </form>
    <hr>
    <!-- Lista de usuários -->
    <h2>Lista de Usuários</h2>
    <?php if (isset($users) && !empty($users)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <a href="index.php?url=admin/manage_users/edit/<?= htmlspecialchars($user['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                            <form action="index.php?url=admin/manage_users" method="POST" style="display:inline-block;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum usuário cadastrado.</p>
    <?php endif; ?>
</div>
<?php require 'app/views/partials/footer.php'; ?>