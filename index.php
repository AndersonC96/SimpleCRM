<?php
    // Inicia a sessão
    session_start();
    // Carrega o autoload do Composer
    require_once __DIR__ . '/../vendor/autoload.php';
    // Carrega as variáveis de ambiente do arquivo .env localizado na raiz do projeto
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    // Define uma constante para o caminho base do projeto
    define('BASE_PATH', dirname(__DIR__));
    // Configuração de exibição de erros para desenvolvimento (remover em produção)
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    // Exemplo simples de roteamento utilizando uma classe Router (implementada em app/Core/Router.php)
    // Caso não possua uma estrutura de roteamento, pode ser implementado um roteamento básico conforme abaixo:
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    switch ($requestUri) {
        case '/':
        case '/index.php':
            // Inclua a página inicial ou o controlador correspondente
            require_once BASE_PATH . '/app/Views/home.php';
            break;
        case '/login':
            require_once BASE_PATH . '/app/Views/login.php';
            break;
        // Adicione outros casos de rotas conforme a necessidade
        default:
            http_response_code(404);
            echo "Página não encontrada";
            break;
    }