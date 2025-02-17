<?php
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Define o título da página para uso no header
    $title = "Gerenciamento de Campanhas - Administrador";
    // Inclui os arquivos parciais do layout (header, navbar)
    require 'app/views/partials/header.php';
    require 'app/views/partials/navbar.php';
?>
<div class="container mt-5">
    <h1>Gerenciamento de Campanhas/Pesquisas</h1>
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
    <!-- Formulário para criar nova campanha -->
    <h2>Criar Nova Campanha</h2>
    <form action="index.php?url=admin/manage_campaigns" method="POST" novalidate class="mb-4">
        <input type="hidden" name="action" value="create">
        <div class="mb-3">
            <label for="campaign_name" class="form-label">Nome da Campanha</label>
            <input type="text" name="campaign_name" id="campaign_name" class="form-control" placeholder="Digite o nome da campanha" required>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Data de Início</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">Data de Término</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Criar Campanha</button>
    </form>
    <!-- Lista de campanhas -->
    <h2>Lista de Campanhas</h2>
    <?php if (isset($campaigns) && !empty($campaigns)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Data de Início</th>
                    <th>Data de Término</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($campaigns as $campaign): ?>
                    <tr>
                        <td><?= htmlspecialchars($campaign['id']) ?></td>
                        <td><?= htmlspecialchars($campaign['name']) ?></td>
                        <td><?= htmlspecialchars($campaign['start_date']) ?></td>
                        <td><?= htmlspecialchars($campaign['end_date']) ?></td>
                        <td>
                            <a href="index.php?url=admin/manage_campaigns/edit/<?= htmlspecialchars($campaign['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                            <form action="index.php?url=admin/manage_campaigns" method="POST" style="display:inline-block;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="campaign_id" value="<?= htmlspecialchars($campaign['id']) ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta campanha?');">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma campanha cadastrada.</p>
    <?php endif; ?>
</div>
<?php require 'app/views/partials/footer.php'; ?>