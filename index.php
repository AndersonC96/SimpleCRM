<?php
    // Ativa exibição de erros (desabilite em produção)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // Carrega o autoloader do Composer
    require_once __DIR__ . '/vendor/autoload.php';
    // Carrega variáveis do .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    // Carrega o roteador
    require_once __DIR__ . '/core/Router.php';
    use App\Core\Router;
    // Instancia e define as rotas
    $router = new Router();
    // ROTAS DE AUTENTICAÇÃO
    $router->get('login', 'AuthController@login');
    $router->post('login', 'AuthController@auth');
    $router->get('logout', 'AuthController@logout');
    // ROTAS GERAIS
    $router->get('', 'DashboardController@index');
    $router->get('dashboard', 'DashboardController@index');
    // Aqui você iremos adicionar novas rotas conforme os módulos forem criados
    // Captura a URL informada via GET (?url=rota)
    $url = $_GET['url'] ?? '';
    // Roda a aplicação
    $router->run($url);