<?php
    /**
    * Front Controller
    *
    * Este arquivo é o ponto de entrada principal da aplicação.
    * Ele carrega as configurações iniciais, lida com a sessão,
    * inclui o roteamento e chama o controlador e ação apropriados.
    */
    // Inicia a sessão, se ainda não estiver iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Carrega o arquivo de configuração (carrega .env, define constantes, etc.)
    require_once 'config/config.php';
    // Carrega o arquivo de rotas, que contém a função route($url)
    require_once 'config/routes.php';
    try {
        // Obtém a URL passada via query string (ex: ?url=admin/dashboard)
        $url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
        // Chama a função de roteamento definida em config/routes.php
        route($url);
    } catch (Exception $e) {
        // Trata exceções lançadas pelo roteamento ou outras partes do código
        // Aqui, você podemos exibir uma página de erro 404, por exemplo, ou logar o erro
        echo "<h1>Erro de Roteamento</h1>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        // Opcionalmente, redirecionar para uma página de erro amigável:
        // header("Location: index.php?url=error/notFound");
        // exit;
    }