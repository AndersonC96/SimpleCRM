<?php
    use Tisim\SimpleCrm\Controllers\SurveyController;
    use Tisim\SimpleCrm\Controllers\InviteController;
    // Captura o caminho da URL, removendo barra final
    $uri = rtrim($_GET['url'] ?? '/', '/');
    switch ($uri) {
        case '':
        case '/':
            echo "<h1>Bem-vindo ao SimpleCRM</h1>";
            break;
        case 'surveys':
            (new SurveyController)->index();
            break;
        case 'surveys/create':
            (new SurveyController)->create();
            break;
        case 'surveys/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                (new SurveyController)->store();
            } else {
                echo "Método não permitido";
            }
            break;
        case 'invites/send':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                (new InviteController)->store();
            } else {
                echo "Método não permitido";
            }
            break;
        default:
            http_response_code(404);
            echo "Página não encontrada.";
    }