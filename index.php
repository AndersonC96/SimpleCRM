<?php
    // Inicia a sessão
    session_start();
    // Define constantes, se necessário (ex: BASE_URL)
    define('BASE_URL', '/SimpleCRM/');
    // Carrega o arquivo de configurações gerais
    require_once 'config/config.php';
    // Função simples de autoload para carregar as classes automaticamente
    spl_autoload_register(function ($class_name) {
        // Diretórios onde as classes podem estar
        $directories = [
            'app/controllers/',
            'app/models/',
            'app/helpers/',
        ];
        // Percorre os diretórios e inclui o arquivo se existir
        foreach ($directories as $directory) {
            $file = $directory . $class_name . '.php';
            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    });
    // Se houver um arquivo de rotas, pode ser incluído aqui
    require_once 'config/routes.php';
    // Roteamento simples baseado na URL
    // Exemplo: http://localhost/SimpleCRM/?url=admin/dashboard
    $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home/index';
    $urlParts = explode('/', $url);
    // Define o controlador e a ação a partir da URL
    $controllerName = ucfirst(array_shift($urlParts)) . 'Controller'; // Ex: "AdminController"
    $action = array_shift($urlParts) ?: 'index';
    // Verifica se o arquivo do controlador existe
    $controllerFile = "app/controllers/{$controllerName}.php";
        if (file_exists($controllerFile)) {
            // Instancia o controlador
            $controller = new $controllerName();
            // Verifica se o método (ação) existe no controlador
            if (method_exists($controller, $action)) {
                // Chama a ação passando os parâmetros restantes da URL
                call_user_func_array([$controller, $action], $urlParts);
            } else {
                // Método não encontrado
                echo "Método '{$action}' não encontrado no controlador '{$controllerName}'.";
            }
        } else {
            // Controlador não encontrado
            echo "Controlador '{$controllerName}' não encontrado.";
        }