<?php
    declare(strict_types=1);
    // Carregar o autoload do Composer
    require __DIR__ . '/../vendor/autoload.php';
    use Dotenv\Dotenv;
    use Illuminate\Database\Capsule\Manager as Capsule;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Route;
    use Symfony\Component\Routing\RouteCollection;
    use Symfony\Component\Routing\RequestContext;
    use Symfony\Component\Routing\Matcher\UrlMatcher;
    use Symfony\Component\Routing\Exception\ResourceNotFoundException;
    // Carregar variáveis de ambiente do arquivo .env
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    // Configurar o Eloquent ORM para conexão com o MySQL
    $capsule = new Capsule;
    $capsule->addConnection([
        'driver'    => $_ENV['DB_DRIVER']    ?? 'mysql',
        'host'      => $_ENV['DB_HOST']      ?? '127.0.0.1',
        'database'  => $_ENV['DB_DATABASE']  ?? 'crm',
        'username'  => $_ENV['DB_USERNAME']  ?? 'root',
        'password'  => $_ENV['DB_PASSWORD']  ?? '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);
    // Disponibiliza o Capsule globalmente e inicializa o Eloquent
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    // Cria a instância da requisição
    $request = Request::createFromGlobals();
    // Definir as rotas da aplicação
    $routes = new RouteCollection();
    // Rota para a página de login
    $routes->add('login', new Route('/login', [
        '_controller' => 'App\\Controllers\\AuthController::login'
    ]));
    // Rota para o painel de controle (dashboard)
    $routes->add('dashboard', new Route('/dashboard', [
        '_controller' => 'App\\Controllers\\DashboardController::index'
    ]));
    // Outras rotas podem ser adicionadas conforme o desenvolvimento do sistema,
    // como rotas para gestão de campanhas, pesquisas, usuários, etc.
    // Configurar o contexto da requisição para o roteador
    $context = new RequestContext();
    $context->fromRequest($request);
    // Inicializar o matcher de rotas
    $matcher = new UrlMatcher($routes, $context);
    try {
        // Tenta encontrar uma rota que corresponda à URL acessada
        $parameters = $matcher->match($request->getPathInfo());
        // Extrai a informação do controlador (classe e método) definido na rota
        $controllerAction = explode('::', $parameters['_controller']);
        $controllerClass  = $controllerAction[0];
        $controllerMethod = $controllerAction[1];
        // Remove o parâmetro _controller do array de parâmetros
        unset($parameters['_controller']);
        // Instancia o controlador e chama o método apropriado,
        // passando a requisição e os parâmetros obtidos da rota
        $controller = new $controllerClass();
        $response = call_user_func_array([$controller, $controllerMethod], [$request, $parameters]);
    } catch (ResourceNotFoundException $e) {
        // Se a rota não for encontrada, retorna uma resposta 404
        $response = new Response('Página não encontrada', 404);
    } catch (Exception $e) {
        // Para quaisquer outros erros, retorna uma resposta 500
        $response = new Response('Ocorreu um erro: ' . $e->getMessage(), 500);
    }
    // Envia a resposta para o navegador
    $response->send();