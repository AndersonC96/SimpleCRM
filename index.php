<?php
    session_start();
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/config/database.php';
    use Tisim\SimpleCrm\Controllers\AuthController;
    // Captura rota atual
    $uri = rtrim($_GET['url'] ?? '/', '/');
    // Rotas públicas (acesso sem login)
    $publicRoutes = ['/', 'login', 'register'];
    // Redireciona se não estiver logado
    if (!isset($_SESSION['user_id']) && !in_array($uri, $publicRoutes)) {
        header('Location: login');
        exit;
    }
    // Roteamento principal
    require __DIR__ . '/routes/web.php';