<?php
    /**
    * Roteamento da aplicação
    *
    * Este arquivo mapeia as URLs para os respectivos controladores e métodos,
    * fazendo validações para garantir que o controlador e a ação existam.
    */
    // Exemplo de mapeamento estático para algumas rotas específicas.
    // Você pode adicionar quantas rotas quiser nesse array.
    $routes = [
        'auth/login'       => ['controller' => 'AuthController', 'action' => 'login'],
        'auth/logout'      => ['controller' => 'AuthController', 'action' => 'logout'],
        'admin/dashboard'  => ['controller' => 'AdminController', 'action' => 'dashboard'],
        'user/dashboard'   => ['controller' => 'UserController', 'action' => 'dashboard'],
        // ...
    ];
    /**
    * Função principal de roteamento.
    * Recebe a URL requisitada e, se existir no array de rotas estáticas, usa o mapeamento;
    * caso contrário, tenta interpretar a URL no formato controller/action/param1/param2/etc.
    *
    * @param string $url A rota requisitada (ex: "admin/dashboard" ou "auth/login").
    * @throws Exception Se o controlador ou método (ação) não existir.
    */
    function route($url) {
        global $routes;
        // Remove espaços e barras extras (ex: "/admin/dashboard/")
        $url = trim($url, '/');
        // Se a URL estiver vazia, define uma rota padrão (ex: "home/index")
        if (empty($url)) {
            $url = 'home/index';
        }
        // Verifica se a rota existe no array $routes (mapeamento estático)
        if (isset($routes[$url])) {
            $controllerName = $routes[$url]['controller'];
            $actionName = $routes[$url]['action'];
            $params = [];
        } else {
            // Caso não esteja no array, tenta extrair o controller, ação e parâmetros
            $parts = explode('/', $url);
            // O primeiro segmento é o nome do controller (ex: "admin" => "AdminController")
            $controllerName = ucfirst($parts[0]) . 'Controller';
            // O segundo segmento, se existir, é o método (ação). Caso contrário, define como "index"
            $actionName = $parts[1] ?? 'index';
            // O restante dos segmentos são parâmetros
            $params = array_slice($parts, 2);
        }
        // Monta o caminho para o arquivo do controller
        $controllerFile = 'app/controllers/' . $controllerName . '.php';
        // Valida se o arquivo do controller existe
        if (!file_exists($controllerFile)) {
            throw new Exception("Controlador '{$controllerName}' não encontrado no caminho '{$controllerFile}'.");
        }
        // Inclui o arquivo do controller
        require_once $controllerFile;
        // Verifica se a classe do controller realmente existe
        if (!class_exists($controllerName)) {
            throw new Exception("Classe '{$controllerName}' não encontrada no arquivo '{$controllerFile}'.");
        }
        // Instancia o controller
        $controller = new $controllerName();
        // Verifica se o método (ação) existe no controller
        if (!method_exists($controller, $actionName)) {
            throw new Exception("Método '{$actionName}' não encontrado no controlador '{$controllerName}'.");
        }
        // Chama a ação, passando os parâmetros adicionais
        return call_user_func_array([$controller, $actionName], $params);
    }