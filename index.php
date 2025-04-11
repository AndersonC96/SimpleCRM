<?php
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/config/database.php';
    require __DIR__ . '/routes/web.php';
    use Tisim\SimpleCrm\Controllers\SurveyController;
    // Simples roteador baseado em GET
    $uri = $_GET['url'] ?? '/';
    switch ($uri) {
        case '/':
            echo "<h1>Bem-vindo ao SimpleCRM!</h1>";
            break;
        case 'surveys':
            $controller = new SurveyController();
            $controller->index();
        break;
        default:
            http_response_code(404);
            echo "Página não encontrada.";
        }
?>