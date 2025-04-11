<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title><?= $title ?? 'SimpleCRM' ?></title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.0/css/bulma.min.css">
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="index.php?url=dashboard">
                    <strong>SimpleCRM</strong>
                </a>
            </div>
            <div class="navbar-menu">
                <div class="navbar-start">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="navbar-item" href="index.php?url=dashboard">Dashboard</a>
                        <a class="navbar-item" href="index.php?url=surveys">Pesquisas</a>
                    <?php endif; ?>
                </div>
                <div class="navbar-end">
                    <div class="navbar-item">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="buttons">
                                <a class="button is-light" href="index.php?url=logout">Sair</a>
                            </div>
                        <?php else: ?>
                            <div class="buttons">
                                <a class="button is-light" href="index.php?url=login">Entrar</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Conteúdo principal -->
        <section class="section">
            <div class="container">
                <h1 class="title"><?= $title ?? 'SimpleCRM' ?></h1>
                <?php if ($flash = flash()): ?>
                <div class="notification <?= $flash['type'] ?>">
                    <?= htmlspecialchars($flash['message']) ?>
                    <button class="delete" onclick="this.parentElement.remove();"></button>
                </div>
                <?php endif; ?>
                <hr>
                <?php require $content; ?>
            </div>
        </section>
    </body>
</html>