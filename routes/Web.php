<?php
    use Tisim\SimpleCrm\Controllers\SurveyController;
    use Tisim\SimpleCrm\Controllers\InviteController;
    use Tisim\SimpleCrm\Controllers\AuthController;
    // Captura rota limpa
    $uri = rtrim($_GET['url'] ?? '/', '/');
    switch ($uri) {
        case '':
        case '/':
            echo "<h1>Bem-vindo ao SimpleCRM</h1>";
            break;
        // ─── Autenticação ─────────────────────────────
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                (new AuthController)->login();
            } else {
                (new AuthController)->showLogin();
            }
            break;
        case 'register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                (new AuthController)->register();
            } else {
                (new AuthController)->showRegister();
            }
            break;
        case 'logout':
            (new AuthController)->logout();
            break;
        // ─── CRUD de Pesquisas ────────────────────────
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
        // ─── Envio de Convites ────────────────────────
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