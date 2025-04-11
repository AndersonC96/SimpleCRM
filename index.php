<?php
    require __DIR__ . '/vendor/autoload.php';
    use App\Controllers\HomeController;
    // Roteamento básico
    $uri = $_SERVER['REQUEST_URI'];
    if ($uri === '/' || $uri === '/index.php') {
        (new HomeController())->index();
        exit;
    }
    // adicionar mais rotas aqui
    http_response_code(404);
    echo "Página não encontrada";
?>