<?php
    // Mostra erros no ambiente de desenvolvimento (desativar em produção)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // Inicia sessão se ainda não estiver ativa
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    // Autoload do Composer
    require_once __DIR__ . '/vendor/autoload.php';
    // Carrega variáveis do .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    // Define timezone do sistema (vindo do config/app.php)
    $config = require __DIR__ . '/config/app.php';
    date_default_timezone_set($config['timezone'] ?? 'America/Sao_Paulo');
    // Instancia o roteador
    require_once __DIR__ . '/core/Router.php';
    use App\Core\Router;
    $router = new Router();
    // Definição direta das rotas (poderia ser externa via config/routes.php)
    // ROTAS DE AUTENTICAÇÃO
    $router->get('login', 'AuthController@login');
    $router->post('login', 'AuthController@auth');
    $router->get('logout', 'AuthController@logout');
    // ROTAS GERAIS
    $router->get('', 'DashboardController@index');
    $router->get('dashboard', 'DashboardController@index');
    // Rota dinâmica por parâmetro (?url=rota)
    $url = $_GET['url'] ?? '';
    //$router->run($url);
    $routes = require __DIR__ . '/config/routes.php';
    foreach ($routes['GET'] as $path => $handler) {
        $router->get($path, $handler);
    }
    foreach ($routes['POST'] as $path => $handler) {
        $router->post($path, $handler);
    }
    $router->run($url);